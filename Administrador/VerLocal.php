<?php

$folder = "Administrador";
$pestaña = "Ver Local";

require "../conexion.inc";

if (!isset($_GET['cod_local']) || !is_numeric($_GET['cod_local'])) {
  header("Location: AdministrarLocales.php?mensaje=cod_local_invalido");
  exit;
}

$Vcod_local = intval($_GET['cod_local']);

$stmt = $link->prepare("SELECT nombre_local, rubro_local, ubicacion_local, cod_usuario, Multimedia FROM locales WHERE cod_local = ?");
$stmt->bind_param("i", $Vcod_local);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  $stmt->close();
  $link->close();
  header("Location: AdministrarLocales.php?mensaje=no_encontrado");
  exit;
}

$local = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">

  <head>

    <?php include("../Includes/head.php"); ?>

    <title>Detalle del Local</title>

  </head>

  <body>

    <header>

      <?php include("../Includes/header.php"); ?>

    </header>

    <main>

      <div class="container mt-4">
        <h1>Detalle del Local</h1>

        <div class="card">
          <div class="card-body">
            <h3 class="card-title"><?php echo htmlspecialchars($local['nombre_local']); ?></h3>
            <p><strong>Rubro:</strong> <?php echo htmlspecialchars($local['rubro_local']); ?></p>
            <p><strong>Ubicación:</strong> <?php echo htmlspecialchars($local['ubicacion_local']); ?></p>
            <p><strong>Codigo Dueño:</strong> <?php echo htmlspecialchars($local['cod_usuario']); ?></p>
            <?php if (!empty($local['Multimedia'])): ?>
              <p><strong>Multimedia:</strong></p>
              <img src="<?php echo htmlspecialchars($local['Multimedia']); ?>" alt="Imagen del local" style="max-width: 300px; height: auto;">
            <?php else: ?>
              <p><strong>Multimedia:</strong> No hay imagen disponible</p>
            <?php endif; ?>
          </div>
        </div>

        <a href="AdministrarLocales.php" class="btn btn-secondary mt-3">Volver</a>
      </div>

    </main>

    <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4">

      <?php include("../Includes/footer.php") ?>
    
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
  
  </body>
</html>