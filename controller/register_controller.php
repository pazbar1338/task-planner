<?php
require '../model/user_model.php';

$message = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $name = $_POST['name'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    if (checkEmail($conn, $email)) {
        $message = "<p class='text-danger'>Ese email ya existe. Introduce otro.</p>";
    } else {
        if (createUser($conn, $name, $email, $password)) {
            $message = "<p class='text-success'>Usuario creado correctamente.</p>";
        } else {
            $message = "<p class='text-danger'>Error al crear el usuario.</p>";
        }
    }
}

require '../view/register_view.php';


?>