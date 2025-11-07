<?php
session_start();
if (!isset($_SESSION['logado']) || $_SESSION['nivel_usuario'] != 'usuario') {
    header("Location: login.php");
    exit;
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Painel do Usuário</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800&family=Fredoka:wght@400;600&display=swap" rel="stylesheet">
<style>
:root{
  --pet-primary: #ff6b9d;
  --pet-secondary: #4ecdc4;
  --pet-accent: #ffd93d;
  --pet-purple: #a78bfa;
  --pet-dark: #2d3748;
}

body { 
  font-family: 'Nunito', sans-serif;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #4facfe 75%, #00f2fe 100%);
  background-size: 400% 400%;
  animation: gradientShift 15s ease infinite;
  min-height: 100vh;
}

@keyframes gradientShift {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

.navbar { 
  background: linear-gradient(135deg, #4ecdc4 0%, #44a8a0 100%);
  box-shadow: 0 8px 32px rgba(78, 205, 196, 0.4);
  border-bottom: 3px solid rgba(255, 255, 255, 0.3);
}

.navbar a { 
  color: #fff !important;
  font-family: 'Fredoka', 'Nunito', sans-serif;
  text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
}

.card { 
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(20px);
  border: 2px solid rgba(255, 255, 255, 0.3);
  border-radius: 30px;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
  animation: cardEntrance 0.8s ease-out;
}

@keyframes cardEntrance {
  from { opacity: 0; transform: translateY(30px); }
  to { opacity: 1; transform: translateY(0); }
}

.btn-warning { 
  background: linear-gradient(135deg, #ffd93d 0%, #ffed4e 100%);
  border: none;
  color: var(--pet-dark);
  font-weight: 700;
  border-radius: 12px;
  padding: 10px 24px;
  box-shadow: 0 6px 20px rgba(255, 217, 61, 0.4);
  transition: all 0.3s ease;
}

.btn-warning:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(255, 217, 61, 0.5);
  background: linear-gradient(135deg, #ffc400 0%, #ffd93d 100%);
  color: var(--pet-dark);
}

h3 {
  color: transparent;
  background: linear-gradient(135deg, #4ecdc4 0%, #44a8a0 100%);
  background-clip: text;
  -webkit-background-clip: text;
  font-weight: 800;
  font-family: 'Fredoka', sans-serif;
}
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg mb-4">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="#">Painel do Usuário</a>
    <a href="logout.php" class="btn btn-warning">Sair</a>
  </div>
</nav>
<div class="container">
  <div class="card p-4">
    <h3>Olá, <?= $_SESSION['nome']; ?> 👋</h3>
    <p class="text-muted">Você está logado como <b>Usuário</b>.</p>
  </div>
</div>
</body>
</html>
