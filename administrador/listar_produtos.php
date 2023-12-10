<?php
session_start();
require_once('../config/conexao.php');
if (!isset($_SESSION['admin_logado'])) {
    header('Location: login.php');
   
    exit();
   
}
$sql2 = "SELECT * FROM PRODUTO p
    JOIN PRODUTO_IMAGEM pi
        ON p.PRODUTO_ID = pi.PRODUTO_ID
    JOIN CATEGORIA c
        ON p.CATEGORIA_ID = c.CATEGORIA_ID
    JOIN PRODUTO_ESTOQUE pe
        ON p.PRODUTO_ID = pe.PRODUTO_ID
    WHERE IMAGEM_ORDEM = 1
    ORDER BY p.PRODUTO_ID";
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute();
 
try{
    $stmt = $pdo->prepare("SELECT PRODUTO.*, CATEGORIA.CATEGORIA_NOME, PRODUTO_IMAGEM.IMAGEM_URL, PRODUTO_ESTOQUE.PRODUTO_QTD
                           FROM PRODUTO
                           JOIN CATEGORIA ON PRODUTO.CATEGORIA_ID = CATEGORIA.CATEGORIA_ID
                           LEFT JOIN PRODUTO_IMAGEM ON PRODUTO.PRODUTO_ID = PRODUTO_IMAGEM.PRODUTO_ID
                           LEFT JOIN PRODUTO_ESTOQUE ON PRODUTO.PRODUTO_ID = PRODUTO_ESTOQUE.PRODUTO_ID");
    $stmt->execute();
    $produto = $stmt->fetchAll(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    echo "Erro: ". $e->getMessage();
}
?>
 
<!DOCTYPE html>
<html lang="pt-br">
 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Produtos</title>
    <link rel="stylesheet" href="assets/style_page/listar_produtos.css">
</head>
 
<body>
    <h2>Lista de produtos</h2>
 
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Estoque do Produto</th>
                <th>Preço</th>
                <th>Desconto</th>
                <th>Categoria</th>
                <th>Ativo</th>
                <th>Imagem</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produto as $produto): ?>
                <tr>
                    <td><?php echo $produto['PRODUTO_ID']; ?></td>
                    <td><?php echo $produto['PRODUTO_NOME']; ?></td>
                    <td><?php echo $produto['PRODUTO_DESC']; ?></td>
                    <td><?php echo $produto['PRODUTO_QTD']; ?></td>
                    <td><?php echo $produto['PRODUTO_PRECO']; ?></td>
                    <td><?php echo $produto['PRODUTO_DESCONTO']; ?></td>
                    <td><?php echo $produto['CATEGORIA_NOME']; ?></td>
                    <td><?php echo ($produto['PRODUTO_ATIVO'] == 1 ? 'Sim' : 'Não'); ?></td>
                    <td><img src="<?php echo $produto['IMAGEM_URL']; ?>" style="max-width: 150px;" ></td>
       
                    <td>



                    
                    <a href="editar_produto.php?id=<?php echo $produto['PRODUTO_ID']; ?>"> <button onclick="return" class="action-btn">Editar</button></a>
 
                    <a href="excluir-produtos.php?id=<?php echo $produto['PRODUTO_ID']; ?>">
                        <button onclick="return" class="action-btn delete-btn" confirmarExclusao()>
                            Excluir
                        </button>
                    </a>
 
                    </td>
                </tr>


                
            <?php endforeach; ?>
        </tbody>
    </table>
 
    <div class="buttons">
        <div class="btn">
            <a href="painel_admin.php">Voltar ao Painel</a>    
        </div>
       
        <div class="btn">
            <a href="../administrador/cadastrar_produto.php">Cadastrar mais produtos</a>
        </div>
 
        <div class="btn">
            <a href="../administrador/login.php">Log Out</a>    
        </div>
    </div>
</body>
 
</html>