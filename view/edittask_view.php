<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="../styles.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
</head>
<body>
<?php if (isset($message)) { echo $message; } ?>    

    <h2>Editar Tarea</h2>

    <form action="./edittask_controller.php?task_id=<?php echo $taskId ?>" method="post">
        <input type="hidden" name="task_id" value="<?php echo $taskId ?>">
        <div>
            <label for="title">Título:</label>
            <input type="text" name="title" id="title" value="<?php echo $task['Title'] ?>" required>
        </div>
        <div>
            <label for="description">Descripción:</label>
            <textarea name="description" id="description" required><?php echo $task['Description'] ?></textarea>
        </div>
        <div>
            <label for="due_date">Fecha de entrega:</label>
            <input type="date" name="dueDate" id="dueDate"  value="<?php echo $task['Due_date'] ?>" required>
        </div>
        <div>
            <label for="assigned_users">Usuarios asignados:</label>
            <select name="assigned_users[]" id="assigned_users" class="select2" multiple required>
                <?php foreach ($allUsers as $user) { ?>
                    <option value="<?php echo $user['Id']; ?>"
                        <?php 
                        foreach ($assignedUsers as $assignedUser) {
                            if ($assignedUser['Id'] == $user['Id']) {
                                echo 'selected';
                            }
                        } ?>>
                        <?php echo $user['Name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div>
            <button type="submit">Actualizar</button>
        </div>
        <div>
            <a href="./home_controller.php">Volver a la página principal</a>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Selecciona a los usuarios",
                allowClear: true
            });
        });
    </script>
</body>
</html>
