$(document).ready(function () {
  $(".form-container").on("submit", function (e) {
    e.preventDefault();

    const data = {
      nombres_usuario: $("#nombres_usuario").val(),
      apellidos_usuario: $("#apellidos_usuario").val(),
      usuario: $("#usuario").val(),
      clave: $("#clave").val(),
    };

    $.ajax({
      url: "./logic/register.php",
      type: "POST",
      dataType: "json",
      data: data,
      beforeSend: function () {
        $(".redirect").html(
          "<p style='color:blue;'>Registrando usuario...</p>"
        );
      },
      success: function (response) {
        if (response.success) {
          $(".redirect").html(
            "<p style='color:green;'>✅ " + response.message + "</p>"
          );
          setTimeout(() => {
            window.location.href = "login.php";
          }, 1200);
        } else {
          $(".redirect").html(
            "<p style='color:red;'>❌ " + response.message + "</p>"
          );
        }
      },
      error: function (xhr, status, error) {
        console.log("Error AJAX:", xhr.responseText);
        $(".redirect").html(
          "<p style='color:red;'>Error en la conexión: " + error + "</p>"
        );
      },
    });
  });
});
