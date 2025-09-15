<?php
$folder = "Administrador";
$pestaña = "Administrar Solicitudes";
include_once("../Includes/funciones.php");
sesionIniciada();

include("../conexion.inc");

// --- Procesar acciones (aprobar / rechazar) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cod_solicitud'], $_POST['accion'])) {
    $cod = intval($_POST['cod_solicitud']);
    $accion = $_POST['accion'];

    if ($accion === "aprobar") {
        $link->query("UPDATE solicitudes SET estado = 'Aprobada' WHERE cod_solicitud = $cod");
    } elseif ($accion === "rechazar") {
        $link->query("UPDATE solicitudes SET estado = 'Rechazada' WHERE cod_solicitud = $cod");
    }

    header("Location: AdministrarSolicitudes.php");
    exit;
}

// --- Paginación ---
$pagina = isset($_GET['pagina']) && is_numeric($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$solicitudes_por_pagina = 5;
$offset = ($pagina - 1) * $solicitudes_por_pagina;

$result = $link->query("
  SELECT cod_solicitud, fecha_solicitud, cod_usuario, estado
  FROM solicitudes
  ORDER BY fecha_solicitud DESC
  LIMIT $solicitudes_por_pagina OFFSET $offset
");

$total_result = $link->query("SELECT COUNT(*) AS total FROM solicitudes");
$total_row = $total_result->fetch_assoc();
$total_solicitudes = $total_row['total'];
$total_paginas = ceil($total_solicitudes / $solicitudes_por_pagina);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <?php include("../Includes/head.php"); ?>
  <title>Administrar Solicitudes</title>
</head>

<body>
  <header>
    <?php include("../Includes/header.php"); ?>
  </header>

  <main class="FondoDueñoAdministrador">
    <div class="container-fluid filtraderos justify-content-end">
      <h2>Solicitudes de Dueños de Locales</h2>
    </div>

    <div class="promociones">
      <?php if ($result->num_rows): ?>
        <?php while ($s = $result->fetch_assoc()): ?>
          <div class="promocion d-flex justify-content-between align-items-start mb-3 p-3 border rounded">
            <div class="infoTarjeta flex-grow-1 me-3">
              <h4 class="text-break">Solicitud #<?= $s['cod_solicitud'] ?></h4>
              <p><b>Usuario:</b> <?= $s['cod_usuario'] ?></p>
              <p><small>Fecha: <?= $s['fecha_solicitud'] ?></small></p>
              <p><small>Estado: <?= $s['estado'] ?? 'Pendiente' ?></small></p>
            </div>
            <div class="acciones d-flex flex-column gap-2">
              <?php if ($s['estado'] === NULL || $s['estado'] === 'Pendiente'): ?>
                <form method="POST" onsubmit="return confirm('¿Aprobar esta solicitud?');">
                  <input type="hidden" name="cod_solicitud" value="<?= $s['cod_solicitud'] ?>">
                  <input type="hidden" name="accion" value="aprobar">
                  <button type="submit" class="btn btn-success btn-sm">APROBAR</button>
                </form>
                <form method="POST" onsubmit="return confirm('¿Rechazar esta solicitud?');">
                  <input type="hidden" name="cod_solicitud" value="<?= $s['cod_solicitud'] ?>">
                  <input type="hidden" name="accion" value="rechazar">
                  <button type="submit" class="btn btn-danger btn-sm">RECHAZAR</button>
                </form>
              <?php else: ?>
                <span class="badge bg-secondary">Ya revisada</span>
              <?php endif; ?>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p class="text-center">No hay solicitudes pendientes.</p>
      <?php endif; ?>
    </div>

    <div class="mt-4">
      <?php paginacion($pagina, $total_paginas, []); ?>
    </div>
  </main>

  <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4">
    <?php include("../Includes/footer.php") ?>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
