<?php
require '../model/user_model.php';

$message = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $name = $_POST['name'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    if (checkEmail($conn, $email)) {
        $message = "Ese email ya existe. Introduce otro";
    } else {
        if (createUser($conn, $name, $email, $password)) {
            $message = "Usuario creado correctamente";
        } else {
            $message = "Error al crear el usuario";
        }
    }
}

require '../view/register_view.php';


?>