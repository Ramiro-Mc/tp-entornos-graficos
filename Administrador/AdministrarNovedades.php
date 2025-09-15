<?php

$folder = "Administrador";
$pestaña = "Administrar Novedades";
include_once("../Includes/funciones.php");
sesionIniciada();

include("../conexion.inc");

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

$result = $link->query("SELECT cod_novedad, texto_novedad, fecha_desde_novedad, fecha_hasta_novedad FROM novedades ORDER BY $order LIMIT $novedades_por_pagina OFFSET $offset");

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
      <a href="CrearNovedad.php">
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
      <?php if ($result->num_rows): ?>
        <?php while ($n = $result->fetch_assoc()): ?>
          <div class="promocion d-flex justify-content-between align-items-start mb-3 p-3 border rounded">
            <div class="infoTarjeta flex-grow-1 me-3">
              <h4 class="text-break"><?= htmlspecialchars($n['texto_novedad']) ?></h4>
              <p>#<?= $n['cod_novedad'] ?></p>
              <p><small>Desde: <?= $n['fecha_desde_novedad'] ?> | Hasta: <?= $n['fecha_hasta_novedad'] ?></small></p>
            </div>
            <div class="acciones">
              <a href="VerNovedad.php?cod_novedad=<?= $n['cod_novedad'] ?>" class="btn btn-primary btn-sm">VER DETALLES</a>
              <a href="EditarNovedad.php?cod_novedad=<?= $n['cod_novedad'] ?>" class="btn btn-secondary btn-sm">EDITAR</a>
              <form action="EliminarNovedad.php" method="POST" onsubmit="return confirm('¿Seguro que quieres eliminar esta novedad?');">
                <input type="hidden" name="cod_novedad" value="<?= $n['cod_novedad'] ?>">
                <button type="submit" class="btn btn-danger btn-sm">ELIMINAR</button>
              </form>
            </div>
          </div>
        <?php endwhile; ?>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>