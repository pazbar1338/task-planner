<?php

session_start();

$server = 'localhost';
$usern = 'root';
$passw = '';
$dbname = 'planeadicto';

$conn = new mysqli($server, $usern, $passw, $dbname);

if ($conn->connect_error) {
    die("Error de conexion:" . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = $conn->prepare("SELECT Name, Email, Password FROM users WHERE Email = ? AND Password = ?");
    $query->bind_param("ss", $email, $password);
    $query->execute();
    $query->bind_result($username, $usermail, $userpassword);

    if ($query->fetch()) {
        $_SESSION['username'] = $username;
        header('Location: ./home.php');

    } else {
        echo "Credenciales incorrectas. Registrate si no tienes cuenta";
    }
    $query->close();
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

    <h2>Login</h2>
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
            <a href="./createuser.php">Registrate</a>
        </div>
    </form>

</body>
</html>