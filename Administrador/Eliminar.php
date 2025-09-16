<?php
require "../conexion.inc";
include_once("../Includes/funciones.php");
sesionIniciada();

$tipo = $_POST['tipo'] ?? '';
$id   = isset($_POST['cod']) && is_numeric($_POST['cod']) ? intval($_POST['cod']) : 0;

if (!$tipo || !$id) {
    header("Location: index.php?mensaje=id_invalido");
    exit;
}

switch ($tipo) {
    case 'local':
        $tabla = 'locales';
        $colFoto = 'foto_local';
        $volver = 'AdministrarLocales.php';
        break;
    case 'novedad':
        $tabla = 'novedades';
        $colFoto = 'foto_novedad';
        $volver = 'AdministrarNovedades.php';
        break;
    default:
        header("Location: index.php?mensaje=tipo_invalido");
        exit;
}

$sql = $link->prepare("SELECT $colFoto FROM $tabla WHERE " . ($tipo === 'local' ? 'cod_local' : 'cod_novedad') . " = ?");
$sql->bind_param("i", $id);
$sql->execute();
$result = $sql->get_result();
$foto = null;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $foto = $row[$colFoto];
}
$sql->close();

$sql = $link->prepare("DELETE FROM $tabla WHERE " . ($tipo === 'local' ? 'cod_local' : 'cod_novedad') . " = ?");
$sql->bind_param("i", $id);
$mensaje = $sql->execute() ? 'eliminado' : 'error';
$sql->close();

if ($mensaje === 'eliminado' && !empty($foto)) {
    $rutaArchivo = "../" . $foto;
    if (file_exists($rutaArchivo)) unlink($rutaArchivo);
}

header("Location: $volver?mensaje=$mensaje");
exit;
