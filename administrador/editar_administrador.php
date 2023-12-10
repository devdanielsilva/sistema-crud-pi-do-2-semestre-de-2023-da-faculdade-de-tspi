<?php
session_start();
require_once('../config/conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}

$adm_id = $_GET['id'];

// Busca as informações do administrador.
$stmt_adm = $pdo->prepare("SELECT * FROM ADMINISTRADOR WHERE ADM_ID = :adm_id");
$stmt_adm->bindParam(':adm_id', $adm_id, PDO::PARAM_INT);
$stmt_adm->execute();
$adm = $stmt_adm->fetch(PDO::FETCH_ASSOC);




if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Atualizando as informações do administrador.
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    try {
        $stmt_update_adm = $pdo->prepare("UPDATE ADMINISTRADOR SET ADM_NOME = :nome, ADM_EMAIL = :email, ADM_SENHA = :senha,  ADM_ATIVO = :ativo  WHERE ADM_ID = :adm_id");

        $stmt_update_adm->bindParam(':nome', $nome);
        $stmt_update_adm->bindParam(':email', $email);
        $stmt_update_adm->bindParam(':senha', $senha);
        $stmt_update_adm->bindParam(':ativo', $ativo);
        $stmt_update_adm->bindParam(':adm_id', $adm_id);
        $stmt_update_adm->execute();

        echo "<p style='color:green;'>Administrador atualizado com sucesso!</p>";
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao atualizar administrador: " . $e->getMessage() . "</p>";
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Administrador</title>
    <link rel="stylesheet" href="assets/style_page/editar-administrador.css">
    <link rel="stylesheet" href="assets/global.css">
</head>

<body>

    <div class="main-adm">
        <div class="left-adm">
            <img src="assets/img/cadastro-admin.png" alt="imagem-do-painel-do-admin" class="left-adm-img">
        </div>

        <form class="right-adm" action="" method="post" enctype="multipart/form-data">
            <div class="card-adm">
                <h1>Editar Administrador</h1>
                <form action="" method="post" enctype="multipart/form-data">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" id="nome" value="<?= $adm['ADM_NOME'] ?>" required>
                    <label for="email">Email:</label>
                    <input type="text" name="email" id="email" value=" <?= $adm['ADM_EMAIL'] ?>" required>
                    <label for="senha">Senha:</label>
                    <input type="text" name="senha" id="senha" value=" <?= $adm['ADM_SENHA'] ?>" required>
                    <label for="ativo">Ativo:</label>
                    <input type="checkbox" name="ativo" id="ativo" value="1" <?= $adm['ADM_ATIVO'] ? 'checked' : '' ?>>
                    <button class="btn" type="submit">Atualizar Administrador</button>
                </form>

                <a href="listar_administrador.php" class="btn">Lista de Administrador</a>
            </div>
        </form>
    </div>
</body>

</html>