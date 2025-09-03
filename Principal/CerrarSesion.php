<?php
session_start();
session_unset();   
setcookie('usuario_recordado', '', time() - 3600, "/");   
session_destroy();    
header("Location: index.php"); 
exit;
?>