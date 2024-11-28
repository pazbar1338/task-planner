<?php
session_start();

require 'dbconn.php';

//lleva a login.php si el usuario no se ha logueado
if(!isset($_SESSION['userName']) || !isset($_SESSION['userId'])){
    header('Location: ./login.php');
}

//manejo de formulario para cambiar el 
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (isset($_POST['taskComplete'])) {
        $taskId = $_POST['taskId'];

        $taskCompleteQuery = $conn->query("UPDATE task SET completed = 1 WHERE Id = $taskId");
        if ($taskCompleteQuery) {
            echo "Tarea marcada como completada";
        } else {
            echo $conn->error;
        }
        header('Location:' . $_SERVER['PHP_SELF']);
    }
}

$userId = $_SESSION['userId']; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina de Inicio</title>
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <h2>Hola <?php echo $_SESSION['userName']?>, con Id: <?php echo $_SESSION['userId']?>, creamos alguna tarea?</h2>
    
    <div>
        <a href="./create_task.php">Crear nueva tarea</a>
    </div>

    <div>
        <a href="./logout.php">Log out</a>
    </div>
    <div>
        <h2>Tus tareas creadas:</h2>
        <?php

        //mostrar tareas creadas por el user logueado 
        $createdTasksQuery = $conn->query("SELECT Id, Title, Description, Due_date, completed FROM task WHERE Created_by = $userId");
        if ($createdTasksQuery->num_rows > 0){
            while ($row = $createdTasksQuery->fetch_assoc()) {
                echo "Titulo: " . $row['Title'] . " <br>";
                echo "Descripcion: " . $row['Description'] . " <br>";

                $userQuery = $conn->query("SELECT Name FROM users WHERE Id IN (SELECT user_id FROM task_users WHERE task_id = " . $row['Id'] . ")");
                if($userQuery) {
                    echo "Asignado a: ";
                    while($userRow = $userQuery->fetch_assoc()) {
                        echo $userRow['Name'] . " ";  
                    }
                }
                echo "<br>";
                echo "Fecha de entrega: " . $row['Due_date'] . " <br>";
                if ($row['completed'] == 1) {
                    echo "Tarea completada<br>";
                } else {
                    echo "Tarea incompleta<br>";
                }
                echo "<a href='./edit_task.php?task_id=" . $row['Id'] . "'>Editar tarea</a><br>";
                echo "<a href='./delete_task.php?task_id=" . $row['Id'] . "'> Eliminar tarea</a><br><br>";

                
                
            }
        } else {
            echo "No has creado ninguna tarea";
        }
        ?>
    </div>
    <div>
        <h2>Tus tareas asignadas:</h2>
        <?php

        //mostrar tareas asignadas al user logueado
        $assignedTasksQuery = $conn->query("SELECT Title, Description, Due_date, created_by, completed, Id FROM task WHERE Id IN (SELECT task_id FROM task_users WHERE user_id = $userId)");
        if($assignedTasksQuery->num_rows > 0){
            while ($taskRow = $assignedTasksQuery->fetch_assoc()) {

                echo "Titulo: " . $taskRow['Title'] . " <br>";
                echo "Descripcion: " . $taskRow['Description'] . " <br>";
                echo "Fecha de entrega: " . $taskRow['Due_date'] . " <br>";
                echo "Creado por " . $taskRow['created_by'] . " <br>";

                if (!$taskRow['completed']) {
                    echo "
                    <form action='' method='post'>
                        <input type='hidden' name='taskId' value='" . $taskRow['Id'] . "'>
                        <button type='submit' name='taskComplete'>Tarea realizada</button>
                    </form>";
                    echo "<br>";
                } else {
                    echo "Tarea completada";
                }
                
            }
        } else {
            echo "No estas asignado a ninguna tarea";
        }

        ?>
    </div>
    
</body>
</html>