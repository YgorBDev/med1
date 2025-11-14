<?php
// Definindo a conexão com o banco de dados
$servidor = "localhost";  // ou o endereço do seu banco de dados
$usuario = "root";        // seu usuário do banco de dados
$senha = "root";              // sua senha do banco de dados
$banco = "clinica";       // nome do banco de dados

// Criando a conexão
$conn = mysqli_connect($servidor, $usuario, $senha, $banco);

// Verificando se a conexão foi estabelecida
if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}
?>
