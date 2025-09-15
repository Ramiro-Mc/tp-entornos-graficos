<?php

function consultaSQL($sql_consulta)
{

    include("../conexion.inc");

    if (!$link) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    $resultados = mysqli_query($link, $sql_consulta);

    mysqli_close($link);

    return $resultados;
}


function sesionIniciada()
{
    if (!isset($_SESSION['cod_usuario']) && isset($_COOKIE['usuario_recordado'])) {
        $_SESSION['cod_usuario'] = $_COOKIE['usuario_recordado'];
    }
    if (!isset($_SESSION['tipo_usuario']) && isset($_COOKIE['tipo_usuario_recordado'])) {
        $_SESSION['tipo_usuario'] = $_COOKIE['tipo_usuario_recordado'];
    }
}

function paginacion($pagina, $total_paginas, $params = [])
{
    echo '<nav><ul class="pagination justify-content-center">';
    for ($i = 1; $i <= $total_paginas; $i++) {
        $activo = $i == $pagina ? 'active' : '';
        $query = http_build_query(array_merge(['pagina' => $i], $params));
        echo "<li class='page-item $activo'><a class='page-link' href='?{$query}'>{$i}</a></li>";
    }
    echo '</ul></nav>';
}
