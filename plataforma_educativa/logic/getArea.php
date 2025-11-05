<?php
    include_once("../config/db.php");

    $sql = "SELECT id_area_matematica, descripcion FROM tbl_area_matematica";
    $result = $conn->query($sql);

    $areas = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $areas[] = $row;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($areas);

    $conn->close();
?>
