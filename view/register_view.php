<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta</title>
</head>
<body>

    <h2>Registro de usuario</h2>
    <?php if(isset($message)){ echo "<p>$message</p>"; }?>
    <form action="" method="post">
        <div>
            <label>Nombre de usuario:
            <input type="text" name="name" required>
            </label>
        </div>
        <div>
            <label>Introduce tu email:
            <input type="email" name="email" required>
            </label>
        </div>
        <div>
            <label>Introduce tu contraseña:
            <input type="password" name="password" required>
            </label>
        </div>
        <div>
            <input type="submit" value="Crear">
        </div>
        <div>
            <a href="../index.php">Volver<a>
        </div>
    </form>    
    
</body>
</html>