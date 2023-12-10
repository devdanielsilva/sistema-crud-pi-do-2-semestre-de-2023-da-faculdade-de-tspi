<?php
session_start();
require_once('../config/conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}

$produto_id = $_GET['id'];

// Busca as informações do produto.
$stmt_produto = $pdo->prepare("SELECT * FROM PRODUTO WHERE PRODUTO_ID = :produto_id");
$stmt_produto->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
$stmt_produto->execute();
$produto = $stmt_produto->fetch(PDO::FETCH_ASSOC);

// Busca as categorias.
$stmt_categoria = $pdo->prepare("SELECT * FROM CATEGORIA");
$stmt_categoria->execute();
$categorias = $stmt_categoria->fetchAll(PDO::FETCH_ASSOC);

// Busca as imagens do produto.
$stmt_img = $pdo->prepare("SELECT * FROM PRODUTO_IMAGEM WHERE PRODUTO_ID = :produto_id ORDER BY IMAGEM_ORDEM");
$stmt_img->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
$stmt_img->execute();
$imagens_existentes = $stmt_img->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Atualizando as URLs das imagens.
    if (isset($_POST['editar_imagem_url'])) {
        foreach ($_POST['editar_imagem_url'] as $imagem_id => $url_editada) {
            $stmt_update = $pdo->prepare("UPDATE PRODUTO_IMAGEM SET IMAGEM_URL = :url WHERE IMAGEM_ID = :imagem_id");
            $stmt_update->bindParam(':url', $url_editada, PDO::PARAM_STR);
            $stmt_update->bindParam(':imagem_id', $imagem_id, PDO::PARAM_INT);
            $stmt_update->execute();
        }
    }

    // Atualizando as informações do produto.
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $categoria_id = $_POST['categoria_id'];
    $ativo = isset($_POST['ativo']) ? "\x01" : "\x00";
    $desconto = $_POST['desconto'];
    $estoque = $_POST['estoque'];

    try {
        $stmt_update_produto = $pdo->prepare("UPDATE PRODUTO SET PRODUTO_NOME = :nome, PRODUTO_DESC = :descricao, PRODUTO_PRECO = :preco, CATEGORIA_ID = :categoria_id, PRODUTO_ATIVO = :ativo, PRODUTO_DESCONTO = :desconto WHERE PRODUTO_ID = :produto_id");
        $stmt_update_produto->bindParam(':nome', $nome);
        $stmt_update_produto->bindParam(':descricao', $descricao);
        $stmt_update_produto->bindParam(':preco', $preco);
        $stmt_update_produto->bindParam(':categoria_id', $categoria_id);
        $stmt_update_produto->bindParam(':ativo', $ativo);
        $stmt_update_produto->bindParam(':desconto', $desconto);
        $stmt_update_produto->bindParam(':produto_id', $produto_id);
        $stmt_update_produto->execute();

        $stmt_update_produto = $pdo->prepare("UPDATE PRODUTO SET PRODUTO_NOME = :nome, PRODUTO_DESC = :descricao, PRODUTO_PRECO = :preco, CATEGORIA_ID = :categoria_id, PRODUTO_ATIVO = :ativo, PRODUTO_DESCONTO = :desconto WHERE PRODUTO_ID = :produto_id");
        // ... (código existente)

        // Inserindo/atualizando informações na tabela PRODUTO_ESTOQUE.
        $sql_estoque = "INSERT INTO PRODUTO_ESTOQUE (PRODUTO_ID, PRODUTO_QTD) VALUES (:produto_id, :estoque) ON DUPLICATE KEY UPDATE PRODUTO_QTD = :estoque";
        $estoque = $_POST['estoque']; // Adicionado para corrigir o erro

        $stmt_estoque = $pdo->prepare($sql_estoque);
        $stmt_estoque->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
        $stmt_estoque->bindParam(':estoque', $estoque, PDO::PARAM_INT);
        $stmt_estoque->execute();

        echo "<p style='color:green;'>Produto atualizado com sucesso!</p>";
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao atualizar produto: " . $e->getMessage() . "</p>";
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="assets/style_page/editar_produto.css">
    <script>
        // Adiciona um novo campo de imagem URL.
        function adicionarImagem() {
            const containerImagens = document.getElementById('containerImagens');
            const novoInput = document.createElement('input');
            novoInput.type = 'text';
            novoInput.name = 'imagem_url[]';
            containerImagens.appendChild(novoInput);
        }
    </script>
</head>

<body>
    <main>
        <section class="card-edit-product">
            <h1>Editar Produto</h1>

            <img src="../administrador/img/Logo darkmode.png" alt="logo">
            <form action="" method="post" enctype="multipart/form-data">


                <div class="input-row">
                    <div class="input-colum">
                        <label for="nome">Nome:</label>
                        <input type="text" name="nome" id="nome" value="<?= $produto['PRODUTO_NOME'] ?>" required>
                    </div>
                    <p>
                    <div class="input-colum">
                        <label for="descricao">Descrição:</label>
                        <textarea name="descricao" id="descricao" required><?= $produto['PRODUTO_DESC'] ?></textarea>
                    </div>
                    </p>
                    <div class="input-row">
                        <label for="estoque">Quantidade em Estoque:</label>
                        <input type="number" name="estoque" id="estoque" value='<?= $produto['PRODUTO_QTD'] ?>'>
                    </div>

                    <div class="input-colum">
                        <label for="preco">Preço</label>
                        <input type="number" name="preco" id="preco" step="0.01" value="<?= $produto['PRODUTO_PRECO'] ?>" required>
                    </div>
                    <div class="input-colum">
                        <label for="desconto">Desconto</label>
                        <input type="number" name="desconto" id="desconto" step="0.01" value="<?= $produto['PRODUTO_DESCONTO'] ?>" required>
                    </div>
                    <div class="input-colum">
                        <p><label for="categoria_id">Categoria</label></p>
                        <select name="categoria_id" id="categoria_id" required>
                            <?php
                            foreach ($categorias as $categoria) :
                                $selected = $produto['CATEGORIA_ID'] == $categoria['CATEGORIA_ID'] ? 'selected' : '';
                            ?>
                                <option value="<?= $categoria['CATEGORIA_ID'] ?>" <?= $selected ?>>
                                    <?= $categoria['CATEGORIA_NOME'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="input-row">
                    <label for="ativo">Ativo</label>
                    <input type="checkbox" name="ativo" id="ativo" value="1" <?= isset($produto['PRODUTO_ATIVO']) && $produto['PRODUTO_ATIVO'] == 1 ? 'checked' : '' ?>>

                    <div id="containerImagens">
                        <p>
                            <!-- Lista de imagens existentes -->
                            <?php
                            foreach ($imagens_existentes as $imagem) {
                                echo '<div>';
                                echo '<label>URL da Imagem:</label>';
                                echo '<input type="text" name="editar_imagem_url[' . $imagem['IMAGEM_ID'] . ']" value="' . $imagem['IMAGEM_URL'] . '">';
                                echo '</div>';
                            }
                            ?>
                        </p>
                    </div>
                    <p>
                        <button type="button" onclick="adicionarImagem()">Adicionar mais imagens</button>
                    </p>
                    <p>
                        <button class="buttons" type="submit">Atualizar Produto</button>
                </div>
            </form>
            <p>
                <a href="listar_produtos.php" class="btn">Lista de Produtos</a>
                <a href="painel_admin.php" class="btn">Painel Admin</a>
            </p>
        </section>
    </main>
</body>

</html>