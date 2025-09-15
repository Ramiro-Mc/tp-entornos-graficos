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
              <option value="Accesorios" <?= $local['rubro_local'] === 'Accesorios' ? 'selected' : ''?>>Accesorios</option>
              <option value="Deportes" <?php if(isset($local['rubro_local']) && $local['rubro_local'] == 'Deportes') echo 'selected'; ?>>Deportes</option>
              <option value="Electro" <?php if(isset($local['rubro_local']) && $local['rubro_local'] == 'Electro') echo 'selected'; ?>>Electro</option>
              <option value="Estetica" <?php if(isset($local['rubro_local']) && $local['rubro_local'] == 'Estetica') echo 'selected'; ?>>Estetica</option>
              <option value="Gastronomia" <?php if(isset($local['rubro_local']) && $local['rubro_local'] == 'Gastronomia') echo 'selected'; ?>>Gastronomia</option>
              <option value="Calzado" <?php if(isset($local['rubro_local']) && $local['rubro_local'] == 'Calzado') echo 'selected'; ?>>Calzado</option>
              <option value="Indumentaria" <?php if(isset($local['rubro_local']) && $local['rubro_local'] == 'Indumentaria') echo 'selected'; ?>>Indumentaria</option>
              <option value="Varios" <?php if(isset($local['rubro_local']) && $local['rubro_local'] == 'Varios') echo 'selected'; ?>>Varios</option>
            </select>
            <i class="bi bi-chevron-down position-absolute"
              style="
                right: 10px;
                top: 50%;
                transform: translateY(-50%);
                pointer-events: none;
                color: white;
              "
            ></i>
          </div>

          <button type="submit" class="btn btn-primary mb-5">Guardar Cambios</button>
          <a href="AdministrarLocales.php" class="btn btn-secondary mb-5">Cancelar</a>
        </form>
      </div>

    </main>

    <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4">

      <?php include("../Includes/footer.php") ?>
    
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
  
  </body>
</html>