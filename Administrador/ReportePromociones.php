<?php 

$folder = "Administrador";
$pestaña = "Reporte Promociones";
include_once("../Includes/funciones.php");
sesionIniciada();
?>


<!DOCTYPE html>
<html lang="es ">
  <head>

    <?php include("../Includes/head.php"); ?>

    <title>Reportes de promociones</title>

  </head>
  <body>
    <header>

      <?php include("../Includes/header.php"); ?>

    </header>

    <main class="FondoDueñoAdministrador">
      <div class="filtraderos">
        <button>GENERAR REPORTE</button>
        <button>ORDENAR POR</button>
        <button>FILTRAR</button>
      </div>
      <div class="promociones">
        <div class="promocion-container">
          <div class="promocion" style="width: 90%">
            <div class="info">
              <h3>Reporte 1</h3>
              <p>#ID</p>
            </div>
            <div class="acciones">
              <button class="Detalle" style="height: 100px">
                VER DETALLES
              </button>
            </div>
          </div>
          <div class="estado">[ESTADO]</div>
        </div>

        <div class="promocion-container">
          <div class="promocion" style="width: 90%">
            <div class="info">
              <h3>Reporte 2</h3>
              <p>#ID</p>
            </div>
            <div class="acciones">
              <button class="Detalle" style="height: 100px">
                VER DETALLES
              </button>
            </div>
          </div>
          <div class="estado">[ESTADO]</div>
        </div>

        <div class="promocion-container">
          <div class="promocion" style="width: 90%">
            <div class="info">
              <h3>Reporte 3</h3>
              <p>#ID</p>
            </div>
            <div class="acciones">
              <button class="Detalle" style="height: 100px">
                VER DETALLES
              </button>
            </div>
          </div>
          <div class="estado">[ESTADO]</div>
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
