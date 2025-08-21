<?php
include("../conexion.inc");
$hoy = date("Y-m-d");

$sql = "DELETE FROM novedades WHERE fecha_hasta_novedad < ?";
$stmt = $link->prepare($sql);
$stmt->bind_param("s", $hoy);
$stmt->execute();
$stmt->close();
$link->close();
?>
