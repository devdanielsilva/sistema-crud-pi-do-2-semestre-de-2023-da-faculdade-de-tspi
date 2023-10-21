<?php 
    session_start();
    unset($_SESSION['email']);
    unset($senha['senha']);
    header("Location: login.php");
?>