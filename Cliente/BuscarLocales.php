<?php
include_once("../Includes/session.php");
include_once("../Includes/funciones.php");

$folder = "Cliente";
$pestaña = "Buscar Locales";


$result =  consultaSQL("SELECT foto_local, nombre_local, rubro_local, ubicacion_local FROM locales")

?>

<!DOCTYPE html>
<html lang="es">
  <head>

    <?php include("../Includes/head.php"); ?>

    <title>Buscar Locales</title>

  </head>

  <body>
    <header>

      <?php include("../Includes/header.php");?>

    </header>

    <main class="main-no-center">
      
      <?php if ($result->num_rows > 0): ?>
        <?php 
          while ($row = $result->fetch_assoc()): 
          $imagenLocal = $row['foto_local']; 
          $nombre_local = $row['nombre_local']; 
        ?>
          <div class="container-fluid">
            <div class="col-12 col-md-6 col-lg-4 ">
              <div class="promocion-index">

                <img src="data:image/jpeg;base64<?= $imagenLocal ?>" alt="<?= $nombre_local ?>" />
                <div class="overlay">
                  <p><?= $nombre_local ?></p>
                </div>

              </div>
            </div>
          </div>

        <?php endwhile; ?>

      <?php else: ?>
        <p>No hay locales registrados.</p>
      <?php endif; ?>

    </main>

    <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-3">

      <?php include("../Includes/footer.php") ?>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
  </body>
</html>
