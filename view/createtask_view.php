<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creación de tareas</title>
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
    <h2>Crea una nueva tarea</h2>
    <?php if(isset($message)){ echo $message; }?>
    <div class="form-container">
        <form action="" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label text-black">Título de la tarea:</label>
                <input type="text" name="title" class="form-control" id="title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label text-black">Descripción:</label>
                <textarea name="description" class="form-control" id="description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="dueDate" class="form-label text-black">Fecha de entrega:</label>
                <input type="date" name="dueDate" class="form-control" id="dueDate" required>
            </div>
            <div class="mb-3">
                <label for="usersArray" class="form-label text-black">Selecciona los usuarios:</label>
                <select name="usersArray[]" id="usersArray" class="select2" multiple required>
                    <?php foreach ($users as $user){
                        echo '<option value="' . $user['Id'] . '">' . $user['Name'] . '</option>';
                    } ?>
                </select>
                <script>
                    $(document).ready(function() {
                        $('.select2').select2({
                            placeholder: "Haz click aqui",
                            allowClear: true
                        });
                    });
                </script>
            </div>
            <div class="mb-3">
                <input type="submit" value="Crear tarea" class="btn btn-primary">
                <a href="../controller/home_controller.php" class="ms-3">Volver a inicio</a>
            </div>
            
        </form>
    </div>
</body>
</html>
