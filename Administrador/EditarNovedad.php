<?php

$folder = "Administrador";
$pestaña = "Editar Novedad";
include_once("../Includes/funciones.php");
require "../conexion.inc";
sesionIniciada();

if (!isset($_GET['cod_novedad']) || !is_numeric($_GET['cod_novedad'])) {
    header("Location: AdministrarNovedades.php?mensaje=id_invalido");
    exit;
}

$id = intval($_GET['cod_novedad']);
$error = '';
$exito = '';

$sql = $link->prepare("SELECT * FROM novedades WHERE cod_novedad = ?");
$sql->bind_param("i", $id);
$sql->execute();
$novedad = $sql->get_result()->fetch_assoc();
$sql->close();

if (!$novedad) {
    header("Location: AdministrarNovedades.php?mensaje=no_encontrado");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $texto = trim($_POST['texto_novedad'] ?? '');
    $desde = $_POST['fecha_desde_novedad'] ?? '';
    $hasta = $_POST['fecha_hasta_novedad'] ?? '';
    $catCliente = $_POST['categoria_cliente'] ?? '';
    $rutaMultimedia = $novedad['foto_novedad'];

    if (isset($_FILES['archivoMultimedia']) && $_FILES['archivoMultimedia']['error'] === UPLOAD_ERR_OK) {
        if (!empty($_FILES['archivoMultimedia']['name'])) {
            $ext = strtolower(pathinfo($_FILES['archivoMultimedia']['name'], PATHINFO_EXTENSION));
            $permitidos = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'pdf'];

            if (in_array($ext, $permitidos)) {
                $nuevoNombre = "novedad_" . uniqid() . "." . $ext;
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
    if ($hasta < $desde) $error = "La fecha de fin no puede ser menor que la de inicio.";
    if (empty($error)) {
        $sql = "UPDATE novedades SET texto_novedad = ?, fecha_desde_novedad = ?, fecha_hasta_novedad = ?, categoria_cliente = ?, foto_novedad = ? WHERE cod_novedad = ?";
        if ($sql = $link->prepare($sql)) {
            $sql->bind_param("sssssi", $texto, $desde, $hasta, $catCliente, $rutaMultimedia, $id);
            if ($sql->execute()) {
                $exito = "La novedad se actualizó satisfactoriamente.";
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
    <title>Editar Novedad</title>
</head>

<body>
    <header>
        <?php include("../Includes/header.php"); ?>
    </header>

    <main>
        <div class="form-register">
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
            <form method="post" action="?cod_novedad=<?= $id ?>" enctype="multipart/form-data">
                <p>Descripción</p>
                <textarea class="controls" name="texto_novedad" rows="3" maxlength="200" required><?= htmlspecialchars($novedad['texto_novedad']) ?></textarea>
                <p>Vigencia de la promoción</p>
                <label for="fechaini">Fecha de inicio</label>
                <input class="controls" type="date" id="fechaini" name="fecha_desde_novedad" value="<?= htmlspecialchars($novedad['fecha_desde_novedad']) ?>" required />
                <label for="fechafin">Fecha de fin</label>
                <input class="controls" type="date" id="fechafin" name="fecha_hasta_novedad" value="<?= htmlspecialchars($novedad['fecha_hasta_novedad']) ?>" required />
                <p>Categoria Cliente</p>
                <select class="form-control controls" name="categoria_cliente" required>
                    <option value="inicial" <?= $novedad['categoria_cliente'] === 'inicial' ? 'selected' : '' ?>>Inicial</option>
                    <option value="medium" <?= $novedad['categoria_cliente'] === 'medium' ? 'selected' : '' ?>>Medium</option>
                    <option value="premium" <?= $novedad['categoria_cliente'] === 'premium' ? 'selected' : '' ?>>Premium</option>
                </select>
                <p>Archivo Multimedia</p>
                <div class="mb-3">
                    <input class="form-control controls" type="file" name="archivoMultimedia" />

                    <?php if (!empty($novedad['foto_novedad'])): ?>
                        <p>Archivo actual:</p>
                        <img src="../<?= htmlspecialchars($novedad['foto_novedad']) ?>" alt="Foto Novedad" style="max-width: 200px; display: block; margin-bottom: 10px;">
                    <?php else: ?>
                        <p>No hay archivo cargado actualmente.</p>
                    <?php endif; ?>
                </div>
                <div class="text-center mt-3">
                    <button class="btn btn-success boton-enviar" type="submit">Guardar Cambios</button>
                    <a href="AdministrarNovedades.php" class="btn btn-secondary">Volver</a>
                </div>
            </form>
        </div>
    </main>

    <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4">
        <?php include("../Includes/footer.php") ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>