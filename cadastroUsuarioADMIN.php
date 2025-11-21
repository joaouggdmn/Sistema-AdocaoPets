<?php
session_start();
require 'config.php';

// Verifica se o usuário está logado e é admin
if (!isset($_SESSION['logado']) || $_SESSION['nivel_usuario'] != 'admin') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = md5($_POST['senha']);
    $nivel = $_POST['nivel_usuario'];

    $sql = "INSERT INTO usuarios (nome_usuario, email_usuario, senha_usuario, nivel_usuario) VALUES ('$nome', '$email', '$senha', '$nivel')";
    if ($conn->query($sql)) {
        $_SESSION['sucesso'] = "Usuário cadastrado com sucesso!";
        header("Location: painelAdmin.php");
        exit;
    } else {
        $erro = "Erro ao cadastrar: " . $conn->error;
    }
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Cadastrar Usuário - Admin</title>           
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800&family=Fredoka:wght@400;600&display=swap" rel="stylesheet">
  <style>
    :root{
      --pet-primary: #FF6B6B;
      --pet-secondary: #4ECDC4;
      --pet-accent: #FFE66D;
      --pet-dark: #2d3748;
    }
    
    body {
      font-family: 'Nunito', sans-serif;
      background: linear-gradient(135deg, #ffeaea 0%, #ffd6d6 100%);
      min-height: 100vh;
      padding-top: 70px;
    }
    
    .navbar {
      background: linear-gradient(135deg, #FF6B6B 0%, #ff5252 100%);
      box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
      border-bottom: 2px solid rgba(255, 255, 255, 0.2);
    }
    
    .navbar a {
      color: #fff !important;
      font-family: 'Fredoka', 'Nunito', sans-serif;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }
    
    .card {
      background: white;
      border: none;
      border-radius: 20px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
    }
    
    h3 {
      color: var(--pet-primary);
      font-weight: 800;
      font-family: 'Fredoka', sans-serif;
    }
    
    .form-label {
      color: var(--pet-dark);
      font-weight: 700;
      font-size: 0.95rem;
      margin-bottom: 8px;
    }
    
    .form-control, .form-select {
      border: 2px solid #e2e8f0;
      border-radius: 12px;
      padding: 14px 18px;
      font-size: 1rem;
      transition: all 0.3s ease;
      background: white;
    }
    
    .form-control:focus, .form-select:focus {
      box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.2);
      border-color: var(--pet-primary);
      outline: none;
    }
    
    .btn-primary {
      background: linear-gradient(135deg, #FF6B6B 0%, #ff5252 100%);
      color: #fff;
      border: none;
      border-radius: 12px;
      padding: 16px 32px;
      font-weight: 700;
      font-size: 1.1rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      box-shadow: 0 6px 16px rgba(255, 107, 107, 0.3);
      transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
      background: linear-gradient(135deg, #ff5252 0%, #ff3838 100%);
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(255, 107, 107, 0.4);
    }
    
    .btn-secondary {
      background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
      border: none;
      border-radius: 12px;
      padding: 14px 28px;
      font-weight: 700;
      box-shadow: 0 4px 12px rgba(45, 55, 72, 0.3);
      transition: all 0.3s ease;
    }
    
    .btn-secondary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(45, 55, 72, 0.4);
    }
    
    .badge {
      padding: 8px 12px;
      border-radius: 8px;
      font-weight: 700;
      font-size: 0.85rem;
    }
    
    .alert {
      border-radius: 15px;
      border: none;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

<nav class="navbar fixed-top mb-4">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="painelAdmin.php">👑 Painel Admin</a>
    <div class="d-flex gap-2">
      <a href="painelAdmin.php" class="btn btn-light">← Voltar</a>
    </div>
  </div>
</nav>

<main class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
      <div class="card p-4">
        <h3 class="mb-3 text-center">👤 Cadastrar Novo Usuário</h3>
        <p class="text-center text-muted mb-4">Preencha os dados e escolha o nível de acesso do usuário.</p>

        <?php if(isset($erro)): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><?= $erro; ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        <?php endif; ?>

        <form method="POST" class="row g-3">
          <div class="col-12">
            <label class="form-label">📝 Nome Completo</label>
            <input type="text" name="nome" class="form-control" placeholder="Nome do usuário" required>
          </div>

          <div class="col-12">
            <label class="form-label">📧 E-mail</label>
            <input type="email" name="email" class="form-control" placeholder="email@exemplo.com" required>
          </div>

          <div class="col-12">
            <label class="form-label">🔒 Senha</label>
            <input type="password" name="senha" class="form-control" placeholder="Crie uma senha segura" required>
          </div>

          <div class="col-12">
            <label class="form-label">👥 Nível de Acesso</label>
            <select name="nivel_usuario" class="form-select" required>
              <option value="" selected disabled>Selecione o nível...</option>
              <option value="usuario">👤 Usuário Padrão</option>
              <option value="admin">👑 Administrador</option>
            </select>
            <small class="text-muted d-block mt-2">
              <strong>Usuário Padrão:</strong> Pode cadastrar e gerenciar seus próprios animais.<br>
              <strong>Administrador:</strong> Tem acesso total ao sistema, incluindo gerenciamento de usuários.
            </small>
          </div>

          <div class="col-12 d-flex gap-2 mt-4">
            <a href="painelAdmin.php" class="btn btn-secondary flex-fill">Cancelar</a>
            <button type="submit" class="btn btn-primary flex-fill">✅ Cadastrar Usuário</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
