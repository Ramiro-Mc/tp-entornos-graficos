<?php
// Conexión a la base de datos
require "../conexion.inc"; // Asegúrate de que la ruta sea correcta
include_once("../Includes/funciones.php");
sesionIniciada();
// Validar ID recibido
if (isset($_GET['cod_local']) && is_numeric($_GET['cod_local'])) {
    $id = intval($_GET['cod_local']);

    // Preparar DELETE seguro
    $stmt = $link->prepare("DELETE FROM locales WHERE cod_local= ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirigir con mensaje de éxito
        header("Location: AdministrarLocales.php?mensaje=eliminado");
        exit;
    } else {
        // Redirigir con mensaje de error
        header("Location: AdministrarLocales.php?mensaje=error");
        exit;
    }

    $stmt->close();
} else {
    // ID no válido
    header("Location: AdministrarLocales.php?mensaje=id_invalido");
    exit;
}

$link->close();
?>
