<?php
session_start(); // Inicia a sessão

// Tenta conectar com o banco e fazer o login
try {
    require_once('../config/conexao.php'); // Inclui o arquivo de configuração da conexão

    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM ADMINISTRADOR WHERE ADM_NOME = :nome AND ADM_SENHA = :senha AND ADM_ATIVO = 1"; 
    $query = $pdo->prepare($sql); //$query é um objeto PDOStatement que é criado ao preparar a consulta SQL  usando $pdo->prepare($sql). Um PDOStatement é um objeto em PHP que representa uma declaração SQL preparada. Esse objeto é usado em conjunto com a extensão PDO (PHP Data Objects) para executar consultas SQL no banco de dados de forma segura e eficiente. Essa preparação é feita para evitar injeção de SQL, que é uma ameaça comum à segurança dos aplicativos web

    //podemos vincular valores a esses espaços reservados usando o método bindParam ou bindValue. Isso permite que forneçamos dados específicos para a consulta antes de executá-la
    $query->bindParam(':nome', $nome, PDO::PARAM_STR); 
    $query->bindParam(':senha', $senha, PDO::PARAM_STR);
    $query->execute(); // Esta linha efetivamente executa a consulta SQL preparada. Após preparar a consulta e vincular os parâmetros, podemos executá-la usando o método execute(). Isso enviará a consulta ao banco de dados com os valores vinculados e, em seguida, podemos recuperar os resultados, se houver, usando métodos como fetch(), fetchAll(), etc.

    //rowCount() é um método de um objeto PDOStatement que é criado ao preparar a consulta SQL usando $pdo->prepare($sql); Ele retorna o número de linhas retornadas pela consulta SELECT
    if ($query->rowCount() > 0) { // verifica se a consulta SELECT encontrou pelo menos uma linha correspondente no banco de dados
        $_SESSION['admin_logado'] = true; //Se houver pelo menos uma linha, ele define a variável de sessão $_SESSION['admin_logado'] como true e redireciona o usuário para a página painel_admin.php
        header('Location: painel_admin.php'); 
        exit; // Adicionado para encerrar o script após o redirecionamento
    } else {
        $_SESSION['mensagem_erro'] = "NOME DE USUÁRIO OU SENHA INCORRETO";
        header('Location: login.php?erro');
        exit; // Adicionado para encerrar o script após o redirecionamento
    }
} catch (Exception $e) {
    // Armazena a mensagem de erro na sessão
    $_SESSION['mensagem_erro'] = "Erro de conexão: " . $e->getMessage();
    header('Location: login.php?erro');
    exit; // Adicionado para encerrar o script após o redirecionamento
}
//

?>