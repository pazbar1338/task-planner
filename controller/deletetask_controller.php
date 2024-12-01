<?php
session_start();

require '../model/dbconn.php';
require '../model/task_model.php';

if (!isset($_SESSION['userName']) || !isset($_SESSION['userId'])) {
    header('Location: ./index.php');
}

$taskId = $_GET['task_id'];

$taskCreatedByResult = getTaskCreatedBy($conn, $taskId);
$createdBy = null;

if ($taskCreatedByResult && $taskCreatedByResult) {
    $row = $taskCreatedByResult->fetch_assoc();
    $createdBy = $row['created_by'];
}

//verifica que el usuario activo es el creador de la tarea antes de poder borrarla
if ($createdBy == $_SESSION['userId']) {

    //primero elimina los usuarios de la tabla conjunta (task_user)
    $assignedUsersDeleted = deleteAssignedUsers($conn, $taskId);

    //segundo se elimna la tarea
    $taskDeleted = deleteTask($conn, $taskId);
    header('Location: ./home_controller.php');
} else { 
    echo "No tienes permiso para eliminar esta tarea.<br>";
    echo "<a href='./home_controller.php'>Volver a tareas</a>";
}
?>