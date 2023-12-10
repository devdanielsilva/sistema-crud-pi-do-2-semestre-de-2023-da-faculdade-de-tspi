<?php
// Inicia a sessão para gerenciamento do usuário.
session_start();

// Importa a configuração de conexão com o banco de dados.
require_once('../config/conexao.php');

// Verifica se o administrador está logado.
if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}

// Bloco de consulta para buscar categorias.
try {
    $stmt_categoria = $pdo->prepare("SELECT * FROM CATEGORIA");
    $stmt_categoria->execute();
    $categorias = $stmt_categoria->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p style='color:red;'>Erro ao buscar categorias: " . $e->getMessage() . "</p>";
}

// Bloco que será executado quando o formulário for submetido.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pegando os valores do POST.
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $estoque = $_POST['estoque'];
    $preco = $_POST['preco'];
    $categoria_id = $_POST['categoria_id'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;
    $desconto = $_POST['desconto'];
    $imagens = $_POST['imagem_url'];

    // Inserindo produto no banco.
    try {
        $sql_produto = "INSERT INTO PRODUTO (PRODUTO_NOME, PRODUTO_DESC, PRODUTO_PRECO, CATEGORIA_ID, PRODUTO_ATIVO, PRODUTO_DESCONTO) VALUES (:nome, :descricao, :preco, :categoria_id, :ativo, :desconto)";
        $stmt_produto = $pdo->prepare($sql_produto);
        $stmt_produto->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt_produto->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt_produto->bindParam(':preco', $preco, PDO::PARAM_STR);
        $stmt_produto->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
        $stmt_produto->bindParam(':ativo', $ativo, PDO::PARAM_INT);
        $stmt_produto->bindParam(':desconto', $desconto, PDO::PARAM_STR);
        $stmt_produto->execute();

        // Pegando o ID do produto inserido.
        // Pegando o ID do produto inserido.
        $produto_id = $pdo->lastInsertId();

        // Inserindo Estoque do produto no banco.
        $sql_estoque = "INSERT INTO PRODUTO_ESTOQUE (PRODUTO_ID, PRODUTO_QTD) VALUES (:produto_id, :estoque)";
        $stmt_estoque = $pdo->prepare($sql_estoque);
        $stmt_estoque->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
        $stmt_estoque->bindParam(':estoque', $estoque, PDO::PARAM_INT);
        $stmt_estoque->execute();

        // Inserindo imagens no banco.
        foreach ($imagens as $ordem => $url_imagem) {
            $sql_imagem = "INSERT INTO PRODUTO_IMAGEM (IMAGEM_URL, PRODUTO_ID, IMAGEM_ORDEM) VALUES (:url_imagem, :produto_id, :ordem_imagem)";
            $stmt_imagem = $pdo->prepare($sql_imagem);
            $stmt_imagem->bindParam(':url_imagem', $url_imagem, PDO::PARAM_STR);
            $stmt_imagem->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
            $stmt_imagem->bindParam(':ordem_imagem', $ordem, PDO::PARAM_INT);
            $stmt_imagem->execute();
        }

        echo "<p style='color:green;'>Produto cadastrado com sucesso!</p>";
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao cadastrar produto: " . $e->getMessage() . "</p>";
    }
}
?>

<!-- Início do código HTML -->
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastro de Produto</title>
    <link rel="stylesheet" href="assets/style_page/cadastrar_produto.css">
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
            <h1>Cadastrar Produto</h1>
            <img src="../administrador/img/Logo darkmode.png" alt="logo">
            <form action="" method="post" enctype="multipart/form-data">
                <!-- Campos do formulário para inserir informações do produto -->

                <div class="input-row">

                    <div class="input-colum">
                        <label for="nome">Nome:</label>
                        <input type="text" name="nome" id="nome" required>
                    </div>

                    <p>
                    <div class="input-colum">
                        <label for="descricao">Descrição:</label>
                        <textarea name="descricao" id="descricao" required></textarea>
                    </div>
                    <p>

                    <p>
                    <div class="input-colum">
                        <label for="estoque">Estoque do Produto:</label>
                        <textarea name="estoque" id="estoque" required></textarea>
                    </div>
                    <p>

                    <div class="input-colum">
                        <label for="categoria_id">Categoria:</label>
                        <select name="categoria_id" id="categoria_id" required>
                            <?php
                            // Loop para preencher o dropdown de categorias.
                            foreach ($categorias as $categoria) :
                            ?>


                                <option value="<?= $categoria['CATEGORIA_ID'] ?>"><?= $categoria['CATEGORIA_NOME'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="input-colum">
                        <label for="ativo">Ativo:</label>
                        <input type="checkbox" name="ativo" id="ativo" value="1" checked>
                        <a href="painel_admin.php" id="painel">Painel Admin</a>

                        <a href="listar_produtos.php" id="painel">
                            Lista de Produtos
                        </a>
                    </div>

                </div>

                <p>

                <div class="input-row">

                    <div class="input-colum">
                        <label for="preco">Preço:</label>
                        <input type="number" name="preco" id="preco" step="0.01" required>
                    </div>
                    <p>
                    <div class="input-colum">
                        <label for="desconto">Desconto:</label>
                        <input type="number" name="desconto" id="desconto" step="0.01" required>
                    </div>


                    <p>
                    <p>
                    <div class="input-colum">
                        <!-- Área para adicionar URLs de imagens. -->
                        <label for="imagem">Imagem URL:</label>

                        <div id="containerImagens">
                            <input type="text" name="imagem_url[]" required>
                        </div>
                        <button type="button" onclick="adicionarImagem()">Adicionar mais imagens</button>

                        <button type="submit" class="atualizar">Cadastrar Produto</button>


                    </div>
                </div>
            </form>
        </section>
    </main>
</body>

</html>