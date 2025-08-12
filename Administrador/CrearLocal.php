<?php
include("../conexion.inc");
$mensaje = "";
$rutaMultimedia = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $vNombre = $_POST['nombreLocal'];
  $vUbicacion = $_POST['ubicacion'];
  $vRubro = $_POST['rubro'];
  $vCodUsuario = "1";

  if (isset($_FILES['archivoMultimedia']) && $_FILES['archivoMultimedia']['error'] === UPLOAD_ERR_OK) {
    $vMultimedia = basename($_FILES['archivoMultimedia']['name']);
    $rutaDestino = "../uploads/" . $vMultimedia;

    if (move_uploaded_file($_FILES['archivoMultimedia']['tmp_name'], $rutaDestino)) {
      $rutaMultimedia = "uploads/" . $vMultimedia;
    } else {
      $mensaje = "Error al mover el archivo.";
    }
  }

  $vSql = "SELECT COUNT(*) as cantidad FROM Local WHERE NombreLocal='$vNombre'";
  $vResultado = mysqli_query($link, $vSql) or die(mysqli_error($link));
  $vCantLocales = mysqli_fetch_assoc($vResultado);

  if ($vCantLocales['cantidad'] != 0) {
    $mensaje = "El local ya existe.";
  } else {
    $vSql = "INSERT INTO Local (NombreLocal, UbicacionLocal, RubroLocal, CodUsuario, Multimedia)  
        VALUES ('$vNombre', '$vUbicacion', '$vRubro', '$vCodUsuario', '$rutaDestino')";
    mysqli_query($link, $vSql) or die(mysqli_error($link));
    $mensaje = "El local fue registrado correctamente.";
  }
  mysqli_free_result($vResultado);
  mysqli_close($link);
}

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
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <link rel="stylesheet" href="../Styles/style.css" />
  <link rel="stylesheet" href="../Styles/style-general.css" />
  <link rel="icon" type="image/x-icon" href="../Images/logo.png" />
  <title>Crear Nuevo Local</title>
</head>

<body>
  <header>
    <div class="top-bar">
      <a href="SeccionAdministrador.html">
        <img class="logo" src="../Images/Logo.png" alt="FotoShopping" />
      </a>
      <nav>
        <!-- <a href="MiPerfil.html">Usuario</a> -->
        <a href="CerrarSesion.html">Cerrar Sesion</a>
      </nav>
    </div>
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
          name="nombreLocal"
          placeholder="Ingrese el nombre del local"
          required
          value="<?= isset($_POST['nombreLocal']) ? htmlspecialchars($_POST['nombreLocal']) : '' ?>" />
        <p>Ubicacion</p>
        <div class="position-relative">
          <select class="form-control controls" name="ubicacion" required>
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
        <div class="position-relative">
          <select class="form-control controls" name="rubro" required>
            <option <?= (isset($_POST['rubro']) && $_POST['rubro'] == 'Accesorios') ? 'selected' : '' ?>>Accesorios</option>
            <option <?= (isset($_POST['rubro']) && $_POST['rubro'] == 'Deportes') ? 'selected' : '' ?>>Deportes</option>
            <option <?= (isset($_POST['rubro']) && $_POST['rubro'] == 'Electro') ? 'selected' : '' ?>>Electro</option>
            <option <?= (isset($_POST['rubro']) && $_POST['rubro'] == 'Estetica') ? 'selected' : '' ?>>Estetica</option>
            <option <?= (isset($_POST['rubro']) && $_POST['rubro'] == 'Gastronomia') ? 'selected' : '' ?>>Gastronomia</option>
            <option <?= (isset($_POST['rubro']) && $_POST['rubro'] == 'Calzado') ? 'selected' : '' ?>>Calzado</option>
            <option <?= (isset($_POST['rubro']) && $_POST['rubro'] == 'Indumentaria') ? 'selected' : '' ?>>Indumentaria</option>
            <option <?= (isset($_POST['rubro']) && $_POST['rubro'] == 'Varios') ? 'selected' : '' ?>>Varios</option>
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