<?php
session_start();

if (isset($_SESSION['userId'])) { //si el user tiene sesion activa lo redirige a home
    header('Location: ./controller/home_controller.php');
}

require './controller/login_controller.php';
require './view/login_view.php';
?>