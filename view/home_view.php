<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="http://localhost/task-planner/styles.css" rel="stylesheet">
    <title>Pagina de Inicio</title>
</head>
<body>

    
<?php include 'header.php'; ?>

 
<div class="container p-4 mt-5">
    <a href="../controller/createtask_controller.php" class="btn btn-primary mb-3 fw-bold">Crear nueva tarea</a>
    <h3>Tus tareas creadas</h3>

    <?php if ($createdTasks->num_rows > 0) { ?>
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th scope="col">Tarea</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Fecha de entrega</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Usuarios asignados</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($createdTask = $createdTasks->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $createdTask['Title']; ?></td>
                        <td><?php echo $createdTask['Description']; ?></td>
                        <td><?php echo $createdTask['Due_date']; ?></td>
                        <td>
                            <?php if ($createdTask['completed']) {
                                echo "<p class='text-success'>Completada</p>";
                            } else {
                                echo "<p class='text-danger'>Incompleta</p>";
                            } ?>
                        </td>
                        <td>
                            <?php 
                                $assignedUsers = getAssignedUsers($conn, $createdTask['Id']);
                                if ($assignedUsers) {
                                    while ($userRow = $assignedUsers->fetch_assoc()) { 
                                        echo $userRow['Name'] . ' ';
                                    }
                                }
                            ?>
                        </td>
                        <td class="text-center align-middle">
                            <a href="./edittask_controller.php?task_id=<?php echo $createdTask['Id']; ?>" class="btn btn-warning btn-sm fw-bold">Editar</a>
                            <a href="./deletetask_controller.php?task_id=<?php echo $createdTask['Id']; ?>" class="btn btn-danger btn-sm fw-bold">Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else {
        echo "<p>No has creado ninguna tarea.</p>";
        } 
    ?>
</div>




<div class="container p-4 mt-5">
    <h3>Tus tareas asignadas</h3>

    <?php if ($assignedTasks->num_rows > 0) { ?>
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th scope="col">Tarea</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Fecha de entrega</th>
                    <th scope="col">Autor</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($assignedTaskRow = $assignedTasks->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $assignedTaskRow['Title']; ?></td>
                        <td><?php echo $assignedTaskRow['Description']; ?></td>
                        <td><?php echo $assignedTaskRow['Due_date']; ?></td>
                        <td>
                            <?php 
                                $taskOwnerName = getUserNameById($conn, $assignedTaskRow['created_by']);
                                if ($taskOwnerName) {
                                    while ($ownerName = $taskOwnerName->fetch_assoc()) {
                                        echo $ownerName['Name'];
                                    }
                                } else {
                                    echo "Desconocido";
                                }
                            ?>
                        </td>
                        <td>
                            <?php echo $assignedTaskRow['completed'] ? '<span class="text-success">Completada</span>' : '<span class="text-danger">Incompleta</span>'; ?>
                        </td>
                        <td class="text-center align-middle">
                            <?php if (!$assignedTaskRow['completed']) { ?>
                                <form action="./home_controller.php" method="post" class="d-inline">
                                    <input type="hidden" name="taskId" value="<?php echo $assignedTaskRow['Id']; ?>">
                                    <button type="submit" name="taskComplete" class="btn btn-success btn-sm fw-bold">Tarea realizada</button>
                                </form>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { 
        echo "<p>No estás asignado a ninguna tarea.</p>";
    } ?>
</div>
    
</body>
</html>
