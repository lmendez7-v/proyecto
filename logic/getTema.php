<?php
    include_once("../config/db.php");

    $id_area = $_GET['id_area'] ?? 0;

    $sql = "SELECT id_tema_modulo, descripcion_tema_modulo FROM tbl_tema_modulo WHERE id_area_matematica = ? AND estado = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_area);
    $stmt->execute();
    $result = $stmt->get_result();

    $temas = [];

    while ($row = $result->fetch_assoc()) {
        $temas[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($temas);

    $stmt->close();
    $conn->close();
?>
