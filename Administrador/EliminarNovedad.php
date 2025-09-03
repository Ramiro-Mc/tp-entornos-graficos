<?php
// Conexión a la base de datos
require "../conexion.inc"; // Asegúrate de que la ruta sea correcta
include_once("../Includes/funciones.php");
sesionIniciada();
// Validar ID recibido
if (isset($_GET['cod_novedad']) && is_numeric($_GET['cod_novedad'])) {
    $id = intval($_GET['cod_novedad']);

    // Preparar DELETE seguro
    $stmt = $link->prepare("DELETE FROM novedades WHERE cod_novedad = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirigir con mensaje de éxito
        header("Location: AdministrarNovedades.php?mensaje=eliminado");
        exit;
    } else {
        // Redirigir con mensaje de error
        header("Location: AdministrarNovedades.php?mensaje=error");
        exit;
    }

    $stmt->close();
} else {
    // ID no válido
    header("Location: AdministrarNovedades.php?mensaje=id_invalido");
    exit;
}

$link->close();
?>
