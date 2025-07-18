<?php
include("../conexion.inc");
$vEmail = $_POST['email'];
$vPassword = $_POST['password'];
$vSql = "SELECT codUsuario, claveUsuario FROM USUARIOS WHERE nombreUsuario='$vEmail'";
// $vResultado = mysqli_query($link, $vSql) or die(mysqli_error($link));
$vCantLocales = mysqli_fetch_assoc($vResultado);
if ($vCantUsuario['cantitad'] != 0) {
    echo ("El usuario ya Existe<br>");
    // hacer html
} else {
}
mysqli_free_result($vResultado);
mysqli_close($link);
?></body>

</html>