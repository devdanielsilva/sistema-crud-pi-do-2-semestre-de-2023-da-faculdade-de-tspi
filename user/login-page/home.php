<?php 

session_start();
    print_r($_SESSION);
    if (!isset($_SESSION['email']) == true and (!isset($_SESSION['senha']) == true)) {
    
        unset($_SSESION['email']);
        unset($_SSESION['senha']);
        header('Location: login.php');
    }
        
        $logado = $_SESSION['email'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja-Alpha</title>
    <style>
        a {
            text-decoration: none;
            color: white;
            border: 3px solid black;
            border-radius: 15px;
            padding: 10px;
            color: black;
        }
    </style>
</head>
<body>
    <h1>Login concluido com sucesso</h1>
    <a href="sair.php">Sair</a>
</body>
</html>