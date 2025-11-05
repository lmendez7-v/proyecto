<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['id_usuario'])) {
    echo json_encode([
        "logged" => true,
        "nombre" => $_SESSION['nombre_usuario']
    ]);
} else {
    echo json_encode([
        "logged" => false
    ]);
}
?>
