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

//manejo del formulario para crear tarea y asignar usuarios
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $title = $_POST['title'];
    $description = $_POST['description'];
    $dueDate = $_POST['dueDate'];
    // $userId = $_SESSION['userId'];
    $usersToTask = $_POST['usersArray']; //array que contiene las Id de los usuarios selecionados

    //creacion de tarea
    if($title && $description && $dueDate) { 
        $query = $conn->prepare("INSERT INTO task (Title, Description, Due_date, Created_by) VALUES (?, ?, ?, ?)"); //prepara la peticion
        $query->bind_param("ssss", $title, $description, $dueDate, $userId); //enlaza los parametros con las variables obtenidas desde el form

        if($query->execute()) { //crea la tarea
            $taskId = $conn->insert_id; //obtiene la Id de la ultima tarea creada

            //asignacion de usuarios a la tarea
            if($usersToTask) {
                $userTaskQuery = $conn->prepare("INSERT INTO task_users (user_id, task_id) VALUES (?, ?)");

                foreach($usersToTask as $userId) { //$userId va tomando los valores de las Id de usuarios 
                    $userTaskQuery->bind_param("ii", $userId, $taskId);
                    $userTaskQuery->execute();
                }
                // echo "Usuarios asignados correctamente.<br>";

            }
            header('Location: ./home.php'); //refresca la pagina 
            // echo "Tarea creada correctamente.";

        } else {
            echo $query->error;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina de Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="styles.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</head>
<body>
    <h2>Hola <?php echo $_SESSION['userName']?>, con Id: <?php echo $_SESSION['userId']?>, creamos alguna tarea?</h2>

    <form action="" method="POST">
        <div>
            <label for="title">Titulo de la tarea:</label>
            <input type="text" name="title" id="title" required>
        </div>
        <div>
            <label for="description">Descripcion:</label>
            <textarea name="description" id="description" required></textarea>
        </div>
        <div>
            <label for="dueDate">Fecha de entrega:</label>
            <input type="date" name="dueDate" id="dueDate" min="" required>
        </div>
        <div>
            <label for="usersArray">Asignar a usuario:</label>
            <select name="usersArray[]" id=usersArray class="select2" multiple required> <!-- usersArray[] ha de ser de tipo array, [] para poder ser iterado  -->
            <?php
                $user_query = $conn->query("SELECT Id, Name FROM users");
                if($user_query){
                    while ($selectedUsers = $user_query->fetch_assoc()) {
                        echo "<option value='" . $selectedUsers['Id'] . "'>" . $selectedUsers['Name'] . "</option>"; //rellena las opciones con el Nombre y el Id de la tabla usuarios
                    }
                }
            
            ?>
            </select>
            <script>
                $(document).ready(function() {
                    $('.select2').select2({
                        placeholder: "Selecciona a los usuarios",
                        allowClear: true
                     });
                });
            </script>
        </div>
        <div>
            <input type="submit" value="Crear tarea">
        </div>
    </form>
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