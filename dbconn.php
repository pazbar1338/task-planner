<?php

$conn = new mysqli('localhost', 'root', '', 'planeadicto');

if ($conn->connect_error) {
    die("Error de conexion:" . $conn->connect_error);
}

?>