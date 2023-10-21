<?php 
    if (isset($_POST['submit'])) {
        //PARA TESTAR NA PROPIA PAGINA SE ESTA SENDO CAPTURADO PELO FORMULÁRIO OS DADOS DO CLIENTE//print_r('nome:'.$_POST['nome']);
        //PARA TESTAR NA PROPIA PAGINA SE ESTA SENDO CAPTURADO PELO FORMULÁRIO OS DADOS DO CLIENTE//print_r('<br>');
        //PARA TESTAR NA PROPIA PAGINA SE ESTA SENDO CAPTURADO PELO FORMULÁRIO OS DADOS DO CLIENTE//print_r('email:'.$_POST['email']);
        //PARA TESTAR NA PROPIA PAGINA SE ESTA SENDO CAPTURADO PELO FORMULÁRIO OS DADOS DO CLIENTE//print_r('<br>');
        //PARA TESTAR NA PROPIA PAGINA SE ESTA SENDO CAPTURADO PELO FORMULÁRIO OS DADOS DO CLIENTE//print_r('senha:'.$_POST['senha']);
        //PARA TESTAR NA PROPIA PAGINA SE ESTA SENDO CAPTURADO PELO FORMULÁRIO OS DADOS DO CLIENTE//print_r('<br>');
        //PARA TESTAR NA PROPIA PAGINA SE ESTA SENDO CAPTURADO PELO FORMULÁRIO OS DADOS DO CLIENTE//print_r('telefone:'.$_POST['telefone']);

        //Incluindo nossa conexao
        include_once('config.php');

        //Criando as variáveis dos inputs no php
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $telefone = $_POST['telefone'];

        //Nossa QUERY para o banco de dados
        $result = mysqli_query($conexao, "INSERT INTO usuario(nome,email,senha,telefone)
        VALUES('$nome','$email','$senha','$telefone')");

        header('Location: login.php');
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro-Alpha</title>
    <link rel="stylesheet" href="css/cadastro.css">
</head>
<body>
    <a href="inicio.php">VOLTAR</a>
    <div class="main-login">
        <div class="left-login">
            <h1>Entre na aventura dos seus sonhos<br>Seja bem-vindo à nossa loja de games<br>ALPHA!</h1>
            <img src="img/animacao.svg" class="left-login-img">
        </div>
        <div class="right-login">
            <div class="card-login">
                <div class="right-login-img">
                    <img src="img/Logo darkmode.png">
                </div>
                <h1>Cadastre-se</h1>
                <form action="cadastro.php" method="POST">
                    <div class="text-field">
                        <label for="text">Nome</label>
                        <input type="text" name="nome" id="nome" placeholder="Nome" required>
                    </div>
                    <div class="text-field">
                        <label for="senha">Email</label>
                        <input type="email" name="email" id="email" placeholder="Email" required>
                    </div>
                    <div class="text-field">
                        <label for="senha">Senha</label>
                        <input type="password" name="senha" id="senha" placeholder="Senha" required>
                    </div>
                    <div class="text-field">
                        <label for="senha">Telefone</label>
                        <input type="tel" name="telefone" id="telefone" placeholder="Telefone" required>
                    </div>
                    <input type="submit" name="submit" class="btn-login" value="Cadastrar-se">
                </form>
            </div>
        </div>
    </div>
</html>
</body>