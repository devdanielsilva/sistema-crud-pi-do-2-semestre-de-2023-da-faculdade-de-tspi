<?php
// Inclua o arquivo de configuração da conexão com o banco de dados
require_once('../config/conexao.php');
 
// Inicia a sessão para gerenciamento do usuário.
session_start();
 
// Verifica se o administrador está logado.
if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}
 
// Bloco que será executado quando o formulário for submetido.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pegando os valores do POST.
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;
 
    // Inserindo administrador no banco.
    try {
        $sql = "INSERT INTO ADMINISTRADOR (ADM_NOME, ADM_EMAIL, ADM_SENHA, ADM_ATIVO) VALUES (:nome, :email, :senha, :ativo);";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
        $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);
 
        $stmt->execute(); // Adicionado para executar a instrução
 
        // Pegando o ID do administrador inserido.
        $adm_id = $pdo->lastInsertId();
 
        echo "<p style='color:green;'>Administrador cadastrado com sucesso!</p>";
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao cadastrar administrador: " . $e->getMessage() . "</p>";
    }
}
?>
 
 
 
<!DOCTYPE html>
<html lang="pt-br">
 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Administrador</title>
    <link rel="stylesheet" href="assets/style_page/cadastro-de-administrador.css">
    <link rel="stylesheet" href="assets/global.css">
</head>
 
<body>
    <div class="main-adm">
        <div class="left-adm">
            <img src="assets/img/cadastro-admin.png" alt="imagem-do-painel-do-admin" class="left-adm-img">
        </div>
 
        <form class="right-adm" action="cadastrar_administrador.php" method="post">
            <div class="card-adm">
                <h1>CADASTRO DO ADMINISTRADOR</h1>
                <form action="" method="post" enctype="multipart/form-data">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email">
                    <label for="password" name="senha" id="senha">Senha</label>
                    <input type="password" name="senha" id="senha">
                    <label for="ativo">Ativo:</label>
                    <input type="checkbox" name="ativo" id="ativo" class="checkbox" value="1" checked>
                    <br>
                    <input type="submit" value="Cadastrar" class="cadastrar">
                </form>
 
                <a href="listar_administrador.php" class="btn">Lista de Administrador</a>
            </div>
        </form>
    </div>
</body>
 
</html>