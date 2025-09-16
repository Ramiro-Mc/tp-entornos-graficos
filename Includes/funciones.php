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

function getIntParam($name, $redirect)
{
    if (!isset($_GET[$name]) || !is_numeric($_GET[$name])) {
        header("Location: $redirect?mensaje={$name}_invalido");
        exit;
    }
    return intval($_GET[$name]);
}

function fetchOne($link, $sql, $types, ...$params)
{
    $sql = $link->prepare($sql);
    $sql->bind_param($types, ...$params);
    $sql->execute();
    $result = $sql->get_result();
    $row = $result->fetch_assoc();
    $sql->close();
    return $row;
}

function e($str)
{
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

function subirArchivo($file, $prefijo)
{
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK || empty($file['name'])) return null;

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $permitidos = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'pdf'];
    if (!in_array($ext, $permitidos)) return "Formato de archivo no permitido.";

    $nuevoNombre = $prefijo . "_" . uniqid() . "." . $ext;
    $destino = "../uploads/" . $nuevoNombre;
    if (move_uploaded_file($file['tmp_name'], $destino)) {
        return "uploads/" . $nuevoNombre;
    } else {
        return "Error al mover el archivo.";
    }
}
