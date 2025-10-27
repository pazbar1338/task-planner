<?php 

session_start();
include './header.php';

?>

<!-- Traemos a esta pagina a los usuarios que intentar borrar o editar una tarea que ellos no han creado -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intrusos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="http://localhost/task-planner/styles.css" rel="stylesheet">
</head>
<body>
<div class="d-flex justify-content-center align-items-center">
    <div class="text-center">
        <div class="alert alert-info" role="alert">
            <h1>No deberías estar aquí!</h1>
            <a href="../index.php">Volver a inicio <a>
        </div>
    </div>
</div>  
</body>
</html>