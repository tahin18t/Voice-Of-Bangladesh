<?php

// Use database credentials from .env (falls back to sensible defaults)
$host = env('DB_HOST');
$user = env('DB_USERNAME');
$pass = env('DB_PASSWORD','');
$name = env('DB_DATABASE');
$port = env('DB_PORT');

$connect = mysqli_connect($host, $user, $pass, $name, (int) $port);

?>
