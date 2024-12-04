<?php

function sessionDestroy() {
    session_start();
    session_destroy();
}

sessionDestroy();

header('Location:../index.php');
?>
