<?php 

$folder = "Administrador";
$pestaña = "Solicitudes De Registro";
include_once("../Includes/funciones.php");
sesionIniciada();
?>

<!DOCTYPE html>
<html lang="es ">
  <head>

    <?php include("../Includes/head.php"); ?>

    <title>Solicitud De Registro</title>

  </head>
  <body>
    <header>

      <?php include("../Includes/header.php"); ?>

    </header>

    <main class="FondoDueñoAdministrador">
      <div class="container-fluid filtraderos justify-content-end">
        <button class="btn btn-info"><i class="bi bi-arrow-down-up"></i>Ordenar</button>
      </div>
      <div class="promociones">
        <div class="promocion">
          <div class="infoTarjeta">
            <h3>Dueño 1</h3>
            <p>#ID</p>
          </div>
          <div class="acciones">
             <button class="btn btn-primary ">VER DETALLES</button>
            <button class="btn btn-success">ACEPTAR</button>
            <button class="btn btn-danger ">RECHAZAR</button>
          </div>
        </div>

        <div class="promocion">
          <div class="infoTarjeta">
            <h3>Dueño 2</h3>
            <p>#ID</p>
          </div>
          <div class="acciones">
             <button class="btn btn-primary ">VER DETALLES</button>
            <button class="btn btn-success">ACEPTAR</button>
            <button class="btn btn-danger">RECHAZAR</button>
          </div>
        </div>

        <div class="promocion">
          <div class="infoTarjeta">
            <h3>Dueño 3</h3>
            <p>#ID</p>
          </div>
          <div class="acciones">
             <button class="btn btn-primary ">VER DETALLES</button>
            <button class="btn btn-success">ACEPTAR</button>
            <button class="btn btn-danger ">RECHAZAR</button>
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
