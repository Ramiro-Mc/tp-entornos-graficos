
<?php
require "../conexion.inc";
include_once("../Includes/funciones.php");
sesionIniciada();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cod_local']) && is_numeric($_POST['cod_local'])) {
    $id = intval($_POST['cod_local']);

    $stmt = $link->prepare("SELECT foto_local FROM locales WHERE cod_local = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $foto = null;
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $foto = $row['foto_local'];
    }
    $stmt->close();

    $stmt = $link->prepare("DELETE FROM locales WHERE cod_local = ?");
    $stmt->bind_param("i", $id);
    $mensaje = $stmt->execute() ? "eliminado" : "error";
    $stmt->close();

    if ($mensaje === "eliminado" && !empty($foto)) {
        $rutaArchivo = "../" . $foto; // Ajusta según la ruta real de tus uploads
        if (file_exists($rutaArchivo)) {
            unlink($rutaArchivo);
        }
    }

    header("Location: AdministrarLocales.php?mensaje=$mensaje");
    exit;
}

header("Location: AdministrarLocales.php?mensaje=id_invalido");
exit;
