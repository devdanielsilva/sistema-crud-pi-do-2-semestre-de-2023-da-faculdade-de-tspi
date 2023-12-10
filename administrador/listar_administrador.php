<?php
session_start();
require_once('../config/conexao.php');
 
if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}
$administradores = []; // Inicializa como array vazio
 
try {
    $stmt = $pdo->prepare("SELECT ADMINISTRADOR.*  FROM ADMINISTRADOR");
    $stmt->execute();
    $administradores = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p style='color:red;'>Erro ao listar administradores: " . $e->getMessage() . "</p>";
}
?>
 
<!DOCTYPE html>
<html lang="pt-br">
 
<head>
    <meta charset="UTF-8">
    <title>Listar Administradores</title>
    <link rel="stylesheet" href="assets/style_page/listar_administrador.css">
    <link rel="stylesheet" href="assets/global.css">
</head>
 
<body>
    <h2>Lista de Administradores</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Senha</th>
            <th>Ativo</th>
            <th>Ações</th>
            <!-- <th>Imagem</th> -->
        </tr>
        <?php foreach ($administradores as $adm) : ?>
            <tr>
                <td><?php echo $adm['ADM_ID']; ?></td>
                <td><?php echo $adm['ADM_NOME']; ?></td>
                <td><?php echo $adm['ADM_EMAIL']; ?></td>
                <td><?php echo $adm['ADM_SENHA']; ?></td>
                <td><?php echo ($adm['ADM_ATIVO'] == 1 ? 'Sim' : 'Não'); ?></td>
 
                <td>
                    <a href="editar_administrador.php?id=<?php echo $adm['ADM_ID']; ?>" class="action-btn">Editar</a>
                    <a href="excluir-administrador.php?id=<?php echo $adm['ADM_ID']; ?>" class="action-btn delete-btn">Excluir</a>
                </td>
            </tr>
 
        <?php endforeach; ?>
    </table>
    <p></p>
    <div class="buttons">
        <a href="painel_admin.php"><button class="btn">Voltar ao Painel do Administrador</button></a>
        <a href="cadastrar_administrador.php"><button class="btn">Cadastrar Administrador</button></a>
        <a href="../administrador/login.php"><button class="btn">Log Out</button></a>
    </div>
</body>
 
</html>