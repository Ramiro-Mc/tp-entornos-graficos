<?php

$folder = "Administrador";
$pestaña = "Editar Local";

require "../conexion.inc";

if (!isset($_GET['cod_local']) || !is_numeric($_GET['cod_local'])) {
  header("Location: AdministrarLocales.php?mensaje=id_invalido");
  exit;
}

$id = intval($_GET['cod_local']);
$error = '';

// Procesar formulario si es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombreLocal = trim($_POST['nombre_local'] ?? '');
  $rubroLocal = trim($_POST['rubro_local'] ?? '');
  $ubicacion_local = trim($_POST['ubicacion_local'] ?? '');

  // Validaciones simples
  if (empty($nombreLocal)) {
    $error = "El nombre del local no puede estar vacío.";
  } elseif (empty($rubroLocal)) {
    $error = "El rubro del local no puede estar vacío.";
  } elseif (empty($ubicacion_local)) {
    $error = "La ubicación del local no puede estar vacía.";
  }

  if (!$error) {
    $stmt = $link->prepare("UPDATE locales SET nombre_local = ?, rubro_local = ?, ubicacion_local = ? WHERE cod_local = ?");
    $stmt->bind_param("sssi", $nombreLocal, $rubroLocal, $ubicacion_local, $id);

    if ($stmt->execute()) {
      $stmt->close();
      $link->close();
      header("Location: AdministrarLocales.php?mensaje=editado");
      exit;
    } else {
      $error = "Error al actualizar: " . $link->error;
    }
  }
}

// Si no es POST o hay error, cargamos datos actuales
$stmt = $link->prepare("SELECT nombre_local, rubro_local, ubicacion_local FROM locales WHERE cod_local = ?");
$stmt->bind_param("i", $id);
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

    <title>Editar Local</title>

  </head>
  <body>

    <header>

      <?php include("../Includes/header.php"); ?>

    </header>

    <main>

      <div class="container mt-4">
        <h1>Editar Local</h1>

        <?php if ($error): ?>
          <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="post" action="">
          <div class="mb-3">
            <label for="nombre_local" class="form-label">Nombre del Local</label>
            <input type="text" class="form-control" id="nombre_local" name="nombre_local" 
              value="<?php echo htmlspecialchars($local['nombre_local']); ?>" required />
          </div>

          <p>Ubicación</p>
          <div class="position-relative mb-3">
            <select class="form-control controls" name="ubicacion_local" required>
              <option value="Ala A" <?php if(isset($local['ubicacion_local']) && $local['ubicacion_local'] == 'Ala A') echo 'selected'; ?>>Ala A</option>
              <option value="Ala B" <?php if(isset($local['ubicacion_local']) && $local['ubicacion_local'] == 'Ala B') echo 'selected'; ?>>Ala B</option>
              <option value="Ala C" <?php if(isset($local['ubicacion_local']) && $local['ubicacion_local'] == 'Ala C') echo 'selected'; ?>>Ala C</option>
              <option value="Ala D" <?php if(isset($local['ubicacion_local']) && $local['ubicacion_local'] == 'Ala D') echo 'selected'; ?>>Ala D</option>
              <option value="Ala E" <?php if(isset($local['ubicacion_local']) && $local['ubicacion_local'] == 'Ala E') echo 'selected'; ?>>Ala E</option>
            </select>
            <i
              class="bi bi-chevron-down position-absolute"
              style="
                right: 10px;
                top: 50%;
                transform: translateY(-50%);
                pointer-events: none;
                color: white;
              "
            ></i>
          </div>

          <p>Rubro del local</p>
          <div class="position-relative mb-3">
            <select class="form-control controls" name="rubro_local" required>
              <option value="Accesorios" <?php if(isset($local['rubro_local']) && $local['rubro_local'] == 'Accesorios') echo 'selected'; ?>>Accesorios</option>
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
