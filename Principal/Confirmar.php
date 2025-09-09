<?php
include("../conexion.inc");
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

      <main style="background-image: url('../Images/Fondo Sobrio.jfif')" class="fondo-loginRegister">
     
      <?php if(mysqli_query($link, $updateQuery) && mysqli_affected_rows($link) > 0):?>
        <div class="notificacion-cuenta-confirmada">
          <h3>Cuenta confirmada!</h3>
          <a href="Index.php">Haga click aqui para volver a la pagina principal</a>
        </div>
      <?php else: ?>
        <div class="notificacion-cuenta-no-confirmada">
          <h3>Token inválido o cuenta ya confirmada.</h3>
          <a href="Index.php">Haga click aqui para volver a la pagina principal</a>
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