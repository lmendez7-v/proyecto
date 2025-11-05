<?php

    session_start();

    // Validar que haya sesión activa
    if (!isset($_SESSION['id_usuario'])) {
        header("Location: ./login.php");
        exit();
    }
?>