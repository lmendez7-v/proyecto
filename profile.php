<?php include("./layout/auth.php"); ?>
<?php include("./layout/header.php"); ?>
<div class="progress-section">
    <div class="progress-card">
        <h2>📈 Mi Progreso</h2>
        <p class="progress-subtitle">Monitorea tus avances en los ejercicios matemáticos</p>

        <div class="progress-display">

            <div class="progress-bar-container">
                <div id="current-progress-bar" class="progress-bar" style="width: 0%;"></div>
            </div>

            <p class="progress-detail" id="completed-count">0/0 ejercicios completados.</p>

            <div class="progress-feedback" id="progress-feedback">
                💪 ¡Comienza a practicar para ver tus avances!
            </div>
        </div>
    </div>
</div>

<script src="assets/js/profile.js"></script>
<?php include("./layout/footer.php"); ?>
