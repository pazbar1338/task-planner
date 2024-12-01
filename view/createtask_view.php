<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creación de tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="../styles.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>
    <?php if (isset($message)) { echo $message; } ?>
    
    <form action="" method="POST">
        <div>
            <label for="title">Título de la tarea:</label>
            <input type="text" name="title" id="title" required>
        </div>
        <div>
            <label for="description">Descripción:</label>
            <textarea name="description" id="description" required></textarea>
        </div>
        <div>
            <label for="dueDate">Fecha de entrega:</label>
            <input type="date" name="dueDate" id="dueDate" min="" required>
        </div>
        <div>
            <label for="usersArray">Asignar a usuario:</label>
            <select name="usersArray[]" id="usersArray" class="select2" multiple required>
                <?php foreach ($users as $user){
                    echo '<option value="' . $user['Id'] . '">' . $user['Name'] . '</option>';
                } ?>
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
        <div>
            <a href="../controller/home_controller.php">Volver a inicio</a>
        </div>
    </form>  
</body>
</html>
