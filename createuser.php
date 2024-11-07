<?php

$server = 'localhost';
$usern = 'root';
$passw = '';
$dbname = 'planeadicto';

$conn = new mysqli($server, $usern, $passw, $dbname);

if ($conn->connect_error) {
    die("Error de conexion:" . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['user'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    if ($email) {
        $query = $conn->prepare("SELECT COUNT(*) FROM users WHERE Email = ?");
        $query->bind_param("s", $email);
        $query->execute();
        $query->bind_result($emailCount);
        $query->fetch();
        $query->close();

        if ($emailCount > 0) {
            echo "Ese email ya existe. Por favor, introduce otro.";

        } else {
            $query = $conn->prepare("INSERT INTO users (Name, Email, Password) VALUES (?, ?, ?)");
            $query->bind_param("sss", $user, $email, $password);

            if ($query->execute()) {
            echo "Usuario creado correctamente";

            } else {
            echo $query->error;
        }
        $query->close();
    }}
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta</title>
</head>
<body>

    <h2>Registro de usuario</h2>
    <form action="" method="post">
        <div>
            <label>Nombre de usuario:
            <input type="text" name="user" required>
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
            <a href="/task-planner/login.php">Volver<a>
        </div>
    
    </form>    

</body>
</html>