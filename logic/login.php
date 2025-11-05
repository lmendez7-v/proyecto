<?php
session_start();
header('Content-Type: application/json');
include_once("../config/db.php");

$response = ["success" => false, "message" => "Error desconocido."];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
    $clave = mysqli_real_escape_string($conn, $_POST['clave']);
    
    $sql = "SELECT * FROM tbl_usuario WHERE usuario = '$usuario'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Comparación simple (sin hash, para pruebas)
        if ($row['clave'] === $clave) {
            $_SESSION['id_usuario'] = $row['id_usuario'];
            $_SESSION['nombres_usuario'] = $row['nombres_usuario'];
            $_SESSION['usuario'] = $row['usuario'];

            $response = [
                "success" => true,
                "message" => "Inicio de sesión correcto",
                "nombre" => $row['nombres_usuario']
            ];
        } else {
            $response = ["success" => false, "message" => "Contraseña incorrecta"];
        }
    } else {
        $response = ["success" => false, "message" => "Usuario no encontrado"];
    }
}

echo json_encode($response);
exit;
?>
