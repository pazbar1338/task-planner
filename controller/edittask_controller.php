<?php
session_start();

require '../model/task_model.php';
require '../model/user_model.php';


if (!isset($_SESSION['userName']) || !isset($_SESSION['userId'])) {
    header('Location: ./index.php');
}

//$taskId la pasamos desde la URL
$taskId = $_GET['task_id'];

$task = getTaskById($conn, $taskId);
$assignedUsers = getAssignedUsers($conn, $taskId);
$allUsers = getUsers($conn);


$taskCreatedByResult = getTaskCreatedBy($conn, $taskId);
$createdBy = null;
if ($taskCreatedByResult && $taskCreatedByResult) {
    $row = $taskCreatedByResult->fetch_assoc();
    $createdBy = $row['created_by'];
}

if ($createdBy !== $_SESSION['userId']){ //leva al intruso a la pagina de los castigados
    header('Location: ../view/grounded_view.php');
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $dueDate = $_POST['dueDate'];
    $assignedUserIds = $_POST['assigned_users'];

    if ($title && $description && $dueDate) {
        $taskUpdated = updateTask($conn, $taskId, $title, $description, $dueDate, $assignedUserIds);

        if ($taskUpdated) {
            $message = "<p class='text-success'>Tarea actualizada correctamente</p>";

            //reasigna para mostrar los nuevos datos en el formulario
            $task = getTaskById($conn, $taskId);
            $assignedUsers = getAssignedUsers($conn, $taskId);
        } else {
            $message = "<p class='text-danger'>Error al actualizar la tarea. Intenta nuevamente.</p>";
        }
    }
}


require '../view/edittask_view.php';
?>
