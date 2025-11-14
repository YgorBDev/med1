<?php
// Habilita a exibição de erros na página
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Inclui a conexão com o banco
require_once '../php/Conexao.php';  // Certifique-se de que $conn está sendo definido aqui

// Dados do novo usuário
$nome = 'admin';
$senha_plana = '123';
$email = 'admin@gmail.com';

// Gerar hash seguro da senha
$senha_hash = password_hash($senha_plana, PASSWORD_DEFAULT);

// Verificar se o usuário já existe
$sql_verifica = "SELECT * FROM usuario WHERE nome = ?";
$stmt_verifica = mysqli_prepare($conn, $sql_verifica);  // Usando $conn em vez de $Conexao

// Verificando se a preparação da consulta foi bem-sucedida
if ($stmt_verifica === false) {
    die("Erro na preparação da consulta de verificação: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt_verifica, "s", $nome);
mysqli_stmt_execute($stmt_verifica);
mysqli_stmt_store_result($stmt_verifica);

if (mysqli_stmt_num_rows($stmt_verifica) > 0) {
    echo "O usuário já existe.";
} else {
    // Inserir novo usuário
    $sql = "INSERT INTO usuario (nome, senha) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);  // Usando $conn em vez de $conexao
    
    // Verificando se a preparação da consulta foi bem-sucedida
    if ($stmt === false) {
        die("Erro na preparação da consulta de inserção: " . mysqli_error($conn));
    }
    
    mysqli_stmt_bind_param($stmt, "ss", $nome, $senha_hash);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "Usuário criado com sucesso!";
    } else {
        echo "Erro ao criar usuário: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
}

// Fechar a conexão
mysqli_stmt_close($stmt_verifica);
mysqli_close($conn);  // Fechando a conexão corretamente
?>
