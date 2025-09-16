<?php
$folder = "Administrador";
$pestaña = "Detalle";
include_once("../Includes/funciones.php");
require "../conexion.inc";
sesionIniciada();

$tipo = $_GET['tipo'] ?? '';
$cod  = getIntParam('cod', 'Administrar' . ucfirst($tipo) . 's.php');
$data = null;
$titulo = "";

switch ($tipo) {
    case 'local':
        $titulo = "Detalle del Local";
        $data = fetchOne(
            $link,
            "SELECT nombre_local, rubro_local, ubicacion_local, cod_usuario, foto_local
             FROM locales WHERE cod_local = ?",
            "i",
            $cod
        );
        $volver = "AdministrarLocales.php";
        break;

    case 'novedad':
        $titulo = "Detalle de la Novedad";
        $data = fetchOne(
            $link,
            "SELECT texto_novedad, fecha_desde_novedad, fecha_hasta_novedad, categoria_cliente, foto_novedad 
             FROM novedades WHERE cod_novedad = ?",
            "i",
            $cod
        );
        $volver = "AdministrarNovedades.php";
        break;

    case 'promocion':
        $titulo = "Detalle de la Promoción";
        $data = fetchOne(
            $link,
            "SELECT p.cod_promocion, p.texto_promocion, p.estado_promo, 
                    p.fecha_desde_promocion, p.fecha_hasta_promocion, 
                    p.foto_promocion, l.nombre_local, l.rubro_local, l.ubicacion_local
             FROM promociones p 
             INNER JOIN locales l ON p.cod_local = l.cod_local 
             WHERE p.cod_promocion = ?",
            "i",
            $cod
        );
        $volver = "AdministrarPromociones.php";
        break;

    default:
        header("Location: index.php?mensaje=tipo_invalido");
        exit;
}

if (!$data) {
    header("Location: $volver?mensaje=no_encontrado");
    exit;
}

$link->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include("../Includes/head.php"); ?>
    <title><?= e($titulo) ?></title>
</head>

<body>
    <header>
        <?php include("../Includes/header.php"); ?>
    </header>

    <main>
        <div class="container mt-4">
            <h1><?= e($titulo) ?></h1>

            <div class="card">
                <div class="card-body">
                    <?php if ($tipo === 'local'): ?>
                        <h3 class="card-title"><?= e($data['nombre_local']) ?></h3>
                        <p><strong>Rubro:</strong> <?= e($data['rubro_local']) ?></p>
                        <p><strong>Ubicación:</strong> <?= e($data['ubicacion_local']) ?></p>
                        <p><strong>Código Dueño:</strong> <?= e($data['cod_usuario']) ?></p>
                        <?php if (!empty($data['foto_local'])): ?>
                            <p><strong>Multimedia:</strong></p>
                            <img src="<?= e($data['foto_local']) ?>" alt="Imagen del local <?= e($data['nombre_local']) ?>" style="max-width: 300px; height: auto;">
                        <?php else: ?>
                            <p><strong>Multimedia:</strong> No hay imagen disponible</p>
                        <?php endif; ?>

                    <?php elseif ($tipo === 'novedad'): ?>
                        <h3 class="card-title"><?= e($data['texto_novedad']) ?></h3>
                        <p><strong>Fecha Desde:</strong> <?= e($data['fecha_desde_novedad']) ?></p>
                        <p><strong>Fecha Hasta:</strong> <?= e($data['fecha_hasta_novedad']) ?></p>
                        <p><strong>Categoría:</strong> <?= e($data['categoria_cliente']) ?></p>
                        <?php if (!empty($data['foto_novedad'])): ?>
                            <p><strong>Multimedia:</strong></p>
                            <img src="../<?= e($data['foto_novedad']) ?>" alt="Foto Novedad" class="img-fluid mb-2" style="max-width:200px;">
                        <?php else: ?>
                            <p><strong>Multimedia:</strong> No hay imagen disponible</p>
                        <?php endif; ?>

                    <?php elseif ($tipo === 'promocion'): ?>
                        <h3 class="card-title"><?= e($data['texto_promocion']) ?></h3>
                        <p><strong>#</strong> <?= e($data['cod_promocion']) ?></p>
                        <p><strong>Estado:</strong> <?= e($data['estado_promo']) ?></p>
                        <p><strong>Fecha Desde:</strong> <?= e($data['fecha_desde_promocion']) ?></p>
                        <p><strong>Fecha Hasta:</strong> <?= e($data['fecha_hasta_promocion']) ?></p>
                        <?php if (!empty($data['foto_promocion'])): ?>
                            <p><strong>Multimedia:</strong></p>
                            <img src="<?= e($data['foto_promocion']) ?>" alt="Imagen de la promoción <?= e($data['nombre_local']) ?>" style="max-width: 300px; height: auto;">
                        <?php else: ?>
                            <p><strong>Multimedia:</strong> No hay imagen disponible</p>
                        <?php endif; ?>
                        <p><strong>Nombre local:</strong> <?= e($data['nombre_local']) ?></p>
                        <p><strong>Rubro Local:</strong> <?= e($data['rubro_local']) ?></p>
                        <p><strong>Ubicación Local:</strong> <?= e($data['ubicacion_local']) ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <a href="<?= $volver ?>" class="btn btn-secondary my-3">Volver</a>
        </div>
    </main>

    <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4">
        <?php include("../Includes/footer.php"); ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>