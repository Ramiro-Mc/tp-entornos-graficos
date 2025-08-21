<?php
require '../conexion.inc';
// Orden por defecto
$order = 'cod_promocion ASC';

// Chequeo parámetro GET para ordenar
if (isset($_GET['order'])) {
  switch ($_GET['order']) {
    case 'nombre_asc':
      $order = 'cod_promocion ASC';
      break;
    case 'nombre_desc':
      $order = 'cod_promocion DESC';
      break;
  }
}

if (isset($_GET['cod_promocion']) && isset($_GET['accion'])) {
    $cod_promocion = intval($_GET['cod_promocion']); // seguridad
    $accion = $_GET['accion'];

    if ($accion === 'aceptar') {
        $nuevo_estado = 'aceptada';
    } elseif ($accion === 'rechazar') {
        $nuevo_estado = 'rechazada';
    }

    if (isset($nuevo_estado)) {
        $sql_update = "UPDATE promociones SET estado_promo = '$nuevo_estado' WHERE cod_promocion = $cod_promocion";
        $link->query($sql_update);
        // Redirigir para evitar reenvío al refrescar
        header("Location: AdministrarPromociones.php");
        exit();
    }
}

$sql = "SELECT cod_promocion, texto_promocion,  FROM promociones ORDER BY $order";
$result = $link->query($sql);
?>

<!DOCTYPE html>
<html lang="es ">
  <head>
    <!-- Importar BootStrap -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7"
      crossorigin="anonymous"
    />

    <!-- Importar iconos BootStrap -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />

    <!-- Metadatos -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../Styles/style.css" />
    <link rel="stylesheet" href="../Styles/style-general.css" />
    <link rel="icon" type="image/x-icon" href="../Images/logo.png" />
    <title>Administrar Promociones</title>
  </head>
  
  <body>
      <header>
        <div class="top-bar">
          <a href="SeccionAdministrador.html">
            <img class="logo" src="../Images/Logo.png" alt="FotoShopping" />
          </a>
          <nav>
            <a href="CerrarSesion.html">Cerrar Sesion</a>
          </nav>
        </div>
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
          <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <div class="promocion">
                <div class="infoTarjeta">
                  <h3><?php echo htmlspecialchars($row['texto_promocion']); ?></h3>
                  <p>#<?php echo $row['cod_promocion']; ?></p>
                  <p>Estado: <?php echo htmlspecialchars($row['estado_promo']); ?></p>
                </div>
                <div class="acciones">
                  <a href="VerPromocion.php?cod_promocion=<?php echo $row['cod_promocion']; ?>" class="btn btn-primary">VER DETALLES</a>
                  <a href="AdministrarPromociones.php?cod_promocion=<?php echo $row['cod_promocion']; ?>&accion=aceptar" class="btn btn-success">ACEPTAR</a>
                  <a href="AdministrarPromociones.php?cod_promocion=<?php echo $row['cod_promocion']; ?>&accion=rechazar" class="btn btn-danger">RECHAZAR</a>
                </div>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
            <p>No hay promociones existentes.</p>
          <?php endif; ?>
        </div>
      </main>

    <footer
      class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4"
    >
      <div>
        <nav class="texto-footer">
          <h5>Mapa del sitio</h5>
          <div class="mb-2"><a href="SeccionAdministrador.html">Inicio</a></div>
          <div class="mb-2">
            <a href="AdministrarPromociones.html">Administrar Promociones</a>
          </div>
          <div class="mb-2">
            <a href="AdministrarNovedades.html">Administrar Novedades </a>
          </div>
          <div class="mb-2">
            <a href="AdministrarLocales.html">Administrar Locales</a>
          </div>
          <div class="mb-2">
            <a href="SolicitudRegistro.html">Solicitudes De Registro</a>
          </div>
          <div class="mb-2">
            <a href="ReportePromocionesAdm.html">Reportes De Uso Promociones</a>
          </div>
        </nav>
      </div>
      <p class="texto-footer text-center">
        © 2025 Viventa Store. Todos los derechos reservados.
      </p>
    </footer>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
