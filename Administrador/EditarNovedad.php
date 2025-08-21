<?php
require "../conexion.inc";

// Validar ID recibido
if (!isset($_GET['cod_novedad']) || !is_numeric($_GET['cod_novedad'])) {
    header("Location: AdministrarNovedades.php?mensaje=id_invalido");
    exit;
}

$id = intval($_GET['cod_novedad']);
$error = '';

// Procesar formulario si es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $texto = trim($_POST['textoNovedad'] ?? '');
    $desde = $_POST['fecha_desde_novedad'] ?? '';
    $hasta = $_POST['fecha_hasta_novedad'] ?? '';
    $tipoUsuario = $_POST['tipo_usuario'] ?? '';

    // Validaciones simples
    if (empty($texto)) {
        $error = "El texto de la novedad no puede estar vacío.";
    } elseif (empty($desde)) {
        $error = "Debe indicar la fecha de inicio.";
    } elseif (empty($hasta)) {
        $error = "Debe indicar la fecha de fin.";
    } elseif (empty($tipoUsuario)) {
        $error = "Debe seleccionar un tipo de usuario.";
    }

    if (!$error) {
        $stmt = $link->prepare("UPDATE novedades SET textoNovedad = ?, fecha_desde_novedad = ?, fecha_hasta_novedad = ?, tipo_usuario = ? WHERE cod_novedad = ?");
        $stmt->bind_param("ssssi", $texto, $desde, $hasta, $tipoUsuario, $id);

        if ($stmt->execute()) {
            $stmt->close();
            $link->close();
            header("Location: AdministrarNovedades.php?mensaje=editado");
            exit;
        } else {
            $error = "Error al actualizar: " . $link->error;
        }
    }
}

// Cargar datos actuales
$stmt = $link->prepare("SELECT textoNovedad, fecha_desde_novedad, fecha_hasta_novedad, tipo_usuario FROM novedades WHERE cod_novedad = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    $link->close();
    header("Location: AdministrarNovedades.php?mensaje=no_encontrado");
    exit;
}

$novedad = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Editar Novedad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../Styles/style.css" />
    <link rel="stylesheet" href="../Styles/style-general.css" />
</head>
<body>
<div class="container mt-4">
    <h1>Editar Novedad</h1>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="mb-3">
            <label for="textoNovedad" class="form-label">Texto de la Novedad</label>
            <textarea class="form-control" id="textoNovedad" name="textoNovedad" rows="3" required><?= htmlspecialchars($novedad['textoNovedad']); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="fecha_desde_novedad" class="form-label">Fecha de Inicio</label>
            <input type="date" class="form-control" id="fecha_desde_novedad" name="fecha_desde_novedad" value="<?= $novedad['fecha_desde_novedad']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="fecha_hasta_novedad" class="form-label">Fecha de Fin</label>
            <input type="date" class="form-control" id="fecha_hasta_novedad" name="fecha_hasta_novedad" value="<?= $novedad['fecha_hasta_novedad']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="tipo_usuario" class="form-label">Tipo de Usuario</label>
            <select class="form-control controls" id="tipo_usuario" name="tipo_usuario" required>
                <option value="dueño" <?= $novedad['tipo_usuario'] == 'dueño' ? 'selected' : ''; ?>>Dueño</option>
                <option value="cliente" <?= $novedad['tipo_usuario'] == 'cliente' ? 'selected' : ''; ?>>Cliente</option>
                <option value="administrador" <?= $novedad['tipo_usuario'] == 'administrador' ? 'selected' : ''; ?>>Administrador</option>
            </select>
            <i class="bi bi-chevron-down position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%); pointer-events: none; color: white;"></i>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="AdministrarNovedades.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
