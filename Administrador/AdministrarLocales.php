<?php
require '../conexion.inc';
// Orden por defecto
$order = 'Id ASC';

// Chequeo parámetro GET para ordenar
if (isset($_GET['order'])) {
  switch ($_GET['order']) {
    case 'nombre_asc':
      $order = 'NombreLocal ASC';
      break;
    case 'nombre_desc':
      $order = 'NombreLocal DESC';
      break;
    case 'id_desc':
      $order = 'Id DESC';
      break;
    case 'id_asc':
    default:
      $order = 'Id ASC';
      break;
  }
}

$sql = "SELECT Id, NombreLocal FROM local ORDER BY $order";
$result = $link->query($sql);

// Consulta para obtener todos los locales
$sql = "SELECT Id, NombreLocal FROM local";
$result = $link->query($sql);
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <!-- Importar BootStrap -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7"
    crossorigin="anonymous" />

  <!-- Importar iconos BootStrap -->
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

  <!-- Metadatos -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../Styles/style.css" />
  <link rel="stylesheet" href="../Styles/style-general.css" />
  <link rel="icon" type="image/x-icon" href="../Images/logo.png" />
  <title>Administrar Locales</title>
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
      <a href="CrearLocal.php">
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
          <li><a class="dropdown-item" href="AdministrarLocales.php?order=id_asc">ID ↑</a></li>
          <li><a class="dropdown-item" href="AdministrarLocales.php?order=id_desc">ID ↓</a></li>
        </ul>
      </div>
    </div>

    <div class="promociones">
      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <div class="promocion">
            <div class="infoTarjeta">
              <h3><?php echo htmlspecialchars($row['NombreLocal']); ?></h3>
              <p>#<?php echo $row['Id']; ?></p>
            </div>
            <div class="acciones">
              <a href="VerLocal.php?id=<?php echo $row['Id']; ?>" class="btn btn-primary">VER DETALLES</a>
              <a href="EditarLocal.php?id=<?php echo $row['Id']; ?>" class="btn btn-secondary">EDITAR</a>
              <a href="EliminarLocal.php?id=<?php echo $row['Id']; ?>" class="btn btn-danger" onclick="return confirm('¿Seguro que quieres eliminar este local?');">ELIMINAR</a>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>No hay locales registrados.</p>
      <?php endif; ?>
    </div>

    <div aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">Next</a></li>
      </ul>
    </div>
  </main>

  <footer
    class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4">
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
    crossorigin="anonymous"></script>
</body>

</html>
<?php
$link->close();
?>