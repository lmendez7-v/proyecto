<?php
    include_once("../config/db.php");
    session_start();

    $id_usuario = $_SESSION['id_usuario'] ?? 0;

    //Total de ejercicios existentes
    $sql_total = "SELECT COUNT(*) AS total FROM tbl_enunciado_ejercicio";
    $res_total = $conn->query($sql_total);
    $total = $res_total->fetch_assoc()['total'] ?? 0;

    // Total de ejercicios contestados correctamente
    $sql_correctos = "
        SELECT COUNT(DISTINCT e.id_enunciado_ejercicio) AS correctos
        FROM tbl_enunciado_ejercicio e
        INNER JOIN tbl_enunciado_usuario_nota n 
            ON e.id_enunciado_ejercicio = n.id_Enunciado_ejercicio
        INNER JOIN tbl_respuesta_enunciado r 
            ON n.id_enunciado_usuario_nota = r.id_enunciado_usuario_nota
        WHERE 
            n.id_usuario = ?
            AND CAST(r.respuesta_ingresada AS DECIMAL(10,2)) = CAST(e.respuesta_esperada AS DECIMAL(10,2))
    ";

    $stmt = $conn->prepare($sql_correctos);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $res_correctos = $stmt->get_result();
    $correctos = $res_correctos->fetch_assoc()['correctos'] ?? 0;

    // 🧮 Calcular porcentaje
    $porcentaje = ($total > 0) ? round(($correctos / $total) * 100) : 0;

    // 📤 Devolver como JSON
    header('Content-Type: application/json');
    echo json_encode([
        "total" => $total,
        "correctos" => $correctos,
        "porcentaje" => $porcentaje
    ]);

    $stmt->close();
    $conn->close();
?>
