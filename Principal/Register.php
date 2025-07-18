<?php
include("../conexion.inc");
$vEmail = $_POST['email'];
$vPassword = $_POST['password'];
$vTipoUsuario = $_POST['tipoUsuario'];
if ($vTipoUsuario == 'cliente') {
  $vCategoriaCliente = "Inicial";
}

// Verificar si el usuario ya existe
$vSql = "SELECT COUNT(*) as cantidad FROM usuarios WHERE nombreUsuario='$vEmail'";
$vResultado = mysqli_query($link, $vSql) or die(mysqli_error($link));
$vCantUsuario = mysqli_fetch_assoc($vResultado);

if ($vCantUsuario['cantidad'] != 0) {
  echo ("El usuario ya Existe<br>");
  // hacer html
} else {
  if ($vTipoUsuario == 'cliente') {
    $vSql = "INSERT INTO usuarios (nombreUsuario, claveUsuario, tipoUsuario, categoriaCliente)  
      VALUES ('$vEmail', '$vPassword', '$vTipoUsuario', '$vCategoriaCliente')";
  } else {
    $vSql = "INSERT INTO usuarios (nombreUsuario, claveUsuario, tipoUsuario, categoriaCliente)  
      VALUES ('$vEmail', '$vPassword', '$vTipoUsuario', 'null')";
  }
  mysqli_query($link, $vSql) or die(mysqli_error($link));
  echo ("El usuario fue Registrado<br>");
  // hacer html
}
mysqli_free_result($vResultado);
mysqli_close($link);
