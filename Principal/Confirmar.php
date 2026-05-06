<?php
include("../Includes/conexion.inc");
include("../Includes/funciones.php");

$mensaje = "";
$folder = "Principal";
$pestaña = "Confirmar";

$token = $_GET['token'] ?? '';
if ($token) {
  $updateQuery = "UPDATE cliente SET confirmado = 1, token_confirmacion = NULL WHERE token_confirmacion = '$token'";
}

?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <?php include("../Includes/head.php"); ?>

    <title>Register</title>

  </head>

  <body>

    <header>

      <?php include("../Includes/header.php"); ?>

    </header>

    <main style="background-image: url('../Imagenes/Fondo.jpg')" class="fondo-loginRegister">

      <?php if (!empty($updateQuery) && mysqli_query($link, $updateQuery) && mysqli_affected_rows($link) > 0): ?>
        <div class="loginRegister-box text-center d-flex flex-column justify-content-center align-items-center confirmar-box">
          <i class="bi bi-check-circle-fill text-success mb-3 confirmar-icon-success"></i>
          <h2 class="mb-3 confirmar-title">¡Cuenta confirmada!</h2>
          <p class="mb-4 confirmar-text">Tu cuenta ha sido verificada exitosamente. Ya puedes acceder al sistema.</p>
          <a href="../Principal/InicioSesion.php" class="btn btn-success w-100 rounded-pill py-2 confirmar-btn">Iniciar sesión</a>
        </div>
      <?php else: ?>
        <div class="loginRegister-box text-center d-flex flex-column justify-content-center align-items-center confirmar-box">
          <i class="bi bi-x-circle-fill text-danger mb-3 confirmar-icon-danger"></i>
          <h2 class="mb-3 confirmar-title">¡Algo salió mal!</h2>
          <p class="mb-4 confirmar-text">El enlace es inválido o tu cuenta ya se encuentra confirmada.</p>
          <a href="../Principal/Index.php" class="btn btn-light w-100 rounded-pill py-2 confirmar-btn confirmar-btn-light">Volver al inicio</a>
        </div>
      <?php endif; ?>

    </main>

    <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-3">

      <?php include("../Includes/footer.php") ?>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

  </body>

</html>

<?php
mysqli_close($link);
