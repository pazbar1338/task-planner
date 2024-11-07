<?php
session_start();

if (isset($_SESSION['username'])) {
    echo "Hola " . $_SESSION['username'];
} else {
    header('Location: login.php');
}


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina de Inicio</title>
</head>
<body>
    <h2>Bienvenido, estas en home</h2>
</body>
</html>