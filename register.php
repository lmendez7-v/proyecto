<?php include("./layout/headerLogin.php"); ?>
    <main class="registro-page">
      <section class="hero-section">
        <h1>📝 Crear Cuenta</h1>
        <p>
          Regístrate para comenzar a aprender y divertirte con las matemáticas.
        </p>
      </section>

      <section class="form-section">
        <form class="form-container">
          <label for="nombres_usuario">Nombres:</label>
          <input
            type="text"
            id="nombres_usuario"
            name="nombres_usuario"
            placeholder="Ej. Juan Carlos"
            required
          />

          <label for="apellidos_usuario">Apellidos:</label>
          <input
            type="text"
            id="apellidos_usuario"
            name="apellidos_usuario"
            placeholder="Ej. Pérez López"
            required
          />

          <label for="usuario">Usuario:</label>
          <input
            type="text"
            id="usuario"
            name="usuario"
            placeholder="Nombre de usuario"
            required
          />

          <label for="clave">Contraseña:</label>
          <input
            type="password"
            id="clave"
            name="clave"
            placeholder="Crea una contraseña"
            required
          />

          <button type="submit">Registrarse</button>

          <p class="redirect">
            ¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a>
          </p>
        </form>
      </section>
    </main>

    <script src="./assets/js/register.js"></script>
    <?php include("./layout/footer.php"); ?>
