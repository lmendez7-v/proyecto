$(document).ready(function () {
  const $barra = $("#current-progress-bar");
  const $porcentajeTexto = $("#progress-percentage");
  const $detalle = $("#completed-count");
  const $feedback = $("#progress-feedback");

  $.ajax({
    url: "./logic/getProccess.php",
    method: "GET",
    dataType: "json",
    success: function (data) {
      const ejerciciosCompletados = data.correctos;
      const totalEjercicios = data.total;
      const porcentaje = data.porcentaje;

      // Función de color dinámico
      function colorProgreso(p) {
        if (p < 30) return "#ff4d4d"; // rojo
        if (p < 70) return "#ffc107"; // amarillo
        return "#4caf50"; // verde
      }

      // Animar barra
      let progresoActual = 0;
      const intervalo = setInterval(() => {
        if (progresoActual >= porcentaje) {
          clearInterval(intervalo);
        } else {
          progresoActual++;
          $barra.css({
            width: progresoActual + "%",
            backgroundColor: colorProgreso(progresoActual),
          });
          $porcentajeTexto.text(progresoActual + "%");
        }
      }, 15);

      // Actualizar texto de detalle
      $detalle.text(
        `${ejerciciosCompletados}/${totalEjercicios} ejercicios completados.`
      );

      // Mensaje motivacional
      if (porcentaje === 0) {
        $feedback.text("💪 ¡Comienza a practicar para ver tus avances!");
      } else if (porcentaje < 40) {
        $feedback.text("🔥 ¡Sigue así, vas por buen camino!");
      } else if (porcentaje < 80) {
        $feedback.text("🚀 ¡Excelente trabajo, continúa avanzando!");
      } else {
        $feedback.text(
          "🎉 ¡Impresionante! ¡Has completado casi todos los ejercicios!"
        );
      }
    },
    error: function () {
      console.error("Error al obtener el progreso del usuario.");
    },
  });
});
