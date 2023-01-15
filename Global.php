<?php
    session_start();
    $_SESSION['name'] ="";
    $_SESSION['role'] ="";
    $CURRENT_USER_LOGGED_IN = $_SESSION['name'];
    $CURRENT_USER_ROLE = $_SESSION['role'];
?>