<?php

$folder = "Administrador";
$pestaña = "Editar Novedad";
include_once("../Includes/funciones.php");
require "../conexion.inc";
sesionIniciada();

// Validar ID recibido
if (!isset($_GET['cod_novedad']) || !is_numeric($_GET['cod_novedad'])) {
    header("Location: AdministrarNovedades.php?mensaje=id_invalido");
    exit;
}

$id = intval($_GET['cod_novedad']);
$error = '';
$exito = '';

// Cargar datos actuales
$stmt = $link->prepare("SELECT texto_novedad, fecha_desde_novedad, fecha_hasta_novedad, categoria_cliente FROM novedades WHERE cod_novedad = ?");
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

// Procesar formulario si es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $texto = trim($_POST['texto_novedad'] ?? '');
    $desde = $_POST['fecha_desde_novedad'] ?? '';
    $hasta = $_POST['fecha_hasta_novedad'] ?? '';
    $catCliente = $_POST['categoria_cliente'] ?? '';

    // Validaciones
    if (empty($texto)) {
        $error = "El texto de la novedad no puede estar vacío.";
    } elseif (empty($desde)) {
        $error = "Debe indicar la fecha de inicio.";
    } elseif (empty($hasta)) {
        $error = "Debe indicar la fecha de fin.";
    } elseif (strtotime($desde) > strtotime($hasta)) {
        $error = "La fecha de inicio no puede ser posterior a la fecha de fin.";
    } elseif (empty($catCliente)) {
        $error = "Debe seleccionar un tipo de usuario.";
    }

    // Si no hay errores, actualizamos
    if (!$error) {
        $stmt = $link->prepare("UPDATE novedades SET texto_novedad = ?, fecha_desde_novedad = ?, fecha_hasta_novedad = ?, categoria_cliente = ? WHERE cod_novedad = ?");
        $stmt->bind_param("ssssi", $texto, $desde, $hasta, $catCliente, $id);

        if ($stmt->execute()) {
            $stmt->close();
            // $link->close();  // opcional mantener abierto si quieres mostrar el mensaje
            $exito = "La novedad se guardó satisfactoriamente.";
        } else {
            $error = "Error al actualizar: " . $link->error;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include("../Includes/head.php"); ?>
    <title>Editar Novedad</title>
</head>
<body>
<header>
    <?php include("../Includes/header.php"); ?>
</header>

<main>
    <div class="container mt-4">
        <h1>Editar Novedad</h1>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if ($exito): ?>
            <div class="alert alert-success" id="mensaje-exito"><?= htmlspecialchars($exito) ?></div>
            <script>
                setTimeout(() => {
                    window.location.href = "AdministrarNovedades.php";
                }, 1000);
            </script>
        <?php endif; ?>

        <form method="post" action="">
            <div class="mb-3">
                <label for="texto_novedad" class="form-label">Texto de la Novedad</label>
                <textarea class="form-control" id="texto_novedad" name="texto_novedad" rows="3" required><?= htmlspecialchars($_POST['texto_novedad'] ?? $novedad['texto_novedad']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="fecha_desde_novedad" class="form-label">Fecha de Inicio</label>
                <input type="date" class="form-control" id="fecha_desde_novedad" name="fecha_desde_novedad" value="<?= $_POST['fecha_desde_novedad'] ?? $novedad['fecha_desde_novedad']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="fecha_hasta_novedad" class="form-label">Fecha de Fin</label>
                <input type="date" class="form-control" id="fecha_hasta_novedad" name="fecha_hasta_novedad" value="<?= $_POST['fecha_hasta_novedad'] ?? $novedad['fecha_hasta_novedad']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="categoria_cliente" class="form-label">Tipo de Usuario</label>
                <select class="form-control text-black bg-white" id="categoria_cliente" name="categoria_cliente" required>
                    <option value="dueño" <?= (($_POST['categoria_cliente'] ?? $novedad['categoria_cliente']) == 'dueño') ? 'selected' : ''; ?>>Dueño</option>
                    <option value="cliente" <?= (($_POST['categoria_cliente'] ?? $novedad['categoria_cliente']) == 'cliente') ? 'selected' : ''; ?>>Cliente</option>
                    <option value="administrador" <?= (($_POST['categoria_cliente'] ?? $novedad['categoria_cliente']) == 'administrador') ? 'selected' : ''; ?>>Administrador</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary mb-5">Guardar Cambios</button>
            <a href="AdministrarNovedades.php" class="btn btn-secondary mb-5">Cancelar</a>
        </form>
    </div>
</main>

<footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4">
    <?php include("../Includes/footer.php") ?>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
