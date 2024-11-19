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

$userId = $_SESSION['userId']; // conn.php?

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
        $createdTasksQuery = $conn->query("SELECT Id, Title, Description, Due_date FROM task WHERE Created_by = $userId");
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
        $assignedTasksQuery = $conn->query("SELECT Title, Description, Due_date, created_by FROM task WHERE Id IN (SELECT task_id FROM task_users WHERE user_id = $userId)");
        if($assignedTasksQuery->num_rows > 0){
            while ($taskRow = $assignedTasksQuery->fetch_assoc()) {

                echo "Titulo: " . $taskRow['Title'] . " <br>";
                echo "Descripcion: " . $taskRow['Description'] . " <br>";
                echo "Fecha de entrega: " . $taskRow['Due_date'] . " <br>";
                echo "Creado por " . $taskRow['created_by'] . " <br>"; //RECORDATORIO: cambiar Id por nombre de usuario!!!!!!!
                echo "<br>";
            }
        } else {
            echo "No estas asignado a ninguna tarea";
        }

        ?>
    </div>
    
</body>
</html>