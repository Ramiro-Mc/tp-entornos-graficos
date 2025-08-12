<?php
require "../conexion.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // ID inválido, redirigir o mostrar error
    header("Location: AdministrarLocales.php?mensaje=id_invalido");
    exit;
}

$id = intval($_GET['id']);

// Si se envió el formulario (POST), procesar actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y sanitizar datos recibidos
    $nombreLocal = trim($_POST['NombreLocal'] ?? '');

    if (empty($nombreLocal)) {
        $error = "El nombre del local no puede estar vacío.";
    } else {
        // Preparar update
        $stmt = $link->prepare("UPDATE local SET NombreLocal = ? WHERE Id = ?");
        $stmt->bind_param("si", $nombreLocal, $id);

        if ($stmt->execute()) {
            $stmt->close();
            $link->close();
            // Redirigir con mensaje de éxito
            header("Location: AdministrarLocales.php?mensaje=editado");
            exit;
        } else {
            $error = "Error al actualizar: " . $link->error;
        }
    }
}

// Si no es POST, o si hubo error, buscamos datos actuales para mostrar en el formulario
$stmt = $link->prepare("SELECT NombreLocal FROM local WHERE Id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // No existe el local con ese id
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

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="mb-3">
            <label for="NombreLocal" class="form-label">Nombre del Local</label>
            <input type="text" class="form-control" id="NombreLocal" name="NombreLocal" 
                   value="<?php echo htmlspecialchars($local['NombreLocal']); ?>" required />
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="AdministrarLocales.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
