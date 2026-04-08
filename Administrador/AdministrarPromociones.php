<?php
$folder = "Administrador";
$pestaña = "Administrar Promociones";
include_once("../Includes/funciones.php");
sesionIniciada();

include("../Includes/conexion.inc");

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

// Para que los modales funcionen, necesitamos volcar el resultado a un array
$result = $link->query("SELECT p.cod_promocion, p.texto_promocion, p.estado_promo, p.fecha_desde_promocion, p.fecha_hasta_promocion, l.nombre_local FROM promociones p INNER JOIN locales l ON p.cod_local = l.cod_local WHERE p.estado_promo = 'pendiente' ORDER BY $order LIMIT $promociones_por_pagina OFFSET $offset");

$promociones = [];
while ($fila = $result->fetch_assoc()) {
    $promociones[] = $fila;
}

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
      <?php if (!empty($promociones)): ?>
        <?php foreach ($promociones as $n): ?>
          <div class="promocion d-flex justify-content-between align-items-start mb-3 p-3 border rounded">
            <div class="infoTarjeta flex-grow-1 me-3">
              <h3><?= htmlspecialchars($n['texto_promocion']) ?></h3>
              <p>#<?= htmlspecialchars($n['cod_promocion']); ?></p>
              <p>Local: <?= htmlspecialchars($n['nombre_local']); ?></p>
              <p><small>Desde: <?= $n['fecha_desde_promocion'] ?> | Hasta: <?= $n['fecha_hasta_promocion'] ?></small></p>
            </div>
            <div class="acciones d-flex flex-column gap-2">
              <a href="verDetalle.php?tipo=promocion&cod=<?= $n['cod_promocion'] ?>" class="btn btn-primary btn-sm">VER DETALLES</a>
              
              <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modal-aceptar-<?= $n['cod_promocion'] ?>">
                ACEPTAR
              </button>

              <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-rechazar-<?= $n['cod_promocion'] ?>">
                RECHAZAR
              </button>
            </div>
          </div>
        <?php endforeach; ?>
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

  <?php foreach ($promociones as $n): ?>
    <div class="modal fade" id="modal-aceptar-<?= $n['cod_promocion'] ?>" data-bs-backdrop="static" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-solicitud-accion modal-solicitud-aprobar">
          <div class="modal-header text-center">
            <h1 class="modal-title fs-5" style="margin: auto;">Aprobando solicitud</h1>
          </div>
          <div class="modal-body text-center">
            <p style="font-size: 1.2rem; color:black;">¿Seguro que quieres ACEPTAR esta promoción?</p>
          </div>
          <div class="modal-footer d-flex justify-content-around">
            <a href="AdministrarPromociones.php?cod_promocion=<?= $n['cod_promocion'] ?>&accion=aceptar" class="btn btn-success">Aceptar promoción</a>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal-rechazar-<?= $n['cod_promocion'] ?>" data-bs-backdrop="static" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-solicitud-accion modal-solicitud-rechazar">
          <div class="modal-header text-center">
            <h1 class="modal-title fs-5" style="margin: auto;">Rechazando solicitud</h1>
          </div>
          <div class="modal-body text-center">
            <p style="font-size: 1.2rem; color:black;">¿Seguro que quieres RECHAZAR esta promoción?</p>
          </div>
          <div class="modal-footer d-flex justify-content-around">
            <a href="AdministrarPromociones.php?cod_promocion=<?= $n['cod_promocion'] ?>&accion=rechazar" class="btn btn-danger">Rechazar promoción</a>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>