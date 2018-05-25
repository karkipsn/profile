<?php
    session_start();
     require '../connection.php';
    if(!$_SESSION['user_username']){
        header("location:login.php?session=notset");
    }
?>