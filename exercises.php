<?php include("./layout/auth.php"); ?>
<?php include("./layout/header.php"); ?>
<main class="ejercicios-page">

        <section class="ejercicio-header">
            <h1 class="page-title">🌟 ¡Es Hora de Practicar!</h1>
            <p>Selecciona el area matemática que y demuestra tus habilidades. ¡Cada respuesta correcta te acerca a ser un maestro!</p>
        </section>
        <section class="table-selection" id="areasContainer">

        </section>
        <br>
        <section class="table-selection" id="temasContainer">

        </section>
        <br>
        <section class="progress-and-selection">
            
            <div class="table-selection">
                <h2>Selecciona el enunciado a resolver:👇</h2>
                
                <div class="game-mode-selection">
                    <!-- <button id="mode-ordered" class="mode-btn selected" data-mode="ordered">🧮 En Orden</button>
                    <button id="mode-random" class="mode-btn" data-mode="random">🎲 Al Azar</button> -->
                </div>
                
               
            </div>
        </section>

        <section class="exercise-area">
            <h2>Respuesta <span id="current-table-number">...</span></h2>
            
            <div id="question-container" class="question-box">
                <p class="initial-message">Selecciona una tabla para empezar a practicar y verás las preguntas aquí.</p>
            </div>
            
        </section>

    </main>

<script src="./assets/js/ejercicios.js"></script>
<?php include("./layout/footer.php"); ?>