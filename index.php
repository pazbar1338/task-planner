<?php
session_start();

if (isset($_SESSION['userId'])) {
    header('Location: ./controller/home_controller.php');
}

require './controller/login_controller.php';
require './view/login_view.php';
?>