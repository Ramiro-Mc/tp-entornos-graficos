<?php
$folder = "Administrador";
$pestaña = "Editar";
include_once("../Includes/funciones.php");
require "../conexion.inc";
sesionIniciada();

$tipo = $_GET['tipo'] ?? '';
$id   = isset($_GET['cod']) && is_numeric($_GET['cod']) ? intval($_GET['cod']) : 0;

if (!$tipo || !$id) {
    header("Location: index.php?mensaje=id_invalido");
    exit;
}

$error = '';
$exito = '';
$registro = null;
$volver = "";

switch ($tipo) {
    case 'local':
        $volver = "AdministrarLocales.php";
        $stmt = $link->prepare("SELECT * FROM locales WHERE cod_local = ?");
        $stmt->bind_param("i", $id);
        break;
    case 'novedad':
        $volver = "AdministrarNovedades.php";
        $stmt = $link->prepare("SELECT * FROM novedades WHERE cod_novedad = ?");
        $stmt->bind_param("i", $id);
        break;
    default:
        header("Location: index.php?mensaje=tipo_invalido");
        exit;
}

$stmt->execute();
$registro = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$registro) {
    header("Location: $volver?mensaje=no_encontrado");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($tipo === 'local') {
        $nombre = $_POST['nombre_local'] ?? '';
        $rubro  = $_POST['rubro_local'] ?? '';
        $ubicacion = $_POST['ubicacion_local'] ?? '';
        $rutaMultimedia = $registro['foto_local'];

        $subida = subirArchivo($_FILES['archivoMultimedia'] ?? null, 'local');
        if (is_string($subida) && strpos($subida, 'Error') === 0) {
            $error = $subida;
        } elseif ($subida) {
            $rutaMultimedia = $subida;
        }

        if (!$error) {
            $sql = "UPDATE locales SET nombre_local = ?, rubro_local = ?, ubicacion_local = ?, foto_local = ? WHERE cod_local = ?";
            $stmt = $link->prepare($sql);
            $stmt->bind_param("ssssi", $nombre, $rubro, $ubicacion, $rutaMultimedia, $id);
            if ($stmt->execute()) $exito = "El local se actualizó satisfactoriamente.";
            else $error = "Error al actualizar: " . $stmt->error;
            $stmt->close();
        }
    } elseif ($tipo === 'novedad') {
        $texto = $_POST['texto_novedad'] ?? '';
        $desde = $_POST['fecha_desde_novedad'] ?? '';
        $hasta = $_POST['fecha_hasta_novedad'] ?? '';
        $catCliente = $_POST['categoria_cliente'] ?? '';
        $rutaMultimedia = $registro['foto_novedad'];

        $subida = subirArchivo($_FILES['archivoMultimedia'] ?? null, 'novedad');
        if (is_string($subida) && strpos($subida, 'Error') === 0) {
            $error = $subida;
        } elseif ($subida) {
            $rutaMultimedia = $subida;
        }

        if ($hasta < $desde) $error = "La fecha de fin no puede ser menor que la de inicio.";

        if (!$error) {
            $sql = "UPDATE novedades SET texto_novedad = ?, fecha_desde_novedad = ?, fecha_hasta_novedad = ?, categoria_cliente = ?, foto_novedad = ? WHERE cod_novedad = ?";
            $stmt = $link->prepare($sql);
            $stmt->bind_param("sssssi", $texto, $desde, $hasta, $catCliente, $rutaMultimedia, $id);
            if ($stmt->execute()) $exito = "La novedad se actualizó satisfactoriamente.";
            else $error = "Error al actualizar: " . $stmt->error;
            $stmt->close();
        }
    }
}

$link->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include("../Includes/head.php"); ?>
    <title>Editar <?= e(ucfirst($tipo)) ?></title>
</head>

<body>
    <header>
        <?php include("../Includes/header.php"); ?>
    </header>
    <main>
        <div class="form-register">
            <h1>Editar <?= e(ucfirst($tipo)) ?></h1>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= e($error) ?></div>
            <?php endif; ?>
            <?php if ($exito): ?>
                <div class="alert alert-success" id="mensaje-exito"><?= e($exito) ?></div>
                <script>
                    setTimeout(() => {
                        window.location.href = "<?= $volver ?>";
                    }, 1000);
                </script>
            <?php endif; ?>

            <form method="post" enctype="multipart/form-data">
                <?php if ($tipo === 'local'): ?>
                    <p>Nombre</p>
                    <textarea class="controls" name="nombre_local" required><?= e($registro['nombre_local']) ?></textarea>

                    <p>Ubicación</p>
                    <select class="form-control controls" name="ubicacion_local" required>
                        <?php
                        $opciones = ['Ala A', 'Ala B', 'Ala C', 'Ala D', 'Ala E'];
                        foreach ($opciones as $op) {
                            $sel = $registro['ubicacion_local'] === $op ? 'selected' : '';
                            echo "<option value='$op' $sel>$op</option>";
                        }
                        ?>
                    </select>

                    <p>Rubro del local</p>
                    <select class="form-control controls" name="rubro_local" required>
                        <?php
                        $rubros = ['Accesorios', 'Deportes', 'Electro', 'Estetica', 'Gastronomia', 'Calzado', 'Indumentaria', 'Varios'];
                        foreach ($rubros as $r) {
                            $sel = $registro['rubro_local'] === $r ? 'selected' : '';
                            echo "<option value='$r' $sel>$r</option>";
                        }
                        ?>
                    </select>

                    <p>Archivo Multimedia</p>
                    <input type="file" name="archivoMultimedia" class="form-control controls">
                    <?php if (!empty($registro['foto_local'])): ?>
                        <p>Archivo actual:</p>
                        <img src="../<?= e($registro['foto_local']) ?>" style="max-width:200px;">
                    <?php endif; ?>

                <?php elseif ($tipo === 'novedad'): ?>
                    <p>Descripción</p>
                    <textarea class="controls" name="texto_novedad" rows="3" maxlength="200" required><?= e($registro['texto_novedad']) ?></textarea>

                    <p>Vigencia de la novedad</p>
                    <label>Fecha de inicio</label>
                    <input class="controls" type="date" name="fecha_desde_novedad" value="<?= e($registro['fecha_desde_novedad']) ?>" required>
                    <label>Fecha de fin</label>
                    <input class="controls" type="date" name="fecha_hasta_novedad" value="<?= e($registro['fecha_hasta_novedad']) ?>" required>

                    <p>Categoria Cliente</p>
                    <select class="form-control controls" name="categoria_cliente" required>
                        <?php
                        $cats = ['inicial', 'medium', 'premium'];
                        foreach ($cats as $c) {
                            $sel = $registro['categoria_cliente'] === $c ? 'selected' : '';
                            echo "<option value='$c' $sel>$c</option>";
                        }
                        ?>
                    </select>

                    <p>Archivo Multimedia</p>
                    <input type="file" name="archivoMultimedia" class="form-control controls">
                    <?php if (!empty($registro['foto_novedad'])): ?>
                        <p>Archivo actual:</p>
                        <img src="../<?= e($registro['foto_novedad']) ?>" style="max-width:200px;">
                    <?php endif; ?>

                <?php endif; ?>

                <div class="text-center mt-3">
                    <button class="btn btn-success" type="submit">Guardar Cambios</button>
                    <a href="<?= $volver ?>" class="btn btn-secondary">Volver</a>
                </div>
            </form>
        </div>
    </main>
    <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4">
        <?php include("../Includes/footer.php") ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>