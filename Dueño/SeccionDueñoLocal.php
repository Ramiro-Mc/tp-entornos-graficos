<?php
include_once("../Includes/session.php");
if (!isset($_SESSION['cod_usuario'])) {
  header("Location: ../principal/login.php");
  exit;
}

$folder = "Dueño";
$pestaña = "Seccion Dueño Local";
?>

<!DOCTYPE html>
<html lang="es">
  <head>

    <?php include("../Includes/head.php"); ?>

    <title>Dueño Local</title>

  </head>

  <body>
    <header>

      <?php include("../Includes/header.php"); ?>

    </header>

    <main class="FondoDueñoAdministrador align-items-center ">
      
      <div class="botonesDueñoAdministrador container-fluid">
        <a href="CrearPromocion.php"><button>Crear nueva promocion</button></a>
        <a href="MisPromociones.php"><button>Mis promociones</button></a>
        <a href="ReportePromociones.php"> <button>Generar reporte</button></a>
      </div>
      
    </main>

    <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4">

      <?php include("../Includes/footer.php") ?>
    
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
  </body>
</html>
