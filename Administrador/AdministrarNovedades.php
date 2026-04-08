<?php

$folder = "Administrador";
$pestaña = "Administrar Novedades";
include_once("../Includes/funciones.php");
sesionIniciada();

include("../Includes/conexion.inc");

$params = [];
if (isset($_GET['order'])) {
  $params['order'] = $_GET['order'];
}

$pagina = isset($_GET['pagina']) && is_numeric($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$novedades_por_pagina = 5;
$offset = ($pagina - 1) * $novedades_por_pagina;
$order = 'cod_novedad ASC';

if (isset($_GET['order'])) {
  switch ($_GET['order']) {
    case 'texto_asc':
      $order = 'texto_novedad ASC';
      break;
    case 'texto_desc':
      $order = 'texto_novedad DESC';
      break;
    case 'cod_novedad_desc':
      $order = 'cod_novedad DESC';
      break;
    case 'cod_novedad_asc':
    default:
      $order = 'cod_novedad ASC';
      break;
  }
}

// Pasamos el resultado a un array para los modales
$result = $link->query("SELECT cod_novedad, texto_novedad, fecha_desde_novedad, fecha_hasta_novedad FROM novedades ORDER BY $order LIMIT $novedades_por_pagina OFFSET $offset");

$novedades = [];
while ($fila = $result->fetch_assoc()) {
    $novedades[] = $fila;
}

$total_novedades_result = $link->query("SELECT COUNT(*) AS total FROM novedades");
$total_novedades_row = $total_novedades_result->fetch_assoc();
$total_novedades = $total_novedades_row['total'];
$total_paginas = ceil($total_novedades / $novedades_por_pagina);

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <?php include("../Includes/head.php"); ?>
  <title>Administrar Novedades</title>
</head>

<body>
  <header>
    <?php include("../Includes/header.php"); ?>
  </header>

  <main class="FondoDueñoAdministrador">
    <div class="container-fluid filtraderos justify-content-end">
      <a href="Crear.php?tipo=novedad">
        <button class="btn btn-success">
          <i class="bi bi-plus-circle"></i> Crear
        </button>
      </a>
      <div class="dropdown">
        <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-arrow-down-up"></i> Ordenar
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="AdministrarNovedades.php?order=texto_asc">Texto ↑</a></li>
          <li><a class="dropdown-item" href="AdministrarNovedades.php?order=texto_desc">Texto ↓</a></li>
          <li><a class="dropdown-item" href="AdministrarNovedades.php?order=cod_novedad_asc">ID ↑</a></li>
          <li><a class="dropdown-item" href="AdministrarNovedades.php?order=cod_novedad_desc">ID ↓</a></li>
        </ul>
      </div>
    </div>
    <div class="promociones">
      <?php if (!empty($novedades)): ?>
        <?php foreach ($novedades as $n): ?>
          <div class="promocion d-flex justify-content-between align-items-start mb-3 p-3 border rounded">
            <div class="infoTarjeta flex-grow-1 me-3">
              <h4 class="text-break"><?= htmlspecialchars($n['texto_novedad']) ?></h4>
              <p>#<?= $n['cod_novedad'] ?></p>
              <p><small>Desde: <?= $n['fecha_desde_novedad'] ?> | Hasta: <?= $n['fecha_hasta_novedad'] ?></small></p>
            </div>
            <div class="acciones d-flex flex-column gap-2">
              <a href="verDetalle.php?tipo=novedad&cod=<?= $n['cod_novedad'] ?>" class="btn btn-primary btn-sm">VER DETALLES</a>
              <a href="editar.php?tipo=novedad&cod=<?= $n['cod_novedad'] ?>" class="btn btn-secondary btn-sm">EDITAR</a>
              
              <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-eliminar-<?= $n['cod_novedad'] ?>">
                ELIMINAR
              </button>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-center">No hay novedades cargadas.</p>
      <?php endif; ?>
    </div>
    <div class="mt-4">
      <?php paginacion($pagina, $total_paginas, $params); ?>
    </div>
  </main>

  <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4">
    <?php include("../Includes/footer.php") ?>
  </footer>

  <?php foreach ($novedades as $n): ?>
    <div class="modal fade" id="modal-eliminar-<?= $n['cod_novedad'] ?>" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-solicitud-accion modal-solicitud-rechazar">
          <div class="modal-header">
            <h1 class="modal-title fs-5" style="margin: auto;">Eliminando Novedad</h1>
          </div>
          <div class="modal-body text-center">
            <p style="font-size: 1.2rem; color:black;">¿Seguro que quieres eliminar esta novedad?</p>
            <p class="text-muted"><small>"<?= htmlspecialchars(substr($n['texto_novedad'], 0, 50)) ?>..."</small></p>
          </div>
          <div class="modal-footer d-flex justify-content-around">
            <form method="post" action="eliminar.php" class="m-0">
              <input type="hidden" name="tipo" value="novedad">
              <input type="hidden" name="cod" value="<?= $n['cod_novedad'] ?>">
              <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>