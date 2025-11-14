<?php
session_start();
if (empty($_SESSION['user'])) { header('Location: index.php'); exit; }
$user = $_SESSION['user'];
?>
<!doctype html><html><head><meta charset="utf-8"><title>Painel</title></head>
<body>
<h1>Olá, <?=$user['name']?></h1>
<p>Email: <?=$user['email']?></p>
<a href="logout.php">Sair</a>
</body></html>
