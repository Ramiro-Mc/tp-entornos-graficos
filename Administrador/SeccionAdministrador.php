<?php

$folder = "Administrador";
$pestaña = "Seccion Administrador";
include_once("../Includes/funciones.php");
sesionIniciada();
?>

<!DOCTYPE html>
<html lang="es">
  <head>

    <?php include("../Includes/head.php"); ?>

    <title>Seccion Administrador</title>

  </head>

  <body>
    <header>

      <?php include("../Includes/header.php"); ?>

    </header>

    <main class="FondoDueñoAdministrador">
      <div class="botonesDueñoAdministrador">
        <a href="AdministrarPromociones.php">
          <button>Administrar Promociones</button>
        </a>
        <a href="AdministrarNovedades.php">
          <button>Administrar Novedades</button>
        </a>
        <a href="AdministrarLocales.php">
          <button>Administrar Locales</button>
        </a>
        <a href="SolicitudRegistro.html">
          <button>Solicitudes De Registro</button>
        </a>
        <a href="ReportePromocionesAdm.html">
          <button>Reportes De Uso Promociones</button>
        </a>
      </div>
    </main>

    <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4">

      <?php include("../Includes/footer.php") ?>
    
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
  
  </body>
</html>
