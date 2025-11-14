<?php
session_start();
require_once __DIR__ . '/db.php';

function respond($status, $message, $redirect = null) {
    $_SESSION['flash'] = ['status'=>$status,'message'=>$message];
    if($redirect){ header("Location: $redirect"); exit; }
    echo json_encode(['status'=>$status,'message'=>$message]); exit;
}

$action = $_POST['action'] ?? '';

if ($action === 'register') {
    $name = trim($_POST['name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    if (!$name || !$email || !$password)
        respond('error','Todos os campos são obrigatórios.','index.php');
    if (!filter_var($email,FILTER_VALIDATE_EMAIL))
        respond('error','Email inválido.','index.php');
    if ($password !== $password_confirm)
        respond('error','Senhas não conferem.','index.php');
    if (strlen($password) < 6)
        respond('error','Senha muito curta.','index.php');

    $stmt = $pdo->prepare("SELECT id FROM users WHERE email=? LIMIT 1");
    $stmt->execute([$email]);
    if($stmt->fetch())
        respond('error','Email já cadastrado.','index.php');

    $hash = password_hash($password,PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (name,email,password_hash) VALUES (?,?,?)");
    $stmt->execute([$name,$email,$hash]);

    session_regenerate_id(true);
    $_SESSION['user']=['id'=>$pdo->lastInsertId(),'name'=>$name,'email'=>$email];
    respond('success','Cadastro realizado!','dashboard.php');

} elseif ($action === 'login') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    if (!$email || !$password)
        respond('error','Preencha email e senha.','index.php');

    $stmt = $pdo->prepare("SELECT id,name,email,password_hash FROM users WHERE email=? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if(!$user || !password_verify($password,$user['password_hash']))
        respond('error','Email ou senha incorretos.','index.php');

    session_regenerate_id(true);
    $_SESSION['user']=['id'=>$user['id'],'name'=>$user['name'],'email'=>$user['email']];
    respond('success','Login realizado.','dashboard.php');

} else {
    respond('error','Ação inválida.','index.php');
}
