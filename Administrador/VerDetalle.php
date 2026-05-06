<?php
$folder = "Administrador";
$pestaña = "Detalle";
include_once("../Includes/funciones.php");
require "../Includes/conexion.inc";
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
            "SELECT texto_novedad, fecha_desde_novedad, fecha_hasta_novedad, tipo_usuario, foto_novedad 
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

    <main class="FondoDueñoAdministrador d-flex align-items-center py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="m-0 fw-bold" style="color: #2c3e50;"><i class="bi bi-card-checklist me-2"></i><?= e($titulo) ?></h1>
                        <a href="<?= $volver ?>" class="btn btn-outline-dark px-4 rounded-pill fw-bold shadow-sm d-flex align-items-center">
                            <i class="bi bi-arrow-left me-2"></i> Volver a la lista
                        </a>
                    </div>

                    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                        <div class="card-body p-4 p-md-5">
                            <?php if ($tipo === 'local'): ?>
                                <div class="row">
                                    <div class="col-md-7 mb-4 mb-md-0">
                                        <h2 class="fw-bold text-dark mb-4 text-break"><?= e($data['nombre_local']) ?></h2>
                                        <p class="fs-5 mb-3"><i class="bi bi-tags text-primary me-2"></i><strong>Rubro:</strong> <?= e($data['rubro_local']) ?></p>
                                        <p class="fs-5 mb-3"><i class="bi bi-geo-alt text-danger me-2"></i><strong>Ubicación:</strong> <?= e($data['ubicacion_local']) ?></p>
                                        <p class="fs-5 mb-3"><i class="bi bi-person-badge text-secondary me-2"></i><strong>Código Dueño:</strong> <?= e($data['cod_usuario']) ?></p>
                                    </div>
                                    <div class="col-md-5 text-center d-flex flex-column justify-content-center">
                                        <?php if (!empty($data['foto_local'])): ?>
                                            <img src="../<?= e($data['foto_local']) ?>" alt="Imagen del local" class="img-fluid rounded-4 shadow" style="max-height: 250px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="bg-light rounded-4 d-flex align-items-center justify-content-center mx-auto w-100 shadow-sm" style="height: 200px;">
                                                <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                                            </div>
                                            <p class="text-muted mt-2 mb-0"><small>Sin imagen disponible</small></p>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            <?php elseif ($tipo === 'novedad'): ?>
                                <div class="row">
                                    <div class="col-md-7 mb-4 mb-md-0">
                                        <h2 class="fw-bold text-dark mb-4 text-break"><?= e($data['texto_novedad']) ?></h2>
                                        <p class="fs-5 mb-3"><i class="bi bi-calendar-event text-info me-2"></i><strong>Fecha Desde:</strong> <?= date("d/m/Y", strtotime($data['fecha_desde_novedad'])) ?></p>
                                        <p class="fs-5 mb-3"><i class="bi bi-calendar-check text-info me-2"></i><strong>Fecha Hasta:</strong> <?= date("d/m/Y", strtotime($data['fecha_hasta_novedad'])) ?></p>
                                        <p class="fs-5 mb-3"><i class="bi bi-people text-warning me-2"></i><strong>Categoría:</strong> <?= e($data['tipo_usuario']) ?></p>
                                    </div>
                                    <div class="col-md-5 text-center d-flex flex-column justify-content-center">
                                        <?php if (!empty($data['foto_novedad'])): ?>
                                            <img src="../<?= e($data['foto_novedad']) ?>" alt="Foto Novedad" class="img-fluid rounded-4 shadow" style="max-height: 250px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="bg-light rounded-4 d-flex align-items-center justify-content-center mx-auto w-100 shadow-sm" style="height: 200px;">
                                                <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                                            </div>
                                            <p class="text-muted mt-2 mb-0"><small>Sin imagen disponible</small></p>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            <?php elseif ($tipo === 'promocion'): ?>
                                <div class="row">
                                    <div class="col-md-7 mb-4 mb-md-0">
                                        <h2 class="fw-bold text-dark mb-4 text-break"><?= e($data['texto_promocion']) ?></h2>
                                        <p class="fs-5 mb-3"><i class="bi bi-hash text-secondary me-2"></i><strong>Código:</strong> <?= e($data['cod_promocion']) ?></p>
                                        <p class="fs-5 mb-3"><i class="bi bi-info-circle text-primary me-2"></i><strong>Estado:</strong> 
                                            <?php
                                                $est = strtolower($data['estado_promo']);
                                                if($est == 'aceptada' || $est == 'aprobada') echo '<span class="badge bg-success rounded-pill px-3 shadow-sm">Aceptada</span>';
                                                elseif($est == 'rechazada') echo '<span class="badge bg-danger rounded-pill px-3 shadow-sm">Rechazada</span>';
                                                else echo '<span class="badge bg-secondary rounded-pill px-3 shadow-sm">Pendiente</span>';
                                            ?>
                                        </p>
                                        <p class="fs-5 mb-3"><i class="bi bi-calendar-range text-info me-2"></i><strong>Vigencia:</strong> <?= date("d/m/Y", strtotime($data['fecha_desde_promocion'])) ?> al <?= date("d/m/Y", strtotime($data['fecha_hasta_promocion'])) ?></p>
                                        
                                        <hr class="my-4 text-muted">
                                        <h4 class="fw-bold mb-3"><i class="bi bi-shop text-dark me-2"></i>Datos del Local</h4>
                                        <p class="mb-2 fs-6"><i class="bi bi-caret-right-fill text-muted"></i> <strong>Nombre:</strong> <?= e($data['nombre_local']) ?></p>
                                        <p class="mb-2 fs-6"><i class="bi bi-caret-right-fill text-muted"></i> <strong>Rubro:</strong> <?= e($data['rubro_local']) ?></p>
                                        <p class="mb-2 fs-6"><i class="bi bi-caret-right-fill text-muted"></i> <strong>Ubicación:</strong> <?= e($data['ubicacion_local']) ?></p>
                                    </div>
                                    <div class="col-md-5 text-center d-flex flex-column justify-content-center">
                                        <?php if (!empty($data['foto_promocion'])): ?>
                                            <img src="../<?= e($data['foto_promocion']) ?>" alt="Imagen de la promoción" class="img-fluid rounded-4 shadow" style="max-height: 300px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="bg-light rounded-4 d-flex align-items-center justify-content-center mx-auto w-100 shadow-sm" style="height: 250px;">
                                                <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                                            </div>
                                            <p class="text-muted mt-2 mb-0"><small>Sin imagen disponible</small></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4">
        <?php include("../Includes/footer.php"); ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>