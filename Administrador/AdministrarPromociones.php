<?php

$folder = "Administrador";
$pestaña = "Administrar Promociones";
include_once("../Includes/funciones.php");
sesionIniciada();

include('../conexion.inc');

$params = [];
if (isset($_GET['order'])) {
  $params['order'] = $_GET['order'];
}

$pagina = isset($_GET['pagina']) && is_numeric($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$promociones_por_pagina = 5;
$offset = ($pagina - 1) * $promociones_por_pagina;
$order = 'cod_promocion ASC';

if (isset($_GET['order'])) {
  switch ($_GET['order']) {
    case 'cod_promocion_asc':
      $order = 'cod_promocion ASC';
      break;
    case 'cod_promocion_desc':
      $order = 'cod_promocion DESC';
      break;
  }
}

if (isset($_GET['cod_promocion']) && isset($_GET['accion'])) {
  $cod_promocion = intval($_GET['cod_promocion']);
  $accion = $_GET['accion'];

  if ($accion === 'aceptar') {
    $nuevo_estado = 'aceptada';
  } elseif ($accion === 'rechazar') {
    $nuevo_estado = 'rechazada';
  }

  if (isset($nuevo_estado)) {
    $sql_update = $link->prepare("UPDATE promociones SET estado_promo = ? WHERE cod_promocion = ?");
    $sql_update->bind_param("si", $nuevo_estado, $cod_promocion);
    $sql_update->execute();
    $sql_update->close();
    header("Location: AdministrarPromociones.php");
    exit();
  }
}

$result = $link->query("SELECT p.cod_promocion, p.texto_promocion, p.estado_promo, p.fecha_desde_promocion, p.fecha_hasta_promocion, l.nombre_local FROM promociones p INNER JOIN locales l ON p.cod_local = l.cod_local WHERE p.estado_promo = 'pendiente' ORDER BY $order LIMIT $promociones_por_pagina OFFSET $offset");

$total_promociones_result = $link->query("SELECT COUNT(*) AS total FROM promociones WHERE estado_promo = 'pendiente'");
$total_promociones_row = $total_promociones_result->fetch_assoc();
$total_promociones = $total_promociones_row['total'];
$total_paginas = ceil($total_promociones / $promociones_por_pagina);
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
      <?php if ($result->num_rows): ?>
        <?php while ($n = $result->fetch_assoc()): ?>
          <div class="promocion d-flex justify-content-between align-items-start mb-3 p-3 border rounded">
            <div class="infoTarjeta flex-grow-1 me-3">
              <h3><?= htmlspecialchars($n['texto_promocion']) ?></h3>
              <p>#<?= htmlspecialchars($n['cod_promocion']); ?></p>
              <p>Local: <?= htmlspecialchars($n['nombre_local']); ?></p>
              <p><small>Desde: <?= $n['fecha_desde_promocion'] ?> | Hasta: <?= $n['fecha_hasta_promocion'] ?></small></p>
            </div>
            <div class="acciones">
              <a href="VerPromocion.php?cod_promocion=<?= $n['cod_promocion'] ?>" class="btn btn-primary btn-sm">VER DETALLES</a>
              <a href="AdministrarPromociones.php?cod_promocion=<?= $n['cod_promocion'] ?>&accion=aceptar"
                class="btn btn-success"
                onclick="return confirm('¿Seguro que quieres ACEPTAR esta promoción?');">
                ACEPTAR
              </a>

              <a href="AdministrarPromociones.php?cod_promocion=<?= $n['cod_promocion'] ?>&accion=rechazar"
                class="btn btn-danger"
                onclick="return confirm('¿Seguro que quieres RECHAZAR esta promoción?');">
                RECHAZAR
              </a>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p class="text-center">No hay promociones cargadas.</p>
      <?php endif; ?>
    </div>

    <div class="mt-4">
      <?php paginacion($pagina, $total_paginas, $params); ?>
    </div>

  </main>

  <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4">

    <?php include("../Includes/footer.php") ?>

  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>