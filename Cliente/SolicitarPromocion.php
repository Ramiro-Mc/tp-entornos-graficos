<?php
include_once("../Includes/session.php");
include_once("../Includes/funciones.php");


$cod_promocion = $_GET['cod_promocion'] ?? "";
$cod_usuario = $_GET['cod_usuario'] ?? "";
$estado = "enviada";


$sql = "INSERT INTO uso_promociones ( cod_promocion, cod_usuario, estado, fecha_uso_promocion)
	VALUES ('$cod_promocion', '$cod_usuario', '$estado', CURDATE())";

consultaSQL($sql);
