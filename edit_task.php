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

//obtener los detalles de la tarea a editar
$taskQuery = $conn->query("SELECT Title, Description, Due_date FROM task WHERE Id = $taskId");
if ($taskQuery) {
    while($row = $taskQuery->fetch_assoc()){
        $title = $row['Title'];
        $description = $row['Description'];
        $dueDate = $row['Due_date'];
    }
} else {
    echo $conn->error;
}

//obtener id de usuarios asociados a la tarea (utilizado en el form para rellenar los usuarios preseleccionados)
$assignedUsersQuery = $conn->query("SELECT user_id FROM task_users WHERE task_id = $taskId");
$assignedUsers = [];
if ($assignedUsersQuery) {
    while ($row = $assignedUsersQuery->fetch_assoc()) {
        $assignedUsers[] = $row['user_id'];
    }
}

//obtencion de la id del creador de la tarea
 $createdByquery = $conn->query("SELECT created_by FROM task WHERE Id = $taskId");
 if ($createdByquery) {
 $row = $createdByquery->fetch_assoc();
 $createdBy = $row['created_by'];
}

//manejo de formulario para actualizar tabla task y tabla task_users.
//Si quien intenta modificar los datos no es el creador de la tarea al enviar el formulario no ocurre nada.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $createdBy == $_SESSION['userId']) {

    $newTitle = $_POST['title'];
    $newDescription = $_POST['description'];
    $newDuedate = $_POST['due_date'];
    $newUsers= $_POST['usersArray'];

    //actualizar los datos de la tarea
    $updateTask = $conn->prepare("UPDATE task SET Title = ?, Description = ?, Due_date = ? WHERE Id = ?");
    $updateTask->bind_param("sssi", $newTitle, $newDescription, $newDuedate, $taskId);
    
    if ($newTitle && $newDescription && $newDuedate) {

        if($updateTask->execute()) {
            echo "Titulo, descripcion y fecha de entrega editadas con exito<br>";
        } else {
            echo $conn->error;
        }
    }
    
    //actualizacion de usuarios asignados a la tarea
    if($newUsers) {
        $deleteOldTaskUsers = $conn->prepare("DELETE FROM task_users WHERE task_id = ?");
        $deleteOldTaskUsers->bind_param("i", $taskId);

        //elimnar usuarios previamente asignados (evitar conflicto de FK al actualizar) 
        if ($deleteOldTaskUsers->execute()) {
            echo "Antiguos usuarios eliminados correctamente<br>";
        } else {
            echo $conn->error;
        }
        //agregar los nuevos usuarios seleccionados
        $updateTaskUsers = $conn->prepare("INSERT INTO task_users (user_id, task_id) VALUES (?, ?)");
        foreach($newUsers as $userId) {
            $updateTaskUsers->bind_param("ii", $userId, $taskId);

            if($updateTaskUsers->execute()) {
                echo "Usuarios añadidos con exito";
            } else {
               echo $conn->error;
            }
            header('Location: ./edit_task.php?task_id=' . $taskId); //refresca la pagina actualizar valores editados
        }
    }


}

//RECORDATORIO: antes de poder actualizar la tarea verificar si la id logado coincido con la id de created_by de la tabla task!!!!

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edicion de tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="styles.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>
    <form action="" method="POST">
        <div>
            <input type="hidden" name="task_id" value="<?php echo $taskId ?>">
        </div>
        <div>
            <label for="title">Titulo de la tarea:</label>
            <input type="text" name="title" id="tittle" value="<?php echo $title ?>" required>
        </div>
        <div>
            <label for="description">Descripcion</label>
            <input type="text" name="description" id="description" value="<?php echo $description ?>" required>
        </div>
        <div>
            <label for="due_date">Fecha de entrega</label>
            <input type="date" name="due_date" id="due_date" value="<?php echo $dueDate ?>" required>
        </div>
        <div>
            <label for="usersArray">Asignar a usuario</label>
            <select name="usersArray[]" id=usersArray class="select2" multiple required>
            <?php
                $userQuery = $conn->query("SELECT Id, Name FROM users");
                if ($userQuery) {
                    while ($selectedUser = $userQuery->fetch_assoc()) {
                        //mostrar usuarios asignados a la tarea actual como predeterminados
                        //cuando la Id de los usuarios coincide con la id de los usuarios asignados a la tarea ($assignedUsers) la variable $isSelected toma "selected"(aparece como preseleccionado) o queda vacia
                        if (in_array($selectedUser['Id'], $assignedUsers)) {
                            $isSelected = "selected";
                        } else {
                            $isSelected = "";
                        }
                        echo "<option value='" . $selectedUser['Id'] . "' $isSelected>" . $selectedUser['Name'] . "</option>";
                    }
                }
                ?>
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
            <div>
                <input type="submit" value="Actualizar tarea">
            </div>
            <div>
                <a href="./home.php">Volver a Inicio</a>
            </div>
        </div>
    </form>
    
</body>
</html>