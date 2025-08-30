<?php
include_once("../Includes/session.php");
if (!isset($_SESSION['cod_usuario'])) {
  header("Location: ../principal/login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <!-- Importar BootStrap -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7"
      crossorigin="anonymous"
    />

    <!-- Importar iconos BootStrap -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />

    <!-- Metadatos -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="../styles/style.css" />
    <link rel="stylesheet" href="../styles/style-general.css" />

    <title>Dueño Local</title>
    <link rel="icon" type="image/x-icon" href="../Images/Logo.png" />
  </head>

  <body>
    <header>

      <?php

      $folder = "Dueño";
      $pestaña = "Seccion Dueño Local";
      include("../Includes/header.php");

      /* Ver como hacer para que aca no aparezca el menu desplegable (porque no tiene ninguna opcion) */

      ?>

    </header>

    <main class="FondoDueñoAdministrador align-items-center ">
      
      <div class="botonesDueñoAdministrador container-fluid">
        <a href="CrearPromocion.php"><button>Crear nueva promocion</button></a>
        <a href="MisPromociones.html"><button>Mis promociones</button></a>
        <a href="ReportePromocionesDue.html"
          ><button>Generar reporte</button></a
        >
      </div>
    </main>

    <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4">

      <?php include("../Includes/footer.php") ?>
    
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
  </body>
</html>
