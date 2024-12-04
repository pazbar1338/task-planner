<?php

require './model/user_model.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(checkLoginData($conn, $email, $password)){
        $user = getUserData($conn, $email, $password);

        if($user){
            //asigna datos de sesion
            $_SESSION['userName'] = $user['userName'];
            $_SESSION['userId'] = $user['userId'];
            header('Location: ./controller/home_controller.php');
        }
    } else {
        $message = "<p class='text-danger'>Datos invalidos. Registrate si no tienes cuenta</p>";
    }
}


?>