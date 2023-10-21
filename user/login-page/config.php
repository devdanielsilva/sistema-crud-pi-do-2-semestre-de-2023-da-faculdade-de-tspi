<?php
    //Definindo os parametros do banco da dados local
    $dbHost = 'Localhost';
    $dbUsername = 'root';
    //Caso o banco de dados tenha senha, será necessário adcionar aqui
    $dbPassword = '';
    $dbName = 'piAlpha';

    $conexao = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);

    //if ($conexao->connect_errno) {
    //    echo "Erro";
    //} else {
    //    echo "Conexão efetuada com sucesso";
    //}

?>