<?php

$folder = "Administrador";
$pestaña = "Administrar Locales";
include_once("../Includes/funciones.php");
sesionIniciada();

include("../conexion.inc");

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
      <?php if ($result->num_rows): ?>
        <?php while ($n = $result->fetch_assoc()): ?>
          <div class="promocion d-flex justify-content-between align-items-start mb-3 p-3 border rounded">
            <div class="infoTarjeta flex-grow-1 me-3">
              <h3 class="text-break"><?= htmlspecialchars($n['nombre_local']) ?></h3>
              <p>#<?= $n['cod_local'] ?></p>
              <p>Rubro: <?= htmlspecialchars($n['rubro_local']) ?></p>
              <p>Ubicación: <?= htmlspecialchars($n['ubicacion_local']) ?></p>
            </div>
            <div class="acciones">
              <a href="verDetalle.php?tipo=local&cod=<?= $n['cod_local'] ?>" class="btn btn-primary btn-sm">VER DETALLES</a>
              <a href="editar.php?tipo=local&cod=<?= $n['cod_local'] ?>" class="btn btn-secondary btn-sm">EDITAR</a>
              <form method="post" action="eliminar.php" onsubmit="return confirm('¿Seguro que quieres eliminar?');">
                <input type="hidden" name="tipo" value="local">
                <input type="hidden" name="cod" value="<?= $n['cod_local'] ?>">
                <button type="submit" class="btn btn-danger btn-sm">ELIMINAR</button>
              </form>
            </div>
          </div>
        <?php endwhile; ?>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>

</html>
<?php
$link->close();
?>