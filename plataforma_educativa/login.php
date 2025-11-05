<?php include("./layout/headerLogin.php"); ?>
<main class="login-page">
    <section class="hero-section">
        <div>
            <h1>🔐 Iniciar Sesión </h1>
            <h4>¡Aprende Jugando!</h4>
        </div> 
        <h4>Bienvenido a “Multiplica la Diversión”. Ingresa con tu usuario y contraseña.</h4>
    </section>

    <section class="form-section">
        <form class="form-container" id="loginForm">
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" placeholder="Ingresa tu usuario" required>

            <label for="clave">Contraseña:</label>
            <input type="password" id="clave" name="clave" placeholder="Ingresa tu contraseña" required>

            <button type="submit">Iniciar Sesión</button>
            <p id="msg"></p>

            <p class="redirect">¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
        </form>
    </section>
</main>

    <footer>
        <p>&copy; 2025 Proyecto de Fin de Curso. Multiplicando la Diversión.</p>
    </footer>
    <script src="./assets/js/login.js"></script>

</body>
</html>
