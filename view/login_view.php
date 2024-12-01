<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

    <h2>Login</h2>
    <?php if(isset($message)) { echo "<p>$message</p>"; } ?>
    <form action="" method="post">
        <div>
            <label>Email:
            <input type="email" name="email" required>
            </label>
        </div>
        <div>
            <label>Contraseña:
            <input type="password" name="password" required>
            </label>
        </div>
        <div>
            <input type="submit" value="Login">
        </div>
        <div>
            <a href="./controller/register_controller.php">Registrate</a>
        </div>
    </form>

</body>
</html>