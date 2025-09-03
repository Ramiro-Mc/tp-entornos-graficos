<?php 

function consultaSQL($sql_consulta){

    include("../conexion.inc");

    if (!$link) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    $resultados = mysqli_query($link, $sql_consulta);

    mysqli_close($link);

    return $resultados;
}


function sesionIniciada(){
    if(!isset($_SESSION['cod_usuario']) && isset($_COOKIE['usuario_recordado'])){
        $_SESSION['cod_usuario'] = $_COOKIE['usuario_recordado'];
    }
    if(!isset($_SESSION['tipo_usuario']) && isset($_COOKIE['tipo_usuario_recordado'])){
    $_SESSION['tipo_usuario'] = $_COOKIE['tipo_usuario_recordado'];
    }
}