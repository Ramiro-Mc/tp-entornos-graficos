<?php
include("../conexion.inc");
include("../Includes/funciones.php");

$token = $_GET['token'] ?? '';
if ($token) {
    $updateQuery = "UPDATE usuario SET confirmado = 1, token_confirmacion = NULL WHERE token_confirmacion = '$token'";
     if (mysqli_query($link, $updateQuery) && mysqli_affected_rows($link) > 0) {
        echo "Cuenta confirmada!";
    } else {
        echo "Token inválido o cuenta ya confirmada.";
    }
}
mysqli_close($link);

?>

