<?php
require '../model/session_model.php';

sessionDestroy();

header('Location:../index.php');
?>
