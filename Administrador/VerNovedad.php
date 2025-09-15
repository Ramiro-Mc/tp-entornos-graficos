<?php

$folder = "Administrador";
$pestaña = "Ver Novedad";
include_once("../Includes/funciones.php");
require "../conexion.inc";
sesionIniciada();
if (!isset($_GET['cod_novedad']) || !is_numeric($_GET['cod_novedad'])) {
    header("Location: AdministrarLocales.php?mensaje=cod_novedad_invalido");
    exit;
}

$Vcod_novedad = intval($_GET['cod_novedad']);

$stmt = $link->prepare("SELECT * FROM novedades WHERE cod_novedad = ?");
$stmt->bind_param("i", $Vcod_novedad);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    $link->close();
    header("Location: AdministrarLocales.php?mensaje=no_encontrado");
    exit;
}

$novedad = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <?php include("../Includes/head.php"); ?>

    <title>Detalle de la Novedad</title>

</head>

<body>

    <header>

        <?php include("../Includes/header.php"); ?>

    </header>

    <main>

        <div class="container mt-4">
            <h1>Detalle de la Novedad</h1>

            <div class="card">
                <div class="card-body">
                    <h3 class="card-title"><?php echo htmlspecialchars($novedad['texto_novedad']); ?></h3>
                    <p><strong>Fecha Desde:</strong> <?php echo htmlspecialchars($novedad['fecha_desde_novedad']); ?></p>
                    <p><strong>Fecha Hasta:</strong> <?php echo htmlspecialchars($novedad['fecha_hasta_novedad']); ?></p>
                    <p><strong>Categoria:</strong> <?php echo htmlspecialchars($novedad['categoria_cliente']); ?></p>
                    <?php if (!empty($novedad['foto_novedad'])): ?>
                        <p><strong>Multimedia:</strong></p>
                        <img src="../<?= htmlspecialchars($novedad['foto_novedad']) ?>" alt="Foto Novedad" class="img-fluid mb-2" style="max-width:200px;">
                    <?php else: ?>
                        <p><strong>Multimedia:</strong> No hay imagen disponible</p>
                    <?php endif; ?>
                </div>
            </div>

            <a href="AdministrarNovedades.php" class="btn btn-secondary my-3">Volver</a>
        </div>

    </main>

    <footer class="seccion-footer d-flex flex-column justify-content-center align-items-center pt-4">

        <?php include("../Includes/footer.php") ?>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

</body>

</html>