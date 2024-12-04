<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="http://localhost/task-planner/styles.css" rel="stylesheet">
    <title>Login</title>
</head>
<body>


<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="bg-light p-5 border border-white rounded shadow text-center">
        <h2>Inicia sesión</h2>
        <?php if(isset($message)) { echo $message; } ?>
        <div class="d-flex justify-content-center align-items-center p-4 rounded">
        
            <form action="" method="post">
                <div>
                    <label class="form-label text-black">Email:
                    <input type="email" name="email" id="email" class="form-control" placeholder="tuemail@dominio.com" required>
                    </label>
                </div>
                <div class="mt-3">
                    <label class="form-label text-black">Contraseña:
                    <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                    </label>
                </div>
                <div class="mt-3">
                    <input type="submit" value="Login" class="btn btn-primary fw-bold">
                    <a href="./controller/register_controller.php" class="btn btn-secondary fw-bold">Registrate</a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>