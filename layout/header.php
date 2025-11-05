<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🚀 Multiplica la Diversión - ¡Aprende Jugando!</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

</head>
<body>

<header class="main-header">
    <nav class="navbar">
        <a href="index.php" class="logo">🚀 MAT-WEB</a>

        <?php if (isset($_SESSION['nombres_usuario'])): ?>
            <!-- Si la sesión está activa -->
            <div class="user-info">
                <span>👋 Bienvenido-- <strong><?php echo htmlspecialchars($_SESSION['nombres_usuario']); ?></strong></span>
            </div>

            <div class="nav-links">
                <a href="index.php" class="nav-link">Inicio</a>
                <a href="exercises.php" class="nav-link">Aprendizaje</a>
                <a href="about.php" class="nav-link">Acerca de</a>    
                <a href="profile.php" class="nav-link">Perfil</a>
                <a href="./logic/closeSession.php" class="nav-link logout">Cerrar sesión</a>
            </div>

        <?php else: ?>
            <!-- Si NO hay sesión activa -->
            <div class="nav-links">
                <a href="index.php" class="nav-link">Inicio</a>
                <a href="exercises.php" class="nav-link">Aprendizaje</a>

                <a href="login.php" class="nav-link">Iniciar sesión</a>
                <a href="register.php" class="nav-link">Registrarse</a>
                <a href="about.php" class="nav-link">Acerca de</a>
            </div>
        <?php endif; ?>
    </nav>
</header>

