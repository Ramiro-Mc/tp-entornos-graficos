<?php

$folder = "Administrador";
$pestaña = "Crear Local";
include_once("../Includes/funciones.php");
include("../conexion.inc");
sesionIniciada();
$mensaje = "";
$rutaMultimedia = "";
$rubros = ['Accesorios', 'Deportes', 'Electro', 'Estetica', 'Gastronomia', 'Calzado', 'Indumentaria', 'Varios'];

$sqlUsuarios = "SELECT u.cod_usuario, u.nombre_usuario FROM usuario u";
$resUsuarios = mysqli_query($link, $sqlUsuarios) or die(mysqli_error($link));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $vNombre = $_POST['nombre_local'];
  $vUbicacion = $_POST['ubicacion_local'];
  $vRubro = $_POST['rubro_local'];
  $vCodUsuario = $_POST['cod_usuario'];
  $fotoLocal = "null";

  if (!empty($_FILES['archivoMultimedia']['name']) && $_FILES['archivoMultimedia']['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($_FILES['archivoMultimedia']['name'], PATHINFO_EXTENSION);
    $nuevoNombre = uniqid('local_', true) . "." . $ext;
    $rutaMultimedia = "../uploads/" . $nuevoNombre;
    if (move_uploaded_file($_FILES['archivoMultimedia']['tmp_name'], $rutaMultimedia)) {
      $fotoLocal = $nuevoNombre;
    }
  }

  $vSql = "SELECT COUNT(*) as cantidad FROM locales WHERE nombre_local='$vNombre'";
  $vResultado = mysqli_query($link, $vSql);

  $stmt = $link->prepare("SELECT COUNT(*) as cantidad FROM locales WHERE nombre_local = ?");
  $stmt->bind_param("s", $vNombre);
  $stmt->execute();
  $vResultado = $stmt->get_result();
  $vCantLocales = $vResultado->fetch_assoc();

  if ($vCantLocales['cantidad'] != 0) {
    $mensaje = "El local ya existe.";
  } else {
    $stmt = $link->prepare("INSERT INTO locales (nombre_local, ubicacion_local, rubro_local, cod_usuario, foto_local) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssis", $vNombre, $vUbicacion, $vRubro, $vCodUsuario, $rutaMultimedia);
    $stmt->execute();
  }
  mysqli_free_result($vResultado);
  mysqli_close($link);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

  <?php include("../Includes/head.php"); ?>

  <title>Crear Nuevo Local</title>

</head>

<body>
  <header>

    <?php include("../Includes/header.php"); ?>

  </header>

  <main class="FondoDueñoAdministrador">
    <div class="form-register">
      <form action="CrearLocal.php" method="POST" name="FormAltaLocal" enctype="multipart/form-data">
        <h4>Formulario Local</h4>

        <!-- Mensaje -->
        <?php if ($mensaje): ?>
          <div class="alert alert-info"><?= htmlspecialchars($mensaje) ?></div>
        <?php endif; ?>

        <p>Nombre Local</p>
        <input
          class="controls"
          type="text"
          name="nombre_local"
          placeholder="Ingrese el nombre del local"
          required
          value="<?= isset($_POST['nombre_local']) ? htmlspecialchars($_POST['nombre_local']) : '' ?>" />
        <p>Ubicacion</p>
        <div class="position-relative">
          <select class="form-control controls" name="ubicacion_local" required>
            <option>Ala A</option>
            <option>Ala B</option>
            <option>Ala C</option>
            <option>Ala D</option>
            <option>Ala E</option>
          </select>
          <i
            class="bi bi-chevron-down position-absolute"
            style="
                  right: 10px;
                  top: 50%;
                  transform: translateY(-50%);
                  pointer-events: none;
                  color: white;
                "></i>
        </div>
        <p>Rubro del local</p>
        <select name="rubro_local" class="form-control controls" required>
          <?php foreach ($rubros as $rubro): ?>
            <option value="<?= $rubro ?>" <?= ($rubro == ($_POST['rubro_local'] ?? '')) ? 'selected' : '' ?>>
              <?= $rubro ?>
            </option>
          <?php endforeach; ?>
        </select>
        <p>Dueño del Local</p>
        <div class="position-relative">
          <select class="form-control controls" name="cod_usuario" required>
            <option value="">Seleccione un dueño</option>
            <?php while ($duenio = mysqli_fetch_assoc($resUsuarios)) : ?>
              <option value="<?= $duenio['cod_usuario'] ?>"
                <?= (isset($_POST['cod_usuario']) && $_POST['cod_usuario'] == $duenio['cod_usuario']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($duenio['nombre_usuario']) ?>
              </option>
            <?php endwhile; ?>
          </select>
          <i class="bi bi-chevron-down position-absolute"
            style="right: 10px; top: 50%; transform: translateY(-50%); pointer-events: none; color: white;"></i>
        </div>
        <p>Archivo Multimedia</p>
        <div class="mb-3">
          <input
            class="form-control controls"
            type="file"
            name="archivoMultimedia" />
        </div>
        <div class="text-center mt-3">
          <button class="btn btn-success boton-enviar" type="submit">
            Enviar
          </button>
        </div>
        <div class="text-center mt-2">
          <a style="background: #0767f7" class="btn btn-success" href="AdministrarLocales.php">Volver</a>
        </div>
      </form>
    </div>
  </main>

  <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4">

    <?php include("../Includes/footer.php") ?>

  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>

</html>