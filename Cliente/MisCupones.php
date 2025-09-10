<?php

$folder = "Cliente";
$pestaña = "Mis Cupones";

include_once("../Includes/session.php");
include_once("../Includes/funciones.php");
sesionIniciada();

if (!isset($_SESSION['cod_usuario'])) {
  header("Location: ../principal/login.php");
  exit;
}

$cod_usuario = $_SESSION['cod_usuario'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $cod_promocion_a_ocultar = $_POST['eliminar'];
  consultaSQL("UPDATE uso_promociones SET mostrar = 0 WHERE cod_promocion = '$cod_promocion_a_ocultar'");
}

$result = consultaSQL(
  "
  SELECT 
  pro.texto_promocion, pro.foto_promocion, pro.cod_promocion, sol.estado, loc.nombre_local 
  FROM uso_promociones sol
  INNER JOIN promociones pro ON sol.cod_promocion = pro.cod_promocion
  INNER JOIN locales loc ON pro.cod_local = loc.cod_local
  WHERE sol.cod_usuario = '{$cod_usuario}' 
  AND sol.mostrar = 1" 
);
?>

<!DOCTYPE html>
<html lang="es">

<head>

  <?php include("../Includes/head.php"); ?>

  <title>Mis Solicitudes De Promociones</title>

</head>

<body>
  <header>

    <?php include("../Includes/header.php"); ?>

  </header>

  <main style="min-height: 60vh;" class="fondo-formulario-contacto">

    <div class="contenedor_solicitudes">
      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>

          <?php $texto_promocion = $row['texto_promocion'];
          $foto_promocion = $row['foto_promocion'];
          $nombre_local = $row['nombre_local'];
          $estado = $row['estado'];
          $cod_promocion = $row['cod_promocion'];
          $modalId = 'modal_' . md5($texto_promocion . $nombre_local); ?>


          <div class="promocion-cli container-fluid">
            <div class="row">

              <div class="col-4 col-md-3 col-lg-4 col-xl-3">
                <img src="data:image/jpeg;base64,<?= $foto_promocion ?>"  alt="Foto promocion <?= $texto_promocion ?>/>
              </div>
              <div class="col-8 col-md-9 col-lg-8 col-xl-9 d-flex justify-content-between align-items-center">

                <div class="info info-promocion">
                  <h3><?= $texto_promocion ?></h3>
                  <p>Local: <?= $nombre_local ?></p>
                </div>

                <div class="info contenedor-estado estado-<?= $estado ?>">
                  <p>Estado:</p><br>
                  <p><strong><?= $estado ?></strong></p>
                </div>

                <?php if ($estado == "aceptada"): ?>
                  <button type="button " class="boton-codigo btn btn-secondary btn-lg" data-bs-toggle="modal" data-bs-target="#<?= $modalId ?>" onclick="generarCodigo('<?= $modalId ?>')">Generar <br />Código</button>
                  <button type="button" class="boton-codigo-chico"><i class="bi bi-qr-code"></i></button>
                <?php else: ?>
                  
                  <button type="button" class="btn btn-danger cuadrado" data-bs-toggle="modal" data-bs-target="#eliminar-<?= $modalId ?>"><i class="bi bi-x-lg"></i></button>
                  
                <?php endif; ?>
                
                <!-- Modal -->

                <div class="modal fade " id="<?= $modalId ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header ">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel" style="margin: auto;">¡Codigo Generado!</h1>
                      </div>
                      <div class="modal-body">
                        <div class="campo-codigo">
                          <p id="codigo-<?= $modalId ?>"></p>
                          <button type="button" class="btn boton-copiado" onclick="copiarCodigo('codigo-<?= $modalId ?>')">
                            <i id="boton-no-apretado-codigo-<?= $modalId ?>" class="bi bi-clipboard"></i>
                            <i id="boton-apretado-codigo-<?= $modalId ?>" style="display: none;" class="bi bi-clipboard-check"></i></button>
                        </div>
                        <p class="advertencia"><i class="bi bi-exclamation-triangle-fill"></i> Una vez cerrada esta ventana emergente no se podra volver a abrir. Asegurese de copiar su codigo</p>
                      </div>
                      <div class="modal-footer">
                        <form  action="MisSolicitudesDePromociones.php" method="POST" name="Eliminar solicitud">
                          <button style="margin: auto;" type="submit" name="eliminar" value="<?= $cod_promocion ?>" class="btn btn-secondary" data-bs-dismiss="modal">¡Listo!</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- Modal de eliminacion -->

                <div class="modal fade " id="eliminar-<?= $modalId ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header ">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel" style="margin: auto; font-size: 1.6rem;">Eliminar solicitud</h1>
                      </div>
                      <div class="modal-body text-center">
                        <p style="font-size: 1.2rem;">¿Seguro que quiere eliminar esta solicitud?</p>
                        <p class="informacion"><i class="bi bi-info-circle"></i> Eliminar esta solicitud no te permitira gerenar una nueva solicitud para la misma promocion</p>
                      </div>
                      <div class="modal-footer d-flex justify-content-around">
                        <form  action="MisSolicitudesDePromociones.php" method="POST" name="Eliminar solicitud">
                          <button  type="submit" name="eliminar" value="<?= $cod_promocion ?>" class="btn btn-danger" data-bs-dismiss="modal">Eliminar</button>
                        </form>
                          <button  type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>

        <?php endwhile; ?>

      <?php else: ?>
        <div class="notificacion-no-promociones">
          <h3>¡Todo en orden!</h3>
          <p style="margin: 0;">No tienes solicitudes de promocion pendientes</p>
          <a href="../Cliente/BuscarPromociones.php">Usar una promocion</a>
        </div>
      <?php endif; ?>
    </div>


  </main>


  <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-3">

    <?php include("../Includes/footer.php") ?>

  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

  <script>
    function copiarCodigo(elementId) {
      const texto = document.getElementById(elementId).innerText;
      navigator.clipboard.writeText(texto)
        .then(data => {
          document.getElementById("boton-no-apretado-" + elementId).style.display = "none";
          document.getElementById("boton-apretado-" + elementId).style.display = "block";
        })
        .catch(() => {
          alert('No se pudo copiar el código.');
        });
    }

    function generarCodigo(modalId) {
      const random = Math.random().toString(16).substr(2, 8).toUpperCase();
      const codigo = "PROMO-" + random;
      document.getElementById("codigo-" + modalId).innerText = codigo;

    }
  </script>

</body>

</html>