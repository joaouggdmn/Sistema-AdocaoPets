<?php
session_start();
require 'config.php';

if (!isset($_SESSION['logado']) || $_SESSION['nivel_usuario'] != 'admin') {
    header("Location: login.php");
    exit;
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Painel do Administrador</title>
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
  background: linear-gradient(135deg, #ff6b9d 0%, #ff8fab 100%);
  box-shadow: 0 8px 32px rgba(255, 107, 157, 0.4);
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

.btn-light { 
  background: rgba(255, 255, 255, 0.9);
  border: 2px solid rgba(255, 255, 255, 0.5);
  color: var(--pet-dark);
  font-weight: 700;
  border-radius: 12px;
  padding: 10px 24px;
  transition: all 0.3s ease;
}

.btn-light:hover {
  background: white;
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(255, 255, 255, 0.3);
}

.btn-dark { 
  background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
  border: none;
  font-weight: 700;
  border-radius: 12px;
  padding: 10px 24px;
  box-shadow: 0 6px 20px rgba(45, 55, 72, 0.4);
  transition: all 0.3s ease;
}

.btn-dark:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(45, 55, 72, 0.5);
}

h3 {
  color: transparent;
  background: linear-gradient(135deg, #ff6b9d 0%, #a78bfa 100%);
  background-clip: text;
  -webkit-background-clip: text;
  font-weight: 800;
  font-family: 'Fredoka', sans-serif;
}

.table {
  background: white;
  border-radius: 20px;
  overflow: hidden;
}

.table thead {
  background: linear-gradient(135deg, #ffd93d 0%, #ffed4e 100%);
}

.table thead th {
  font-weight: 800;
  color: var(--pet-dark);
  padding: 18px 15px;
  border: none;
}

.table tbody tr {
  transition: all 0.3s ease;
}

.table tbody tr:hover {
  background: linear-gradient(90deg, rgba(255, 107, 157, 0.08) 0%, rgba(167, 139, 250, 0.08) 100%);
  transform: scale(1.01);
}
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg mb-4">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="#">Painel Admin</a>
    <div class="d-flex">
      <a href="cadastro.php" class="btn btn-light me-2">Cadastrar Usuário</a>
      <a href="logout.php" class="btn btn-dark">Sair</a>
    </div>
  </div>
</nav>
<div class="container">
  <div class="card p-4 mb-4">
    <h3>Bem-vindo, <?= $_SESSION['nome']; ?> 👑</h3>
    <p class="text-muted">Você está logado como <b>Administrador</b>.</p>
  </div>

  <div class="card p-4">
    <h4 class="mb-4" style="color: var(--pet-dark); font-weight: 700;">📋 Gerenciar Usuários</h4>
    <table class="table table-striped table-bordered align-middle mb-0">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Nome</th>
          <th scope="col">Email</th>
          <th scope="col">Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $sql = "SELECT * FROM usuarios ORDER BY id_usuario ASC";
          $result = $conn->query($sql);
          if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
              echo "<tr>
                      <td>{$row['id_usuario']}</td>
                      <td>{$row['nome_usuario']}</td>
                      <td>{$row['email_usuario']}</td>
                      <td>
                        <a href='editar.php?id={$row['id_usuario']}' class='btn btn-sm btn-warning'>EDITAR</a>
                        <a href='excluir.php?id={$row['id_usuario']}' class='btn btn-sm btn-danger'>EXCLUIR</a>
                      </td>
                    </tr>";
            }
          } else {
            echo "<tr><td colspan='4' class='text-center'>NENHUM USUÁRIO CADASTRADO</td></tr>";
          }
        ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
