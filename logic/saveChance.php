<?php
    session_start();
    header('Content-Type: application/json');
    include("../config/db.php");

    if (!isset($_SESSION['id_usuario'])) {
        echo json_encode(["error" => "Usuario no autenticado."]);
        exit;
    }

    $id_usuario = $_SESSION['id_usuario'];
    $id_enunciado = intval($_POST['id_enunciado'] ?? 0);
    $respuesta_ingresada = trim($_POST['respuesta_ingresada'] ?? '');

    if ($id_enunciado <= 0 || $respuesta_ingresada === '') {
        echo json_encode(["error" => "Datos incompletos."]);
        exit;
    }

    // Traer la respuesta correcta desde BD
    $stmt = $conn->prepare("SELECT respuesta_esperada FROM tbl_enunciado_ejercicio WHERE id_enunciado_ejercicio = ?");
    $stmt->bind_param("i", $id_enunciado);
    $stmt->execute();
    $result = $stmt->get_result();
    $enunciado = $result->fetch_assoc();

    if (!$enunciado) {
        echo json_encode(["error" => "Enunciado no encontrado."]);
        exit;
    }

    $respuesta_correcta = trim($enunciado['respuesta_esperada']);
    $es_correcta = false;

    // Verificar si ambas respuestas parecen numéricas
    if (is_numeric($respuesta_ingresada) && is_numeric($respuesta_correcta)) {
        $num_ingresado = floatval($respuesta_ingresada);
        $num_correcto = floatval($respuesta_correcta);

        //Permitir un margen de error de 0.001 (por si hay decimales)
        if (abs($num_ingresado - $num_correcto) < 0.001) {
            $es_correcta = true;
        }
    } else {
        //Si no son numéricas, comparar texto (sin importar mayúsculas o espacios extra)
        $es_correcta = (strcasecmp(trim($respuesta_ingresada), trim($respuesta_correcta)) === 0);
    }

    // Verificar si ya existe un registro de ese enunciado para este usuario
    $stmt = $conn->prepare("SELECT id_enunciado_usuario_nota, no_intentos, punteo FROM tbl_enunciado_usuario_nota WHERE id_usuario = ? AND id_Enunciado_ejercicio = ?");
    $stmt->bind_param("ii", $id_usuario, $id_enunciado);
    $stmt->execute();
    $result = $stmt->get_result();
    $registro = $result->fetch_assoc();

    if ($registro) {
        // 🔹 Ya existe → actualizar intentos
        $id_nota = $registro['id_enunciado_usuario_nota'];
        $nuevo_intento = $registro['no_intentos'] + 1;

        //  Si acierta, recalculamos punteo
        $punteo = $registro['punteo'];
        if ($es_correcta) {
            $punteo = round(100 / $nuevo_intento, 2);
        }

        //  Actualizar cabecera
        $update = $conn->prepare("UPDATE tbl_enunciado_usuario_nota SET no_intentos = ?, punteo = ? WHERE id_enunciado_usuario_nota = ?");
        $update->bind_param("idi", $nuevo_intento, $punteo, $id_nota);
        $update->execute();

        //  Guardar detalle
        $insertDetalle = $conn->prepare("INSERT INTO tbl_respuesta_enunciado (id_enunciado_usuario_nota, respuesta_ingresada) VALUES (?, ?)");
        $insertDetalle->bind_param("is", $id_nota, $respuesta_ingresada);
        $insertDetalle->execute();

        echo json_encode([
            "status" => "ok",
            "msg" => $es_correcta ? "✅ Respuesta correcta" : "❌ Respuesta incorrecta",
            "correcta" => $es_correcta,
            "intentos" => $nuevo_intento,
            "punteo" => $punteo
        ]);

    } else {
        // No existe → crear nuevo registro
        $punteo = $es_correcta ? 100.00 : 0.00;
        $no_intentos = 1;

        $insertCab = $conn->prepare("INSERT INTO tbl_enunciado_usuario_nota (id_usuario, id_Enunciado_ejercicio, no_intentos, punteo) VALUES (?, ?, ?, ?)");
        $insertCab->bind_param("iiid", $id_usuario, $id_enunciado, $no_intentos, $punteo);
        $insertCab->execute();

        $id_nota = $conn->insert_id;

        // Guardar detalle
        $insertDet = $conn->prepare("INSERT INTO tbl_respuesta_enunciado (id_enunciado_usuario_nota, respuesta_ingresada) VALUES (?, ?)");
        $insertDet->bind_param("is", $id_nota, $respuesta_ingresada);
        $insertDet->execute();

        echo json_encode([
            "status" => "ok",
            "msg" => $es_correcta ? "✅ Respuesta correcta" : "❌ Respuesta incorrecta",
            "correcta" => $es_correcta,
            "intentos" => $no_intentos,
            "punteo" => $punteo
        ]);
    }
?>
