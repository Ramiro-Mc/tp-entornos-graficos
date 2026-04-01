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
$cantPagina = 8;
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

// 2. Solo procedemos si existen locales para evitar errores de SQL
if (!empty($codigoslocales)) {
  $listaLocales = implode(',', $codigoslocales);

  // Lógica de eliminación
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    $codPromoEliminar = intval($_POST['eliminar']);
    $sqlEliminar = "DELETE FROM promociones WHERE cod_promocion = $codPromoEliminar AND cod_local IN ($listaLocales)";
    if (consultaSQL($sqlEliminar)) {
      $mensaje = "<div class='alert alert-success'>Promoción eliminada correctamente.</div>";
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
  $mensaje = "<div class='alert alert-warning'>No tienes locales registrados a tu nombre.</div>";
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
      <?php if ($promociones && mysqli_num_rows($promociones) > 0): ?>
        <?php while ($promo = mysqli_fetch_assoc($promociones)): ?>
          <div class="promocion">
            <div class="infoTarjeta">
              <h3><?php echo htmlspecialchars($promo['texto_promocion']); ?></h3>
              <?php if (!empty($promo['foto_promocion'])): ?>
                <img src="data:image/png;base64,<?php echo $promo['foto_promocion']; ?>" alt="Imagen promo" style="max-width:150px;max-height:150px;">
              <?php endif; ?>
              <p><b>Código:</b> <?php echo $promo['cod_promocion']; ?></p>
              <p><b>Vigencia:</b> <?php echo htmlspecialchars($promo['fecha_desde_promocion']); ?> al <?php echo htmlspecialchars($promo['fecha_hasta_promocion']); ?></p>
              <p><b>Estado:</b> <?php echo htmlspecialchars($promo['estado_promo']); ?></p>
              <p><b>Local:</b> <?php echo htmlspecialchars($promo['nombre_local']); ?></p>

              <p><b>Días:</b>
                <?php
                $id = $promo['cod_promocion'];
                if (isset($diasPorPromo[$id])) {
                  $nombres = array_map(function ($d) use ($diasSemanaNombre) {
                    return $diasSemanaNombre[$d];
                  }, $diasPorPromo[$id]);
                  echo implode(', ', $nombres);
                } else {
                  echo "No asignados";
                }
                ?>
              </p>

              <p><b>Usos:</b> <?php echo $conteoUsos[$id] ?? 0; ?></p>
            </div>
            <div class="acciones">
              <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminar" data-cod="<?php echo $promo['cod_promocion']; ?>">
                ELIMINAR
              </button>
            </div>
          </div>
        <?php endwhile; ?>
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

  <footer>
    <?php include("../Includes/footer.php"); ?>
  </footer>

  <div class="modal fade" id="modalEliminar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmar eliminación</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <form method="POST">
          <div class="modal-body">
            ¿Estás seguro de que deseas eliminar esta promoción?
            <input type="hidden" name="eliminar" id="inputEliminar">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-danger">Eliminar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    var modalEliminar = document.getElementById('modalEliminar');
    modalEliminar.addEventListener('show.bs.modal', function(event) {
      var button = event.relatedTarget;
      var cod = button.getAttribute('data-cod');
      document.getElementById('inputEliminar').value = cod;
    });
  </script>
</body>

</html>