<!-- 
  Consideramos eliminar la seccion y simplemente poner un boton que genere el reporte
-->

<?php
include_once("../Includes/session.php");
if (!isset($_SESSION['cod_usuario'])) {
  header("Location: ../principal/login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="es ">
  <head>
    <?php include("../Includes/head.php"); ?>
    <title>Reportes de uso de promociones</title>
  </head>
  <body>
    <header>

      <?php

      $folder = "Dueño";
      $pestaña = "Reporte Promociones";
      include("../Includes/header.php");

      /* Ver como hacer para que aca no aparezca el menu desplegable (porque no tiene ninguna opcion) */

      ?>

    </header>

    <main class="FondoDueñoAdministrador">
      <div class="container-fluid filtraderos justify-content-end">
        <button class="btn btn-success"><i class="bi bi-plus-circle"></i> Crear </button>
        <button class="btn btn-info"><i class="bi bi-arrow-down-up"></i>Ordenar</button>
        <!-- <button>FILTRAR</button> -->
      </div>
      <div class="promociones">
        <div class="promocion">
          <div class="infoTarjeta">
            <h3>Reporte 1</h3>
            <p>#ID</p>
          </div>
          <div class="acciones-reporte align-items-center d-flex justify-content-center">
             <button class="btn btn-primary ">VER DETALLES</button>
          </div>
        </div>

        <div class="promocion">
          <div class="infoTarjeta">
            <h3>Reporte 2</h3>
            <p>#ID</p>
          </div>
          <div class="acciones-reporte align-items-center d-flex justify-content-center">
             <button class="btn btn-primary">VER DETALLES</button>
          </div>
        </div>

        <div class="promocion">
          <div class="infoTarjeta">
            <h3>Reporte 3</h3>
            <p>#ID</p>
          </div>
          <div class="acciones-reporte align-items-center d-flex justify-content-center">
             <button class="btn btn-primary">VER DETALLES</button>
          </div>
        </div>
      </div>
      <div aria-label="Page navigation example">
        <ul class="pagination">
          <li class="page-item"><a class="page-link" href="#">Previous</a></li>
          <li class="page-item"><a class="page-link" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
      </div>
    </main>

    <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4">

      <?php include("../Includes/footer.php") ?>
    
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
  </body>
</html>
