<?php

$host = 'localhost';
$root = 'root';
$password = '';
$dbname = 'planeadicto';

$conn = new mysqli($host, $root, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexion:" . $conn->connect_error);
}

?>