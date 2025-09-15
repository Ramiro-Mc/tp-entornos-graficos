<?php

$folder = "Administrador";
$pestaña = "Editar Local";
include_once("../Includes/funciones.php");
require "../conexion.inc";
sesionIniciada();

if (!isset($_GET['cod_local']) || !is_numeric($_GET['cod_local'])) {
  header("Location: AdministrarLocales.php?mensaje=id_invalido");
  exit;
}

$id = intval($_GET['cod_local']);
$error = '';
$exito = '';

$sql = $link->prepare("SELECT * FROM locales WHERE cod_local = ?");
$sql->bind_param("i", $id);
$sql->execute();
$local = $sql->get_result()->fetch_assoc();
$sql->close();

if (!$local) {
  header("Location: AdministrarLocales.php?mensaje=no_encontrado");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombreLocal = $_POST['nombre_local'] ?? '';
  $rubroLocal = $_POST['rubro_local'] ?? '';
  $ubicacionLocal = $_POST['ubicacion_local'] ?? '';
  $rutaMultimedia = $local['foto_local'];

  if (isset($_FILES['archivoMultimedia']) && $_FILES['archivoMultimedia']['error'] === UPLOAD_ERR_OK) {
    if (!empty($_FILES['archivoMultimedia']['name'])) {
      $ext = strtolower(pathinfo($_FILES['archivoMultimedia']['name'], PATHINFO_EXTENSION));
      $permitidos = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'pdf'];

      if (in_array($ext, $permitidos)) {
        $nuevoNombre = "local_" . uniqid() . "." . $ext;
        $destino = "../uploads/" . $nuevoNombre;
        if (move_uploaded_file($_FILES['archivoMultimedia']['tmp_name'], $destino)) {
          $rutaMultimedia = "uploads/" . $nuevoNombre;
        } else {
          $error = "Error al mover el archivo.";
        }
      } else {
        $error = "Formato de archivo no permitido.";
      }
    }
  }

  if (empty($error)) {
    $sql = "UPDATE locales SET nombre_local = ?, rubro_local = ?, ubicacion_local = ?, foto_local = ? WHERE cod_local = ?";
    if ($sql = $link->prepare($sql)) {
      $sql->bind_param("ssssi", $nombreLocal, $rubroLocal, $ubicacionLocal, $rutaMultimedia, $id);
      if ($sql->execute()) {
        $exito = "El local se actualizó satisfactoriamente.";
      } else {
        $error = "Error al actualizar: " . $sql->error;
      }
      $sql->close();
    } else {
      $error = "Error en la preparación de la consulta: " . $link->error;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <?php include("../Includes/head.php"); ?>
  <title>Editar Local</title>
</head>

<body>
  <header>
    <?php include("../Includes/header.php"); ?>
  </header>

  <main>
    <div class="form-register">
      <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>
      <?php if ($exito): ?>
        <div class="alert alert-success" id="mensaje-exito"><?= htmlspecialchars($exito) ?></div>
        <script>
          setTimeout(() => {
            window.location.href = "AdministrarLocales.php";
          }, 1000);
        </script>
      <?php endif; ?>

      <form method="post" action="?cod_local=<?= $id ?>" enctype="multipart/form-data">
        <p>Nombre</p>
        <textarea class="controls" name="nombre_local" required><?= htmlspecialchars($local['nombre_local']) ?></textarea>
        <p>Ubicación</p>
        <select class="form-control controls" name="ubicacion_local" required>
          <option value="Ala A" <?= $local['rubro_local'] === 'Ala A' ? 'selected' : '' ?>>Ala A</option>
          <option value="Ala B" <?= $local['rubro_local'] === 'Ala B' ? 'selected' : '' ?>>Ala B</option>
          <option value="Ala C" <?= $local['rubro_local'] === 'Ala C' ? 'selected' : '' ?>>Ala C</option>
          <option value="Ala D" <?= $local['rubro_local'] === 'Ala D' ? 'selected' : '' ?>>Ala D</option>
          <option value="Ala E" <?= $local['rubro_local'] === 'Ala E' ? 'selected' : '' ?>>Ala E</option>
        </select>
        <p>Rubro del local</p>
        <select class="form-control controls" name="rubro_local" required>
          <option value="Accesorios" <?= $local['rubro_local'] === 'Accesorios' ? 'selected' : '' ?>>Accesorios</option>
          <option value="Deportes" <?= $local['rubro_local'] === 'Deportes' ? 'selected' : '' ?>>Deportes</option>
          <option value="Electro" <?= $local['rubro_local'] === 'Electro' ? 'selected' : '' ?>>Electro</option>
          <option value="Estetica" <?= $local['rubro_local'] === 'Estetica' ? 'selected' : '' ?>>Estetica</option>
          <option value="Gastronomia" <?= $local['rubro_local'] === 'Gastronomia' ? 'selected' : '' ?>>Gastronomia</option>
          <option value="Calzado" <?= $local['rubro_local'] === 'Calzado' ? 'selected' : '' ?>>Calzado</option>
          <option value="Indumentaria" <?= $local['rubro_local'] === 'Indumentaria' ? 'selected' : '' ?>>Indumentaria</option>
          <option value="Varios" <?= $local['rubro_local'] === 'Varios' ? 'selected' : '' ?>>Varios</option>
        </select>
        <p>Archivo Multimedia</p>
        <div class="mb-3">
          <input class="form-control controls" type="file" name="archivoMultimedia" />

          <?php if (!empty($local['foto_local'])): ?>
            <p>Archivo actual:</p>
            <img src="../<?= htmlspecialchars($local['foto_local']) ?>" alt="Foto Local" style="max-width: 200px; display: block; margin-bottom: 10px;">
          <?php else: ?>
            <p>No hay archivo cargado actualmente.</p>
          <?php endif; ?>
        </div>
        <div class="text-center mt-3">
          <button class="btn btn-success boton-enviar" type="submit">Guardar Cambios</button>
          <a href="AdministrarLocales.php" class="btn btn-secondary">Volver</a>
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