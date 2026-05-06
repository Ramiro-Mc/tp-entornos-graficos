<?php
$folder = "Administrador";
$pestaña = "Reporte Promociones";
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
$order = 'p.cod_promocion ASC';

if (isset($_GET['order'])) {
  switch ($_GET['order']) {
    case 'nombre_asc':
      $order = 'p.texto_promocion ASC';
      break;
    case 'nombre_desc':
      $order = 'p.texto_promocion DESC';
      break;
    case 'usos_desc':
      $order = 'usos DESC';
      break;
    case 'usos_asc':
      $order = 'usos ASC';
      break;
    default:
      $order = 'p.cod_promocion ASC';
      break;
  }
}

$result = $link->query("
  SELECT 
    p.cod_promocion, 
    p.texto_promocion, 
    p.categoria_cliente,
    COUNT(u.cod_promocion) AS usos
  FROM promociones p
  LEFT JOIN uso_promociones u ON p.cod_promocion = u.cod_promocion
  GROUP BY p.cod_promocion
  ORDER BY $order
  LIMIT $promociones_por_pagina OFFSET $offset
");

$total_result = $link->query("SELECT COUNT(*) AS total FROM promociones");
$total_row = $total_result->fetch_assoc();
$total_promociones = $total_row['total'];
$total_paginas = ceil($total_promociones / $promociones_por_pagina);

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <?php include("../Includes/head.php"); ?>
  <title>Reporte de Uso de Promociones</title>
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
          <li><a class="dropdown-item" href="ReportePromociones.php?order=nombre_asc">Nombre ↑</a></li>
          <li><a class="dropdown-item" href="ReportePromociones.php?order=nombre_desc">Nombre ↓</a></li>
          <li><a class="dropdown-item" href="ReportePromociones.php?order=usos_asc">Usos ↑</a></li>
          <li><a class="dropdown-item" href="ReportePromociones.php?order=usos_desc">Usos ↓</a></li>
        </ul>
      </div>
    </div>

    <div class="promociones">
      <?php if ($result->num_rows): ?>
        <?php while ($p = $result->fetch_assoc()): ?>
          <div class="promocion-cli container-fluid bg-white rounded-4 shadow-sm mb-4 p-3 dueño-promo-card">
            <div class="row align-items-center">
              <div class="col-12 d-flex justify-content-between align-items-center">
                <div class="info w-100 ps-2">
                  <h4 class="dueño-promo-title"><?= htmlspecialchars($p['texto_promocion']) ?></h4>
                  <div class="d-flex flex-wrap gap-3 mt-2 text-muted dueño-promo-details">
                    <div class="d-flex align-items-center"><i class="bi bi-person-badge text-warning me-2"></i> <?= htmlspecialchars($p['categoria_cliente']) ?></div>
                    <div class="d-flex align-items-center"><i class="bi bi-bar-chart-line text-success me-2"></i> Usos: <b class="ms-1"><?= $p['usos'] ?></b></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p class="text-center">No hay promociones registradas.</p>
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