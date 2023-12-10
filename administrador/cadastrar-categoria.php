<?php
   session_start();
   require_once('../config/conexao.php');
   
   if (!isset($_SESSION['admin_logado'])) {
       header("Location: login.php");
       exit();
   }
   
   // Verifica se o método é POST
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       // Certifique-se de que os campos estão definidos e não são nulos
       if (isset($_POST['CATEGORIA_NOME']) && isset($_POST['CATEGORIA_DESC'])) {
           $CATEGORIA_NOME = $_POST['CATEGORIA_NOME'];
           $CATEGORIA_DESC = $_POST['CATEGORIA_DESC'];
   
           // Adicione uma verificação para garantir que os valores não sejam nulos
           if (!empty($CATEGORIA_NOME)) {
               try {
                   $sql = "INSERT INTO CATEGORIA (CATEGORIA_NOME, CATEGORIA_DESC) VALUES (:CATEGORIA_NOME, :CATEGORIA_DESC)";
                   $smtp = $pdo->prepare($sql);
   
                   $smtp->bindParam(':CATEGORIA_NOME', $CATEGORIA_NOME, PDO::PARAM_STR);
                   $smtp->bindParam(':CATEGORIA_DESC', $CATEGORIA_DESC, PDO::PARAM_STR);
                   $smtp->execute();
       
        echo "<p style='color:green;'>Categoria cadastrada com sucesso!</p>";
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao cadastrar o produto: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p style='color:red;'>Erro: Nome da categoria não pode ser vazio!</p>";
}
} else {
echo "<p style='color:red;'>Erro: Campos de formulário não estão definidos!</p>";
}
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Administrador</title>
    <link rel="stylesheet" href="assets/style_page/cadastrar-categoria.css">
</head>

<body>
    <div class="main-adm">
        <div class="left-adm">
            <img src="assets/img/cadastrar-categoria.png" alt="imagem-do-categoria" class="left-adm-img">
        </div>

        <form class="right-adm" action="../administrador/cadastrar-categoria.php" method="post">
            <div class="card-adm">
                <h1>CADASTRAR CATEGORIA</h1>
                <form action="" method="post" enctype="multipart/form-data">
                    <label for="nome">Nome</label>
                    <input type="text" name="CATEGORIA_NOME" id="nome" required>

                    <label for="story">DESCRIÇÃO</label>
                    <textarea id="story" name="CATEGORIA_DESC" rows="5" cols="33"></textarea>
                    <a href="cadastrar_produto.php" class="btn" id="btn-voltar">Voltar para cadastrar produto</a>
                    <input type="submit" value="Cadastrar" class="cadastrar">
                </form>
            </div>

    </div>

</body>

</html>