<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina de Inicio</title>
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <h2>Hola <?php echo ($_SESSION['userName']); ?>, con Id: <?php echo ($_SESSION['userId']); ?>, ¿creamos alguna tarea?</h2>
    
    <div>
        <a href="../controller/createtask_controller.php">Crear nueva tarea</a> 
    </div>
    <div>
        <a href="../controller/session_controller.php">Log out</a>
    </div>

    <div>
        <h2>Tus tareas creadas:</h2>
        <?php 
            if ($createdTasks->num_rows > 0) {
                foreach ($createdTasks as $createdTask) {
                    echo '<p>';
                    echo 'Titulo: ' . $createdTask['Title'] . '<br>';
                    echo 'Descripción: ' . $createdTask['Description'] . '<br>';
                    echo 'Fecha de entrega: ' . $createdTask['Due_date'] . '<br>';
                    echo 'Estado:';
                    if ($createdTask['completed']){
                        echo 'Tarea completada';
                    } else {
                        echo 'Tarea incompleta';
                    }
                    echo '<br>';
                    echo 'Usuarios asignados: ';
                    $assignedUsers = getAssignedUsers($conn, $createdTask['Id']);
                    if ($assignedUsers) {
                        while ($userRow = $assignedUsers->fetch_assoc()) { 
                            echo $userRow['Name'] . ' ';
                        }
                    }
                    echo '<br>';
                    echo '<a href="./edittask_controller.php?task_id=' . $createdTask['Id'] . '">Editar tarea</a><br>';
                    echo '<a href="./deletetask_controller.php?task_id=' . $createdTask['Id'] . '">Eliminar tarea</a><br>';
                    echo '</p>';
                }
            } else {
                echo '<p>No has creado ninguna tarea</p>';
            }

           
            
        ?>
    </div>

    <div>
        <h2>Tus tareas asignadas:</h2>
        <?php if ($assignedTasks->num_rows > 0) {
            while ($assignedTaskRow = $assignedTasks->fetch_assoc()) {
                echo '<p>';
                echo 'Título: ' . $assignedTaskRow['Title'] . '<br>';
                echo 'Descripción: ' . $assignedTaskRow['Description'] . '<br>';
                echo 'Fecha de entrega: ' . $assignedTaskRow['Due_date'] . '<br>';
                echo 'Tarea creada por: ';

                $taskOwnerName = getUserNameById($conn, $assignedTaskRow['created_by']);
                if ($taskOwnerName) {
                    while ($ownerName = $taskOwnerName->fetch_assoc()){
                        echo $ownerName['Name']; 
                    }
                }
                echo '<br>';
                if (!$assignedTaskRow['completed']) {
                    echo '<form action="./home_controller.php" method="post">';
                    echo '<input type="hidden" name="taskId" value="' . $assignedTaskRow['Id'] . '">';
                    echo '<button type="submit" name="taskComplete">Tarea realizada</button>';
                    echo '</form>';
                } else {
                    echo 'Estado: Tarea completada<br>';
                }
                echo '</p>';
            }
        } else {
            echo '<p>No estas asignado a ninguna tarea.</p>';
        }
        ?>
    </div>
</body>
</html>
