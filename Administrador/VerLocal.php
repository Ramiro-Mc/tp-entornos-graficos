<?php
require "../conexion.inc";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: AdministrarLocales.php?mensaje=id_invalido");
    exit;
}

$id = intval($_GET['id']);

$stmt = $link->prepare("SELECT NombreLocal, RubroLocal, UbicacionLocal, CodUsuario, Multimedia FROM local WHERE Id = ?");
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
    <title>Detalle del Local</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-4">
    <h1>Detalle del Local</h1>

    <div class="card">
        <div class="card-body">
            <h3 class="card-title"><?php echo htmlspecialchars($local['NombreLocal']); ?></h3>
            <p><strong>Rubro:</strong> <?php echo htmlspecialchars($local['RubroLocal']); ?></p>
            <p><strong>Ubicación:</strong> <?php echo htmlspecialchars($local['UbicacionLocal']); ?></p>
            <p><strong>Codigo Dueño:</strong> <?php echo htmlspecialchars($local['CodUsuario']); ?></p>
            <p><strong>Multimedia:</strong> <?php echo htmlspecialchars($local['Multimedia']); ?></p>
        </div>
    </div>

    <a href="AdministrarLocales.php" class="btn btn-secondary mt-3">Volver</a>
</div>
</body>
</html>
