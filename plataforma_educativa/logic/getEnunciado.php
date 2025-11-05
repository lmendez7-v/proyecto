<?php
    include_once("../config/db.php");
    session_start();

    $id_tema = $_GET['id_tema'] ?? 0;
    $id_usuario = $_SESSION['id_usuario'] ?? 0;

    $sql = "
        SELECT 
            e.id_enunciado_ejercicio,
            e.enunciado,
            e.respuesta_esperada,
            CASE 
                WHEN EXISTS (
                    SELECT 1
                    FROM tbl_enunciado_usuario_nota n
                    INNER JOIN tbl_respuesta_enunciado r 
                        ON n.id_enunciado_usuario_nota = r.id_enunciado_usuario_nota
                    WHERE 
                        n.id_usuario = ?
                        AND n.id_Enunciado_ejercicio = e.id_enunciado_ejercicio
                        AND CAST(r.respuesta_ingresada AS DECIMAL(10,2)) = CAST(e.respuesta_esperada AS DECIMAL(10,2))
                ) 
                THEN 1 
                ELSE 0 
            END AS bloqueado
        FROM tbl_enunciado_ejercicio e
        WHERE e.id_tema_modulo = ?
        ORDER BY e.respuesta_esperada asc;
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_usuario, $id_tema);
    $stmt->execute();
    $result = $stmt->get_result();

    $enunciados = [];

    while ($row = $result->fetch_assoc()) {
        $enunciados[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($enunciados);

    $stmt->close();
    $conn->close();
?>
