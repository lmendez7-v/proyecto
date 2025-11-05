<?php
session_start();
header('Content-Type: application/json');
include_once("../config/db.php");

$response = ["success" => false, "message" => "Error desconocido."];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombres = mysqli_real_escape_string($conn, $_POST['nombres_usuario']);
    $apellidos = mysqli_real_escape_string($conn, $_POST['apellidos_usuario']);
    $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
    $clave = mysqli_real_escape_string($conn, $_POST['clave']);

    // Verificar si el usuario ya existe
    $checkQuery = "SELECT * FROM tbl_usuario WHERE usuario = '$usuario'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        $response = ["success" => false, "message" => "El usuario ya existe."];
    } else {
        // Insertar nuevo usuario
        $insertQuery = "INSERT INTO tbl_usuario (nombres_usuario, apellidos_usuario, usuario, clave)
                        VALUES ('$nombres', '$apellidos', '$usuario', '$clave')";

        if (mysqli_query($conn, $insertQuery)) {
            $response = ["success" => true, "message" => "Usuario registrado correctamente."];
        } else {
            $response = ["success" => false, "message" => "Error al registrar: " . mysqli_error($conn)];
        }
    }
}

echo json_encode($response);
exit;
?>
