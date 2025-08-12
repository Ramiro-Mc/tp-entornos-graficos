<?php
require "../conexion.inc";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: AdministrarLocales.php?mensaje=id_invalido");
    exit;
}

$id = intval($_GET['id']);
$error = '';

// Procesar formulario si es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreLocal = trim($_POST['NombreLocal'] ?? '');
    $rubroLocal = trim($_POST['RubroLocal'] ?? '');
    $ubicacionLocal = trim($_POST['UbicacionLocal'] ?? '');

    // Validaciones simples
    if (empty($nombreLocal)) {
        $error = "El nombre del local no puede estar vacío.";
    } elseif (empty($rubroLocal)) {
        $error = "El rubro del local no puede estar vacío.";
    } elseif (empty($ubicacionLocal)) {
        $error = "La ubicación del local no puede estar vacía.";
    }

    if (!$error) {
        $stmt = $link->prepare("UPDATE local SET NombreLocal = ?, RubroLocal = ?, UbicacionLocal = ? WHERE Id = ?");
        $stmt->bind_param("sssi", $nombreLocal, $rubroLocal, $ubicacionLocal, $id);

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
$stmt = $link->prepare("SELECT NombreLocal, RubroLocal, UbicacionLocal FROM local WHERE Id = ?");
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
    <meta charset="UTF-8" />
    <title>Editar Local</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-4">
    <h1>Editar Local</h1>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="mb-3">
            <label for="NombreLocal" class="form-label">Nombre del Local</label>
            <input type="text" class="form-control" id="NombreLocal" name="NombreLocal" 
                   value="<?php echo htmlspecialchars($local['NombreLocal']); ?>" required />
        </div>

        <p>Ubicación</p>
        <div class="position-relative mb-3">
          <select class="form-control controls" name="UbicacionLocal" required>
            <option value="Ala A" <?php if(isset($local['UbicacionLocal']) && $local['UbicacionLocal'] == 'Ala A') echo 'selected'; ?>>Ala A</option>
            <option value="Ala B" <?php if(isset($local['UbicacionLocal']) && $local['UbicacionLocal'] == 'Ala B') echo 'selected'; ?>>Ala B</option>
            <option value="Ala C" <?php if(isset($local['UbicacionLocal']) && $local['UbicacionLocal'] == 'Ala C') echo 'selected'; ?>>Ala C</option>
            <option value="Ala D" <?php if(isset($local['UbicacionLocal']) && $local['UbicacionLocal'] == 'Ala D') echo 'selected'; ?>>Ala D</option>
            <option value="Ala E" <?php if(isset($local['UbicacionLocal']) && $local['UbicacionLocal'] == 'Ala E') echo 'selected'; ?>>Ala E</option>
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
          <select class="form-control controls" name="RubroLocal" required>
            <option value="Accesorios" <?php if(isset($local['RubroLocal']) && $local['RubroLocal'] == 'Accesorios') echo 'selected'; ?>>Accesorios</option>
            <option value="Deportes" <?php if(isset($local['RubroLocal']) && $local['RubroLocal'] == 'Deportes') echo 'selected'; ?>>Deportes</option>
            <option value="Electro" <?php if(isset($local['RubroLocal']) && $local['RubroLocal'] == 'Electro') echo 'selected'; ?>>Electro</option>
            <option value="Estetica" <?php if(isset($local['RubroLocal']) && $local['RubroLocal'] == 'Estetica') echo 'selected'; ?>>Estetica</option>
            <option value="Gastronomia" <?php if(isset($local['RubroLocal']) && $local['RubroLocal'] == 'Gastronomia') echo 'selected'; ?>>Gastronomia</option>
            <option value="Calzado" <?php if(isset($local['RubroLocal']) && $local['RubroLocal'] == 'Calzado') echo 'selected'; ?>>Calzado</option>
            <option value="Indumentaria" <?php if(isset($local['RubroLocal']) && $local['RubroLocal'] == 'Indumentaria') echo 'selected'; ?>>Indumentaria</option>
            <option value="Varios" <?php if(isset($local['RubroLocal']) && $local['RubroLocal'] == 'Varios') echo 'selected'; ?>>Varios</option>
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

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="AdministrarLocales.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
