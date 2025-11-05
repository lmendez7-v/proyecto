<?php
    $db_host = 'localhost';
    $db_user = 'root';
    $db_password = 'root';
    $db_db = 'db_plataforma_educativa_umg';

    $conn = new mysqli($db_host, $db_user, $db_password, $db_db);

    if ($conn->connect_error) {
        die(json_encode([
            "success" => false,
            "message" => "Error de conexión a la base de datos: " . $conn->connect_error
        ]));
    }

?>
