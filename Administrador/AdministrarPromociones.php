<?php

$folder = "Administrador";
$pestaña = "Administrar Promociones";
include_once("../Includes/funciones.php");
sesionIniciada();
require '../conexion.inc';
// Orden por defecto
$order = 'cod_promocion ASC';

// Chequeo parámetro GET para ordenar
if (isset($_GET['order'])) {
  switch ($_GET['order']) {
    case 'nombre_asc':
      $order = 'cod_promocion ASC';
      break;
    case 'nombre_desc':
      $order = 'cod_promocion DESC';
      break;
  }
}

if (isset($_GET['cod_promocion']) && isset($_GET['accion'])) {
  $cod_promocion = intval($_GET['cod_promocion']); // seguridad
  $accion = $_GET['accion'];

  if ($accion === 'aceptar') {
    $nuevo_estado = 'aceptada';
  } elseif ($accion === 'rechazar') {
    $nuevo_estado = 'rechazada';
  }

  if (isset($nuevo_estado)) {
    $sql_update = "UPDATE promociones SET estado_promo = '$nuevo_estado' WHERE cod_promocion = $cod_promocion";
    $link->query($sql_update);
    // Redirigir para evitar reenvío al refrescar
    header("Location: AdministrarPromociones.php");
    exit();
  }
}

$sql = "SELECT cod_promocion, texto_promocion FROM promociones ORDER BY $order";
$result = $link->query($sql);
?>

<!DOCTYPE html>
<html lang="es ">
  <head>

    <?php include("../Includes/head.php"); ?>

    <title>Administrar Promociones</title>

  </head>
  
  <body>
      <header>

        <?php include("../Includes/header.php"); ?>

      </header>

      <main class="FondoDueñoAdministrador">
        <div class="container-fluid filtraderos justify-content-end">
          <div class="dropdown">
            <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-arrow-down-up"></i> Ordenar
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="AdministrarPromociones.php?order=cod_promocion_asc">ID ↑</a></li>
              <li><a class="dropdown-item" href="AdministrarPromociones.php?order=cod_promocion_desc">ID ↓</a></li>
            </ul>
          </div>
        </div>

        <div class="promociones">
          <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <div class="promocion">
                <div class="infoTarjeta">
                  <h3><?php echo htmlspecialchars($row['texto_promocion']); ?></h3>
                  <p>#<?php echo $row['cod_promocion']; ?></p>
                  <p>Estado: <?php echo htmlspecialchars($row['estado_promo']); ?></p>
                </div>
                <div class="acciones">
                  <a href="VerPromocion.php?cod_promocion=<?php echo $row['cod_promocion']; ?>" class="btn btn-primary">VER DETALLES</a>
                  <a href="AdministrarPromociones.php?cod_promocion=<?php echo $row['cod_promocion']; ?>&accion=aceptar" class="btn btn-success">ACEPTAR</a>
                  <a href="AdministrarPromociones.php?cod_promocion=<?php echo $row['cod_promocion']; ?>&accion=rechazar" class="btn btn-danger">RECHAZAR</a>
                </div>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
            <p>No hay promociones existentes.</p>
          <?php endif; ?>
        </div>
      </main>

    <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4">

      <?php include("../Includes/footer.php") ?>

    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
  </body>
</html>
