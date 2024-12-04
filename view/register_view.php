<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="http://localhost/task-planner/styles.css" rel="stylesheet">
    <title>Registro de usuario</title>
</head>
<body>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="bg-light p-5 border border-white rounded shadow text-center">
        <h2>Registro de usuario</h2>
        <?php if(isset($message)){ echo $message; }?>
        <div class="form-container">
            <form action="" method="post">
                <div class="mt-3">
                    <label class="form-label text-black">Nombre de usuario:
                    <input type="text" name="name" class="form-control" placeholder="Nombre" required>
                    </label>
                </div>
                <div class="mt-3">
                    <label class="form-label text-black">Introduce tu email:
                    <input type="email" name="email" class="form-control" placeholder="Ejemplo@dominio.com" required>
                    </label>
                </div>
                <div class="mt-3">
                    <label class="form-label text-black">Introduce tu contraseña:
                    <input type="password" name="password" class="form-control" placeholder="Contraseña"required>
                    </label>
                </div>
                <div class="mt-3">
                    <input type="submit" value="Crear" class="btn btn-primary fw-bold">
                    <a href="../index.php" class="ms-2 fw-bold">Volver a login<a>
                </div>
                <div>
                    
                </div>
            </form>
        </div>
    </div>
</div>    
    
</body>
</html>