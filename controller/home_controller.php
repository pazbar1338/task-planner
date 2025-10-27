<?php
require '../model/task_model.php';
require '../model/user_model.php';

session_start();

// Si el usuario no esta logueado lo envia al punto de entrada de la aplicacion
if (!isset($_SESSION['userName']) || !isset($_SESSION['userId'])) {
    header('Location: ../index.php');
}

$userId = $_SESSION['userId'];


//el boton de tarea completa es un formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['taskComplete'])) { 
    $taskId = $_POST['taskId'];
    markTaskComplete($conn, $taskId);
    header('Location: ' . $_SERVER['PHP_SELF']);
}

//Solicita y asigna las tareas creadas y asignadas a las variables
$createdTasks = getCreatedTasks($conn, $userId);
$assignedTasks = getAssignedTasks($conn, $userId);

require '../view/home_view.php';
?>