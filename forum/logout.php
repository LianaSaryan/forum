<?php
    require('config/config.php');
    require('config/db.php');
    session_start();
    $_SESSION['LOG_OUT'] = 'You have successfully logged out!';
    header('Location: '.ROOT_URL.'/pathfinder.php');
?>