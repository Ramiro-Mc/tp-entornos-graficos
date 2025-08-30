<?php
  include_once("../Includes/session.php");
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
    <meta name="viewport" content="width=, initial-scale=1.0" />

    <link rel="stylesheet" href="../Styles/style.css" />
    <link rel="stylesheet" href="../styles/style-general.css" />

    <title>Contacto</title>
    <link rel="icon" type="image/x-icon" href="../Images/logo.png" />
  </head>

  <body>
   

    <header>

      <?php

      $folder = "Principal";
      $pestaña = "Contacto";
      include("../Includes/header.php");

      /* Ver como hacer para que aca no aparezca el menu desplegable (porque no tiene ninguna opcion) */

      ?>

    </header>

    <main class="fondo-formulario-contacto">
      <div class="formulario-contacto text-center">
        <h2 class="seccion-titulo">Escribinos</h2>

        <form action="enviar_contacto.php" method="post" enctype="text/plain" class="mx-auto" style="max-width: 600px;">
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="nombre" class="form-label"><b>Nombre:</b></label>
              <input type="text" class="form-control inputContacto" id="nombre" name="nombre" required>
            </div>
            <div class="col-md-6">
              <label for="apellido" class="form-label "><b>Apellido:</b></label>
              <input type="text" class="form-control inputContacto" id="apellido" name="apellido" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label"><b>E-mail:</b></label>
            <input type="email" class="form-control inputContacto" id="email" name="email" required>
          </div>

          <div class="mb-3">
            <label for="consulta" class="form-label"><b>Consulta:</b></label>
            <textarea class="form-control inputContacto" id="consulta" name="consulta" rows="6" required></textarea>
          </div>

          <div class="text-center">
            <button type="submit" class="btn btn-success me-2 boton-enviar">ENVIAR</button>
            <button type="reset" class="btn btn-secondary">BORRAR</button>
          </div>
        </form>
      </div>
    </main>

    <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4">

      <?php include("../Includes/footer.php") ?>
    
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
  
  </body>
</html>


