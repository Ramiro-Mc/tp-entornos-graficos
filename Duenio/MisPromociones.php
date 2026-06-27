<?php
include_once("../Includes/session.php");
include("../Includes/funciones.php");
sesionIniciada();
if (!isset($_SESSION['cod_usuario'])) {
  header("Location: ../principal/InicioSesion.php");
  exit;
}


$diasSemanaNombre = [
  1 => "Lunes",
  2 => "Martes",
  3 => "Miércoles",
  4 => "Jueves",
  5 => "Viernes",
  6 => "Sábado",
  7 => "Domingo"
];

$folder = "Dueño";
$pestaña = "Mis Promociones";
$cod_usuario = $_SESSION['cod_usuario'];
include("../Includes/conexion.inc");

$mensaje = "";
$cantPagina = 5;
$pagina = isset($_GET["pagina"]) ? max(1, intval($_GET["pagina"])) : 1;
$principio = ($pagina - 1) * $cantPagina;

// 1. Obtener los códigos de locales del dueño
$codigoslocales = [];
$sqlLocal = "SELECT cod_local FROM locales WHERE cod_usuario = '$cod_usuario'";
$localResult = consultaSQL($sqlLocal);

if ($localResult && mysqli_num_rows($localResult) > 0) {
  while ($row = mysqli_fetch_assoc($localResult)) {
    $codigoslocales[] = $row['cod_local'];
  }
}

$promociones = null;
$totalPaginas = 0;
$diasPorPromo = [];
$conteoUsos = [];
$promos_array = [];

// 2. Solo procedemos si existen locales para evitar errores de SQL
if (!empty($codigoslocales)) {
  $listaLocales = implode(',', $codigoslocales);

  // Lógica de eliminación
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    $codPromoEliminar = intval($_POST['eliminar']);
    $sqlEliminar = "DELETE FROM promociones WHERE cod_promocion = $codPromoEliminar AND cod_local IN ($listaLocales)";
    if (consultaSQL($sqlEliminar)) {
      $mensaje = "<div id='mensaje-alerta' class='alert alert-success'>Promoción eliminada correctamente.</div>";
    } else {
      $mensaje = "<div class='alert alert-danger'>Error al eliminar la promoción.</div>";
    }
  }

  // Consulta de Promociones (Sin orden dinámico, por defecto ID ASC)
  $sqlPromociones = "SELECT p.*, l.nombre_local FROM promociones p 
                       INNER JOIN locales l ON p.cod_local = l.cod_local
                       WHERE p.cod_local IN ($listaLocales) 
                       ORDER BY p.cod_promocion ASC
                       LIMIT $cantPagina OFFSET $principio";
  $promociones = consultaSQL($sqlPromociones);

  // Guardar resultados en array para reutilizar
  if ($promociones && mysqli_num_rows($promociones) > 0) {
    while ($fila = mysqli_fetch_assoc($promociones)) {
      $promos_array[] = $fila;
    }
  }

  // Total para paginación
  $sqlTotal = "SELECT COUNT(*) as total FROM promociones WHERE cod_local IN ($listaLocales)";
  $resTotal = consultaSQL($sqlTotal);
  $totalPromos = mysqli_fetch_assoc($resTotal)['total'];
  $totalPaginas = ceil($totalPromos / $cantPagina);

  // Días de la semana
  $sqlDias = "SELECT pd.cod_promocion, pd.cod_dia FROM promocion_dia pd
                INNER JOIN promociones p ON pd.cod_promocion = p.cod_promocion
                WHERE p.cod_local IN ($listaLocales)";
  $resDias = consultaSQL($sqlDias);
  if ($resDias) {
    while ($row = mysqli_fetch_assoc($resDias)) {
      $diasPorPromo[$row['cod_promocion']][] = $row['cod_dia'];
    }
  }

  // Conteo de usos
  $sqlUso = "SELECT cod_promocion, COUNT(*) as total_usos FROM uso_promociones 
               WHERE estado = 'aceptada' GROUP BY cod_promocion";
  $resUso = consultaSQL($sqlUso);
  if ($resUso) {
    while ($row = mysqli_fetch_assoc($resUso)) {
      $conteoUsos[$row['cod_promocion']] = $row['total_usos'];
    }
  }
} else {
  $mensaje = "<p class='text-center'>No tienes locales registrados a tu nombre.</p>";
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <?php include("../Includes/head.php"); ?>
  <title>Mis Promociones</title>
</head>

<body>
  <header>

    <?php include("../Includes/header.php"); ?>

  </header>

  <main class="FondoDueñoAdministrador">
    <div class="container mt-3">
      <?php echo $mensaje; ?>
    </div>

    <div class="promociones">
      <?php if (!empty($promos_array)): ?>
        <?php foreach ($promos_array as $promo): ?>
          <div class="promocion-cli container-fluid bg-white rounded-4 shadow-sm mb-4 p-3 dueño-promo-card">
            <div class="row align-items-center">
              <div class="col-4 col-md-3 col-lg-2 text-center">
                <?php if (!empty($promo['foto_promocion'])): ?>
                  <?php if (strpos($promo['foto_promocion'], 'uploads/') === 0): ?>
                    <img src="../<?php echo $promo['foto_promocion']; ?>" alt="Imagen promo" class="img-fluid rounded-3 shadow-sm dueño-promo-img">
                  <?php else: ?>
                    <img src="data:image/jpeg;base64,<?php echo $promo['foto_promocion']; ?>" alt="Imagen promo" class="img-fluid rounded-3 shadow-sm dueño-promo-img">
                  <?php endif; ?>
                <?php else: ?>
                  <div class="bg-light rounded-3 d-flex align-items-center justify-content-center mx-auto dueño-promo-placeholder">
                    <i class="bi bi-image dueño-promo-placeholder-icon"></i>
                  </div>
                <?php endif; ?>
              </div>
              <div class="col-8 col-md-9 col-lg-10 d-flex justify-content-between align-items-center">
                <div class="info w-100 ps-2">
                  <h4 class="dueño-promo-title"><?php echo htmlspecialchars($promo['texto_promocion']); ?></h4>
                  
                  <?php
                  $hoy = date("Y-m-d");
                  if ($promo['estado_promo'] == 'rechazada') {
                    $estado = "<span class='badge rounded-pill badge-estado-rechazada px-3 py-1 shadow-sm'><i class='bi bi-x-circle me-1'></i>Rechazada</span>";
                  } elseif ($promo['estado_promo'] == 'pendiente') {
                    $estado = "<span class='badge rounded-pill bg-secondary px-3 py-1 shadow-sm text-white'><i class='bi bi-clock-history me-1'></i>Pendiente</span>";
                  } elseif ($promo['fecha_hasta_promocion'] < $hoy) {
                    $estado = "<span class='badge rounded-pill bg-danger px-3 py-1 shadow-sm'><i class='bi bi-calendar-x me-1'></i>Vencida</span>";
                  } elseif ($promo['fecha_desde_promocion'] > $hoy) {
                    $estado = "<span class='badge rounded-pill px-3 py-1 shadow-sm badge-estado-proxima'><i class='bi bi-calendar-plus me-1'></i>Próxima</span>";
                  } else {
                    $estado = "<span class='badge rounded-pill badge-estado-aceptada px-3 py-1 shadow-sm'><i class='bi bi-check-circle me-1'></i>Activa</span>";
                  }
                  ?>

                  <div class="d-flex flex-wrap gap-3 mt-2 text-muted dueño-promo-details">
                    <div class="d-flex align-items-center"><i class="bi bi-shop text-primary me-2"></i> <b><?php echo htmlspecialchars($promo['nombre_local']); ?></b></div>
                    <div class="d-flex align-items-center"><?php echo $estado; ?></div>
                    <div class="d-flex align-items-center"><i class="bi bi-calendar-range text-info me-2"></i> <?php echo date("d/m", strtotime($promo['fecha_desde_promocion'])); ?> al <?php echo date("d/m/Y", strtotime($promo['fecha_hasta_promocion'])); ?></div>
                    <div class="d-flex align-items-center" title="Días activos"><i class="bi bi-calendar-week text-secondary me-2"></i> 
                      <?php
                      $id = $promo['cod_promocion'];
                      if (isset($diasPorPromo[$id])) {
                        $nombres = array_map(function ($d) use ($diasSemanaNombre) {
                          return substr($diasSemanaNombre[$d], 0, 3);
                        }, $diasPorPromo[$id]);
                        echo implode(', ', $nombres);
                      } else {
                        echo "Ninguno";
                      }
                      ?>
                    </div>
                    <div class="d-flex align-items-center"><i class="bi bi-person-badge text-warning me-2"></i> <?php echo htmlspecialchars($promo['categoria_cliente']); ?></div>
                    <div class="d-flex align-items-center"><i class="bi bi-bar-chart-line text-success me-2"></i> Usos: <b class="ms-1"><?php echo $conteoUsos[$id] ?? 0; ?></b></div>
                  </div>
                </div>

                <div class="acciones ms-3">
                  <button
                    type="button"
                    class="btn btn-outline-danger d-flex align-items-center justify-content-center rounded-circle shadow-sm btn-dueño-delete"
                    data-bs-toggle="modal"
                    data-bs-target="#modal-eliminar-<?php echo $promo['cod_promocion']; ?>"
                    title="Eliminar promoción">
                    <i class="bi bi-trash3-fill btn-dueño-delete-icon"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php elseif (!empty($codigoslocales)): ?>
        <p class="text-center mt-4">No se encontraron promociones.</p>
      <?php endif; ?>
    </div>

    <?php if ($totalPaginas > 1): ?>
      <div class="row mt-4">
        <div class="col-12 d-flex justify-content-center">
          <nav>
            <ul class="pagination">
              <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                <li class="page-item <?php echo ($i == $pagina) ? 'active' : ''; ?>">
                  <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
              <?php endfor; ?>
            </ul>
          </nav>
        </div>
      </div>
    <?php endif; ?>
  </main>

  <footer class="seccion-footer">
    <?php include("../Includes/footer.php") ?>
  </footer>

  <?php if (!empty($promos_array)): ?>
    <?php foreach ($promos_array as $promo): ?>
      <div class="modal" id="modal-eliminar-<?php echo $promo['cod_promocion']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEliminarLabel-<?php echo $promo['cod_promocion']; ?>" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content modal-eliminar-promo">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="modalEliminarLabel-<?php echo $promo['cod_promocion']; ?>" style="margin: auto; font-size: 1.6rem;">Eliminar promoción</h1>
            </div>
            <div class="modal-body text-center">
              <p style="font-size: 1.2rem; color:black;">¿Seguro que querés eliminar esta promoción?</p>
            </div>
            <div class="modal-footer d-flex justify-content-around">
              <form method="POST" class="m-0">
                <input type="hidden" name="eliminar" value="<?php echo $promo['cod_promocion']; ?>">
                <button type="submit" class="btn btn-danger">Eliminar</button>
              </form>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>

</html>