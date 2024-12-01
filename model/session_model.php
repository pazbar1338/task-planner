<?php

function sessionDestroy() {
    session_start();
    session_destroy();
}

?>