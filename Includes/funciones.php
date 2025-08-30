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