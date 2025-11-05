$(document).ready(function () {
  $("#loginForm").on("submit", function (e) {
    e.preventDefault();

    const usuario = $("#usuario").val();
    const clave = $("#clave").val();

    $.ajax({
      url: "./logic/login.php",
      type: "POST",
      dataType: "json",
      data: { usuario: usuario, clave: clave },
      beforeSend: function () {
        $("#msg").text("Verificando...");
      },
      success: function (response) {
        console.log(response);

        if (response.success == true) {
          $("#msg").text(`${response.message}`);
          location.assign("./index.php");
        } else {
          $("#msg").text(`${response.message}...`);
        }
      },
      error: function (xhr, status, error) {
        $("#msg")
          .css("color", "red")
          .text("Error en la conexión: " + error);
      },
    });
  });
});
