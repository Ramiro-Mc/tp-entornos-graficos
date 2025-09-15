<?php
require "../conexion.inc";
include_once("../Includes/funciones.php");
sesionIniciada();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cod_novedad']) && is_numeric($_POST['cod_novedad'])) {
    $id = intval($_POST['cod_novedad']);

    $stmt = $link->prepare("SELECT foto_novedad FROM novedades WHERE cod_novedad = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $foto = null;
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $foto = $row['foto_novedad'];
    }
    $stmt->close();

    $stmt = $link->prepare("DELETE FROM novedades WHERE cod_novedad = ?");
    $stmt->bind_param("i", $id);
    $mensaje = $stmt->execute() ? "eliminado" : "error";
    $stmt->close();

    if ($mensaje === "eliminado" && !empty($foto)) {
        $rutaArchivo = "../" . $foto; // Ajusta según la ruta real de tus uploads
        if (file_exists($rutaArchivo)) {
            unlink($rutaArchivo);
        }
    }

    header("Location: AdministrarNovedades.php?mensaje=$mensaje");
    exit;
}

header("Location: AdministrarNovedades.php?mensaje=id_invalido");
exit;
