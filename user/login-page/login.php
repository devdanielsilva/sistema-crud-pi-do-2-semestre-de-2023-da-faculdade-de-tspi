<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login-Alpha</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <a href="inicio.php">VOLTAR</a><!--RETIRAR DEPOIS-->
    <div class="main-login">
        <div class="left-login">
            <h1>Entre na aventura dos seus sonhos<br>Seja bem-vindo à nossa loja de games<br>ALPHA!</h1>
            <img src="img/animacao.svg" class="left-login-img">
        </div>

        <form class="right-login" action="testLogin.php" method="post">
            <div class="card-login">
                <div class="right-login-img">
                    <img src="img/Logo darkmode.png">
                </div>
                <h1>LOGIN</h1>
                    <div class="text-field">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="Email">
                    </div>
                    <div class="text-field">
                        <label for="senha">Senha</label>
                        <input type="password" name="senha" id="senha" placeholder="Senha">
                    </div>
                    <input type="submit" name="submit" class="btn-login" value="Login">
                <a href="cadastro.php">cadastrar-se</a>
                <a href="Refazer-senha.php">Esqueci minha senha</a>
            </div>
        </form>
    </div>
</html>
</body>