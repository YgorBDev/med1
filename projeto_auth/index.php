<?php
session_start();
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<!doctype html><html lang="pt-BR"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Login / Cadastro</title>
<style>
body{font-family:Arial;background:#f5f7fa;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0;}
.container{background:#fff;padding:24px;border-radius:8px;box-shadow:0 6px 20px rgba(0,0,0,.08);width:360px;}
h2{margin-top:0;}
.form-row{margin-bottom:12px;}
input{width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;}
button{width:100%;padding:10px;border:0;border-radius:6px;background:#2563eb;color:white;font-weight:600;}
.switch{text-align:center;margin-top:12px;font-size:14px;}
.flash{padding:10px;border-radius:6px;margin-bottom:12px;}
.flash.success{background:#ecfdf5;color:#065f46;border:1px solid #bbf7d0;}
.flash.error{background:#fee2e2;color:#7f1d1d;border:1px solid #fecaca;}
</style></head><body>
<div class="container">
<?php if($flash): ?>
<div class="flash <?=$flash['status']?>"><?=$flash['message']?></div>
<?php endif; ?>

<div id="login-form">
<h2>Entrar</h2>
<form method="post" action="auth_action.php">
<input type="hidden" name="action" value="login">
<div class="form-row"><input type="email" name="email" placeholder="Email" required></div>
<div class="form-row"><input type="password" name="password" placeholder="Senha" required></div>
<button type="submit">Entrar</button>
</form>
<div class="switch">Não tem conta? <a href="#" onclick="toggleForms();return false;">Cadastrar</a></div>
</div>

<div id="register-form" style="display:none;">
<h2>Cadastro</h2>
<form method="post" action="auth_action.php">
<input type="hidden" name="action" value="register">
<div class="form-row"><input type="text" name="name" placeholder="Nome" required></div>
<div class="form-row"><input type="email" name="email" placeholder="Email" required></div>
<div class="form-row"><input type="password" name="password" placeholder="Senha" required></div>
<div class="form-row"><input type="password" name="password_confirm" placeholder="Confirmar senha" required></div>
<button type="submit">Criar conta</button>
</form>
<div class="switch">Já tem conta? <a href="#" onclick="toggleForms();return false;">Entrar</a></div>
</div>
</div>
<script>
function toggleForms(){
document.getElementById('login-form').style.display =
document.getElementById('login-form').style.display==='none'?'block':'none';
document.getElementById('register-form').style.display =
document.getElementById('register-form').style.display==='none'?'block':'none';
}
</script>
</body></html>
