<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="http://localhost/task-planner/styles.css" rel="stylesheet">
    
</head>
<body>

<?php include 'header.php'; ?>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="bg-light p-5 border border-white rounded shadow text-center">
    <h2>Editar Tarea</h2>
    <?php if (isset($message)) { echo $message; } ?>    
    <div class="form-container">
        <form action="./edittask_controller.php?task_id=<?php echo $taskId ?>" method="post">
            <input type="hidden" name="task_id" value="<?php echo $taskId ?>">
            <div class="mb-3">
                <label for="title" class="form-label text-black">Título:</label>
                <input type="text" name="title" class="form-control" id="title" value="<?php echo $task['Title'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label text-black">Descripción:</label>
                <textarea type="text" name="description" class="form-control" id="description" required><?php echo $task['Description'] ?></textarea>
            </div>
            <div class="mb-3">
                <label for="due_date" class="form-label text-black">Fecha de entrega:</label>
                <input type="date" name="dueDate" class="form-control" id="dueDate"  value="<?php echo $task['Due_date'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="assigned_users" class="form-label text-black">Usuarios asignados:</label>
                <select name="assigned_users[]" class="select2" id="assigned_users" multiple required>
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
                <script>
                    $(document).ready(function() {
                        $('.select2').select2({
                            placeholder: "Selecciona a los usuarios",
                            allowClear: true
                        });
                    });
                </script>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="./home_controller.php" class="ms-3">Volver a inicio</a>
            </div>
        </form>
        
    </div>
</div>
</body>
</html>
