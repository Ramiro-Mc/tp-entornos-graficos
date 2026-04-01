<?php
session_start();
session_unset();
session_destroy();
setcookie('usuario_recordado', '', time() - 3600, '/');
setcookie('tipo_usuario_recordado', '', time() - 3600, '/');
header("Location: ../Principal/InicioSesion.php");
exit;
?>