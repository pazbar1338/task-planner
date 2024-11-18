<?php
session_start();

$server = 'localhost';
$usern = 'root';
$passw = '';
$dbname = 'planeadicto';

$conn = new mysqli($server, $usern, $passw, $dbname);

if ($conn->connect_error) {
    die("Error de conexion:" . $conn->connect_error);
}

//lleva a login.php si no estamos logueados
if(!isset($_SESSION['userName']) || !isset($_SESSION['userId'])){
    header('Location: ./login.php');
}

$taskId = $_GET['task_id'];

$createdByquery = $conn->query("SELECT created_by FROM task WHERE Id = $taskId");
if ($createdByquery) {
    $row = $createdByquery->fetch_assoc();
    $createdBy = $row['created_by'];
}

//verifica que la id del usuario es la misma que la id del creador de la tarea antes de eliminarla
if ($createdBy == $_SESSION['userId']) {
    //primero elimina a los usuarios asociados a la tarea
    $assignedUsers = $conn->query("DELETE FROM task_users WHERE task_id = $taskId");
    if ($assignedUsers){
    echo "Usuarios asociados a tarea con Id:" . $taskId . " eliminados correctamente<br>";
    } else {
    echo $conn->error;
    }

    //despues elimina la tarea
    $taskDetails = $conn->query("DELETE FROM task WHERE Id = $taskId");
    if ($taskDetails) {
    echo "Tarea eliminada de la tabla task correctamente";
    } else {
    echo $conn->error;
    }
    header('Location: ./home.php');

} else {
    echo "No tienes permiso para eliminar esta tarea.<br>";
    echo "<a href='./home.php'>Volver a home</a>";
}


?>