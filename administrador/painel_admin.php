<?php
session_start(); // Iniciar a sessão

if (!isset($_SESSION['admin_logado'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Administrador</title>
    <link rel="stylesheet" href="assets/style_page/painel-admin.css">
</head>

<body>
    <div class="main-login">
        <div class="left-login">
            <img src="assets/img/painel-admin.png" class="left-login-img">
        </div>

        <div class="right-login">

            <div class="card-login">
                <h1>PAINEL DO ADMINISTRADOR</h1>
                <a href="cadastrar_administrador.php">
                    <button class="btn">Cadastro de administrador</button>
                </a>

                <a href="cadastrar_produto.php">
                    <button class="btn">Cadastrar Produtos</button>
                </a>

                <a href="cadastrar-categoria.php">
                    <button class="btn">Cadastrar Categoria</button>
                </a>

                <a href="listar_produtos.php">
                    <button class="btn">Lista de Produtos</button>
                </a>

                <a href="listar_administrador.php">
                    <button class="btn">Lista de administradores</button>
                </a>

                <a href="../administrador/login.php">
                    <button class="btn">Log Out</button>
                </a>
            </div>

        </div>
    </div>
</body>

</html>