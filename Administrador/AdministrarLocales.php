<?php

$folder = "Administrador";
$pestaña = "Administrar Locales";
include_once("../Includes/funciones.php");
sesionIniciada();

require '../conexion.inc';
// Orden por defecto
$order = 'cod_local ASC';

// Chequeo parámetro GET para ordenar
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
$sql = "SELECT cod_local, nombre_local FROM locales ORDER BY $order";
$result = $link->query($sql);
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
            <li><a class="dropdown-item" href="AdministrarLocales.php?order=cod_local_asc">ID ↑</a></li>
            <li><a class="dropdown-item" href="AdministrarLocales.php?order=cod_local_desc">ID ↓</a></li>
          </ul>
        </div>
      </div>

      <div class="promociones">
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <div class="promocion">
              <div class="infoTarjeta">
                <h3><?php echo htmlspecialchars($row['nombre_local']); ?></h3>
                <p>#<?php echo $row['cod_local']; ?></p>
              </div>
              <div class="acciones">
                <a href="VerLocal.php?cod_local=<?php echo $row['cod_local']; ?>" class="btn btn-primary">VER DETALLES</a>
                <a href="EditarLocal.php?cod_local=<?php echo $row['cod_local']; ?>" class="btn btn-secondary">EDITAR</a>
                <a href="EliminarLocal.php?cod_local=<?php echo $row['cod_local']; ?>" class="btn btn-danger" onclick="return confirm('¿Seguro que quieres eliminar este local?');">ELIMINAR</a>
              </div>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <p class="text-center">No hay locales registrados.</p>
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

    <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4">

      <?php include("../Includes/footer.php") ?>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
  </body>

</html>
<?php
$link->close();
?>