<?php

$folder = "Administrador";
$pestaña = "Administrar Locales";
include_once("../Includes/funciones.php");
sesionIniciada();

include("../Includes/conexion.inc");

$params = [];
if (isset($_GET['order'])) {
  $params['order'] = $_GET['order'];
}

$pagina = isset($_GET['pagina']) && is_numeric($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$locales_por_pagina = 5;
$offset = ($pagina - 1) * $locales_por_pagina;
$order = 'cod_local ASC';

if (isset($_GET['order'])) {
  switch ($_GET['order']) {
    case 'nombre_asc':
      $order = 'nombre_local ASC';
      break;
    case 'nombre_desc':
      $order = 'nombre_local DESC';
      break;
    case 'cod_local_desc':
      $order = 'cod_local DESC';
      break;
    case 'cod_local_asc':
    default:
      $order = 'cod_local ASC';
      break;
  }
}

$result = $link->query("SELECT cod_local, nombre_local, rubro_local, ubicacion_local FROM locales ORDER BY $order LIMIT $locales_por_pagina OFFSET $offset");

// Volcamos a un array para usar en el listado y en los modales
$locales = [];
if ($result) {
    while ($fila = $result->fetch_assoc()) {
        $locales[] = $fila;
    }
}

$total_locales_result = $link->query("SELECT COUNT(*) AS total FROM locales");
$total_locales_row = $total_locales_result->fetch_assoc();
$total_locales = $total_locales_row['total'];
$total_paginas = ceil($total_locales / $locales_por_pagina);

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <?php include("../Includes/head.php"); ?>
  <title>Administrar Locales</title>
</head>

<body>
  <header>
    <?php include("../Includes/header.php"); ?>
  </header>

  <main class="FondoDueñoAdministrador">
    <div class="container-fluid filtraderos justify-content-end">
      <a href="Crear.php?tipo=local">
        <button class="btn btn-success">
          <i class="bi bi-plus-circle"></i> Crear
        </button>
      </a>
      <div class="dropdown">
        <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-arrow-down-up"></i> Ordenar
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="AdministrarLocales.php?order=nombre_asc">Nombre ↑</a></li>
          <li><a class="dropdown-item" href="AdministrarLocales.php?order=nombre_desc">Nombre ↓</a></li>
          <li><a class="dropdown-item" href="AdministrarLocales.php?order=cod_local_asc">ID ↑</a></li>
          <li><a class="dropdown-item" href="AdministrarLocales.php?order=cod_local_desc">ID ↓</a></li>
        </ul>
      </div>
    </div>
    
    <div class="promociones">
      <?php if (!empty($locales)): ?>
        <?php foreach ($locales as $n): ?>
          <div class="promocion-cli container-fluid bg-white rounded-4 shadow-sm mb-4 p-3 dueño-promo-card">
            <div class="row align-items-center">
              <div class="col-12 d-flex justify-content-between align-items-center">
                <div class="info w-100 ps-2">
                  <h3 class="dueño-promo-title text-break"><?= htmlspecialchars($n['nombre_local']) ?></h3>
                  <div class="d-flex flex-wrap gap-3 mt-2 text-muted dueño-promo-details">
                    <div class="d-flex align-items-center"><i class="bi bi-hash text-secondary me-1"></i> <?= $n['cod_local'] ?></div>
                    <div class="d-flex align-items-center"><i class="bi bi-tags text-primary me-2"></i> Rubro: <?= htmlspecialchars($n['rubro_local']) ?></div>
                    <div class="d-flex align-items-center"><i class="bi bi-geo-alt text-danger me-2"></i> Ubicación: <?= htmlspecialchars($n['ubicacion_local']) ?></div>
                  </div>
                </div>
                <div class="acciones d-flex flex-column gap-2 ms-3" style="min-width: 130px;">
                  <a href="verDetalle.php?tipo=local&cod=<?= $n['cod_local'] ?>" class="btn btn-primary btn-sm w-100 d-flex align-items-center justify-content-center" style="height: 32px;">VER DETALLES</a>
                  <a href="editar.php?tipo=local&cod=<?= $n['cod_local'] ?>" class="btn btn-secondary btn-sm w-100 d-flex align-items-center justify-content-center" style="height: 32px;">EDITAR</a>
                  
                  <button type="button" class="btn btn-danger btn-sm w-100 d-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#modal-eliminar-<?= $n['cod_local'] ?>" style="height: 32px; padding: 0;">
                    ELIMINAR
                  </button>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-center">No hay locales cargados.</p>
      <?php endif; ?>
    </div>

    <div class="mt-4">
      <?php paginacion($pagina, $total_paginas, $params); ?>
    </div>
  </main>

  <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4">
    <?php include("../Includes/footer.php") ?>
  </footer>

  <?php foreach ($locales as $n): ?>
    <div class="modal fade" id="modal-eliminar-<?= $n['cod_local'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-solicitud-accion modal-solicitud-rechazar">
          <div class="modal-header">
            <h1 class="modal-title fs-5" style="margin: auto;">Eliminando Local</h1>
          </div>
          <div class="modal-body text-center">
            <p style="font-size: 1.2rem; color:black;">¿Seguro que quieres eliminar el local <b><?= htmlspecialchars($n['nombre_local']) ?></b>?</p>
          </div>
          <div class="modal-footer d-flex justify-content-around">
            <form method="post" action="eliminar.php" class="m-0">
              <input type="hidden" name="tipo" value="local">
              <input type="hidden" name="cod" value="<?= $n['cod_local'] ?>">
              <button type="submit" class="btn btn-danger">Eliminar Local</button>
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
<?php
$link->close();
?>