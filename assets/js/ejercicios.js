$(document).ready(function () {
  const $areasContainer = $("#areasContainer");
  const $temasContainer = $("#temasContainer");
  const $tableButtons = $(".game-mode-selection");
  const $questionContainer = $("#question-container");

  // 🔹 Cargar áreas
  $.ajax({
    url: "./logic/getArea.php",
    method: "GET",
    dataType: "json",
    success: function (areas) {
      $areasContainer.empty();
      areas.forEach((area) => {
        $areasContainer.append(`
          <button class="area-btn" data-id="${area.id_area_matematica}">
            ${area.descripcion}
          </button>
        `);
      });
    },
    error: function () {
      alert("Error cargando las áreas matemáticas.");
    },
  });

  // 🔹 Cargar temas al seleccionar área
  $(document).on("click", ".area-btn", function () {
    const idArea = $(this).data("id");
    $.ajax({
      url: "./logic/getTema.php",
      method: "GET",
      data: { id_area: idArea },
      dataType: "json",
      success: function (temas) {
        $temasContainer.empty();
        $tableButtons.empty();
        temas.forEach((t) => {
          $temasContainer.append(`
            <button class="tema-btn" data-id="${t.id_tema_modulo}">
              ${t.descripcion_tema_modulo}
            </button>
          `);
        });
      },
      error: function () {
        alert("Error cargando los temas del área seleccionada.");
      },
    });
  });

  // Mostrar enunciados como botones al elegir tema
  $(document).on("click", ".tema-btn", function () {
    const idTema = $(this).data("id");
    $.ajax({
      url: "./logic/getEnunciado.php",
      method: "GET",
      data: { id_tema: idTema },
      dataType: "json",
      success: function (enunciados) {
        $tableButtons.empty();
        if (enunciados.length === 0) {
          $tableButtons.html(
            "<p>No hay ejercicios disponibles para este tema.</p>"
          );
          return;
        }
        console.log(enunciados);
        enunciados.forEach((e) => {
          const bloqueado = e.bloqueado == 1 ? "locked" : "";

          $tableButtons.append(`
            <button class="mode-btn  ${bloqueado}" 
                    data-id="${e.id_enunciado_ejercicio}" 
                    data-enunciado="${e.enunciado}" 
                    data-correcta="${e.respuesta_esperada}"
                   
                    >
              ${e.enunciado}
            </button>
          `);
        });
      },
      error: function () {
        alert("Error cargando los ejercicios.");
      },
    });
  });

  // 🔹 Mostrar solo el enunciado seleccionado
  $(document).on("click", ".mode-btn", function () {
    const enunciado = $(this).data("enunciado");
    const correcta = $(this).data("correcta");
    const id = $(this).data("id");

    $questionContainer.html(`
      <div class="math-question">
        <span>${enunciado}</span>
        <div>
          <input type="text" class="user-answer" id="answer-${id}" data-idRespuesta="${id}" placeholder="Tu respuesta" />
          <button class="btn-check" data-correcta="${correcta}" data-id="${id}">
            Comprobar
          </button>
        </div>
        <div class="feedback" id="feedback-${id}"></div>
      </div>
    `);
  });

  $(document).on("click", ".btn-check", function () {
    const $input = $(this).siblings(".user-answer");
    const valor = $input.val().trim();
    const id = $input.data("idrespuesta");
    const $feedback = $(`#feedback-${id}`);

    if (!valor) {
      alert("Por favor, ingresa una respuesta antes de comprobar.");
      return;
    }

    console.log(id);
    console.log(valor);

    $.ajax({
      url: "./logic/saveChance.php",
      method: "POST",
      dataType: "json",
      data: {
        id_enunciado: parseFloat(id),
        respuesta_ingresada: parseFloat(valor),
      },
      success: function (resp) {
        if (resp.error) {
          alert(resp.error);
          return;
        }

        if (resp.correcta) {
          $feedback
            .html(`✅ ¡Correcto!<br><small>Punteo: ${resp.punteo}</small>`)
            .addClass("correct")
            .removeClass("incorrect");
        } else {
          $feedback
            .html("❌ Respuesta incorrecta. Intenta nuevamente.")
            .addClass("incorrect")
            .removeClass("correct");
        }
      },
      error: function (xhr, status, err) {
        console.error(err);
        alert("Error al registrar el intento.");
      },
    });
  });

  // Al escribir un resultado nuevo limpiar el resultado
  $(document).on("input", ".user-answer", function () {
    const id = $(this).data("idrespuesta");
    const $feedback = $(`#feedback-${id}`);
    $feedback.text("").removeClass("correct incorrect");
  });
});
