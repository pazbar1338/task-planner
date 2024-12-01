<?php
session_start();

require '../model/task_model.php';
require '../model/user_model.php';

//verifica que el usuario este logado
if (!isset($_SESSION['userName']) || !isset($_SESSION['userId'])) {
    header('Location: ../index.php');
}

//asigna variables a inputs del usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $dueDate = $_POST['dueDate'];
    $createdBy = $_SESSION['userId'];
    $usersToTask = $_POST['usersArray']; // array con las Ids de los usuarios

    // Creacion y asignacion de la tarea a los usuarios seleccionados
    if ($title && $description && $dueDate && $usersToTask) {
        $taskCreated = createTask($title, $description, $dueDate, $createdBy, $usersToTask, $conn);

        if ($taskCreated) {
            $message = "Tarea creada y usuarios asignados correctamente.";
        } else {
            $message = "Hubo un error al crear la tarea o asignar usuarios.";
        }
    }
}

// Obtiene Id y Nombre de todos los usuarios de la BD para en la vista poblar el selector
$users = getUsers($conn);

require '../view/createtask_view.php';