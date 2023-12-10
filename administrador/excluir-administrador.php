<?php
session_start();

if (!isset($_SESSION['admin_logado'])) {
    header('Location: login.php');
    exit();
}

require_once('../config/conexao.php');

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM PRODUTOS WHERE ID = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $mensagem = "Produto excluído com sucesso!";
        } else {
            $mensagem = "Erro ao excluir o produto. Tente novamente.";
        }
    } catch (PDOException $e) {
        $mensagem = "Erro: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Excluir Administrador</title>
    <link rel="stylesheet" href="assets/style_page/excluir-administrador.css">
</head>

<body>
    <section class="c">
        <div class="container-a">
            <img src="assets/img/estoque.png" alt="estoque-img">
            <div class="container-b">
                <h1>Excluir Administrador</h1>
                <p id="p1"> Essa Função ainda não está disponível </p>
                <!-- <p id="erro"> <?php echo $mensagem; ?> </p> -->
                <a href="listar_administrador.php" class="btn">Voltar Para Lista de Administradores</a>
            </div>
        </div>
    </section>
</body>

</html>