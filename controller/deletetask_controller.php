<?php
session_start();

require '../model/dbconn.php';
require '../model/task_model.php';

if (!isset($_SESSION['userName']) || !isset($_SESSION['userId'])) {
    header('Location: ./index.php');
}

$taskId = $_GET['task_id'];

//obtiene al creador de la tarea
$taskCreatedByResult = getTaskCreatedBy($conn, $taskId);
$createdBy = null;
if ($taskCreatedByResult && $taskCreatedByResult) {
    $row = $taskCreatedByResult->fetch_assoc();
    $createdBy = $row['created_by'];
}

//verifica que el usuario activo es el creador de la tarea antes de poder borrarla
if ($createdBy == $_SESSION['userId']) {

    /*primero elimina los usuarios de la tabla conjunta (task_user)
    si borrara primero la tarea antes de eliminar la asociacion de
    usuarios en la tabla auxiliar daria error por FK */
    $assignedUsersDeleted = deleteAssignedUsers($conn, $taskId);

    //segundo se elimina la tarea
    $taskDeleted = deleteTask($conn, $taskId);
    header('Location: ./home_controller.php');
} else { 
    header('Location: ../view/grounded_view.php');
}
?>