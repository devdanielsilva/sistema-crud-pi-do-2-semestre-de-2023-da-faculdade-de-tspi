<?php 
//Abaixo são as configuraçõpes do banco de dados.

/*$host é onde o nosso banco de dados está instalado ou remoto. Variável $host recebe = entre aspas simples 'localhost' que é o local onde está o banco de dados.*/
$server = '144.22.157.228';

/*$db - 'projeto' é o nome do seu projeto que vc criou no php myadmin. */
$db = 'Alpha';

/*$user é variável para o nome do usuário.*/
$user = 'A2';

/*Se for root padrão,  */
$pass = 'A2';

/*$charset é a variável do tipo de caractere.*/
$charset = 'utf8mb4';

/*$dsn ,diz que tipo de drive estamos usando para o sql. Esse nome muda de acordo com o tipo de banco de dados, o nome do drive muda. */
$pdo = new PDO('mysql:host=144.22.157.228;dbname=Alpha', 'Alpha' , 'Alpha'); //Colocando os nomes de variáveis é bom para facilitar o trabalho de ter que digitar tudo.
//É sempre o nome primeiro e depois o nome da variável.

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
//Tudo isso é para a criação da conexão do banco de dados através do pdo.
try { //try é para verificar se tem algum erro. Ele analisa se a instrução tem algum erro.

/*$pdo = new PDO($dsn, $user, $pass, $options); /*A variável $pdo é para criar classes de objetos, que nesse caso é o admin. E criar uma conexão com o banco de dados.*/
//Estamos instanciando classes, ou seja, criando 
// echo "Conexão com o banco de dados está funcionando!";
//O catch pega o erro e trata esse erro.
//O catch pega o erro e trata esse erro.
}catch (\PDOException $e){ //O erro vai ser capturado na variável $e
   /* echo "Erro ao tentar conectar com o banco de dados. <p>".$e; */
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
//Se não tiver erro, enviar mensagem.
 ?>