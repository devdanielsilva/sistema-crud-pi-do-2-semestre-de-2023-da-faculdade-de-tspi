<?php 
    session_start();

    if (isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha'])) {
        //Caso exista uma variavel "submit" com os dados fornecidos pelo usuário ele ACESSA o site

        //Conexao com o banco de dados
        include_once('config.php');
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $sql = "SELECT * FROM usuario WHERE email = '$email' and senha = '$senha'";

        $result = $conexao->query($sql);

        if (mysqli_num_rows($result) <1) {

            //Aqui, como ele não possui login, o "unset" vai deletar da sessao as informações fornecidas pelo usuario
            unset($_SSESION['email']);
            unset($_SSESION['senha']);
            header('Location: login.php');

        } else {

            //Aqui, como ele tem login, vamos quardar as informações de login na sessao
            $_SESSION['email'] = $email;
            $_SESSION['senha'] = $senha;
            header('Location: home.php');

        }

    } else {
        header(('Location: login.php'));
        //Caso NÃO exista uma variavel "submit" com os dados fornecidos pelo usuário ele NÃO acessa o site

    }

?>