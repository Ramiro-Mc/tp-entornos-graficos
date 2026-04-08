<?php
$folder = "Administrador";
$pestaña = "Solicitudes Registro";
include_once("../Includes/funciones.php");
sesionIniciada();

include("../Includes/conexion.inc");

// --- Procesar acciones (aprobar / rechazar) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cod_usuario'], $_POST['accion'])) {
  $cod = intval($_POST['cod_usuario']);
  $accion = $_POST['accion'];

  if ($accion === "aprobar") {
    $link->query("UPDATE dueño_local SET estado = 'aprobado' WHERE cod_usuario = $cod");
  } elseif ($accion === "rechazar") {
    $link->query("UPDATE dueño_local SET estado = 'rechazado' WHERE cod_usuario = $cod");
  }

  header("Location: SolicitudesRegistro.php");
  exit;
}

// --- Paginación ---
$pagina = isset($_GET['pagina']) && is_numeric($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$solicitudes_por_pagina = 5;
$offset = ($pagina - 1) * $solicitudes_por_pagina;

// Solo solicitudes pendientes (Unimos dueño_local con usuario para mostrar el nombre/email)
$result = $link->query("
  SELECT d.cod_usuario, d.estado, u.nombre_usuario, u.email
  FROM dueño_local d
  JOIN usuario u ON d.cod_usuario = u.cod_usuario
  WHERE d.estado = 'pendiente'
  ORDER BY d.cod_usuario DESC
  LIMIT $solicitudes_por_pagina OFFSET $offset
");

$solicitudes = [];
if ($result && $result->num_rows > 0) {
  while ($fila = $result->fetch_assoc()) {
    $solicitudes[] = $fila;
  }
}

// Contar solo solicitudes pendientes
$total_result = $link->query("SELECT COUNT(*) AS total FROM dueño_local WHERE estado = 'pendiente'");
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
    <div class="promociones">
      <?php if (!empty($solicitudes)): ?>
        <?php foreach ($solicitudes as $s): ?>
          <div class="promocion d-flex justify-content-between align-items-start mb-3 p-3 border rounded">
            <div class="infoTarjeta flex-grow-1 me-3">
              <h4 class="text-break">Solicitud de Dueño</h4>
              <p><b>Usuario:</b> <?= htmlspecialchars($s['nombre_usuario']) ?> (ID: <?= $s['cod_usuario'] ?>)</p>
              <p><small>Email: <?= htmlspecialchars($s['email']) ?></small></p>
              <p><small>Estado: <?= ucfirst($s['estado']) ?></small></p>
            </div>
            <div class="acciones d-flex flex-column gap-2">
              <button
                type="button"
                class="btn btn-success btn-sm"
                data-bs-toggle="modal"
                data-bs-target="#modal-aprobar-<?= $s['cod_usuario'] ?>">
                APROBAR
              </button>
              <button
                type="button"
                class="btn btn-danger btn-sm"
                data-bs-toggle="modal"
                data-bs-target="#modal-rechazar-<?= $s['cod_usuario'] ?>">
                RECHAZAR
              </button>
            </div>
          </div>
        <?php endforeach; ?>
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

  <?php foreach ($solicitudes as $s): ?>
    <div class="modal" id="modal-aprobar-<?= $s['cod_usuario'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalAprobarLabel-<?= $s['cod_usuario'] ?>" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content modal-solicitud-accion modal-solicitud-aprobar">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="modalAprobarLabel-<?= $s['cod_usuario'] ?>" style="margin: auto; font-size: 1.6rem;">Aprobando solicitud</h1>
          </div>
          <div class="modal-body text-center">
            <p style="font-size: 1.2rem; color:black;">¿Aprobar esta solicitud?</p>
          </div>
          <div class="modal-footer d-flex justify-content-around">
            <form method="POST" class="m-0">
              <input type="hidden" name="cod_usuario" value="<?= $s['cod_usuario'] ?>">
              <input type="hidden" name="accion" value="aprobar">
              <button type="submit" class="btn btn-success">Aprobar solicitud</button>
            </form>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal" id="modal-rechazar-<?= $s['cod_usuario'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalRechazarLabel-<?= $s['cod_usuario'] ?>" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content modal-solicitud-accion modal-solicitud-rechazar">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="modalRechazarLabel-<?= $s['cod_usuario'] ?>" style="margin: auto; font-size: 1.6rem;">Rechazando solicitud</h1>
          </div>
          <div class="modal-body text-center">
            <p style="font-size: 1.2rem; color:black;">¿Rechazar esta solicitud?</p>
          </div>
          <div class="modal-footer d-flex justify-content-around">
            <form method="POST" class="m-0">
              <input type="hidden" name="cod_usuario" value="<?= $s['cod_usuario'] ?>">
              <input type="hidden" name="accion" value="rechazar">
              <button type="submit" class="btn btn-danger">Rechazar solicitud</button>
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