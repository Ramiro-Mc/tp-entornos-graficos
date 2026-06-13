<?php

require_once(__DIR__ . '/env.php');

load_env(dirname(__DIR__) . '/.env');

$host = env('DB_HOST');
$user = env('DB_USER');
$pass = env('DB_PASS');
$db   = env('DB_NAME');

$link = mysqli_connect($host, $user, $pass, $db);

if (!$link) {
    die("Error de conexión");
}

mysqli_set_charset($link, "utf8");