<?php
session_start();
require '../config.php';

// Verifica se o usuário está logado e é admin
if (!isset($_SESSION['logado']) || $_SESSION['nivel_usuario'] != 'admin') {
    header("Location: ../index.php#login-section");
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
  <link href="../css/forms.css" rel="stylesheet">
  <style>
    body {
      padding-top: 70px;
    }
    
    .navbar a {
      color: #fff !important;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
      transition: transform 0.3s ease;
    }

    .navbar a:hover {
      transform: translateY(-2px);
    }
    
    .badge {
      padding: 8px 12px;
      border-radius: 8px;
      font-weight: 700;
      font-size: 0.85rem;
    }
  </style>
</head>
<body class="admin-context">

<main class="container mt-1">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-8">
      <div class="card-pet">
        <div class="text-center mb-4">
          <h3 class="mb-3 section-title">👤 Cadastrar Novo Usuário</h3>
          <p class="text-muted">Preencha os dados e escolha o nível de acesso do usuário.</p>
        </div>

        <?php if(isset($erro)): ?>
          <div class="alert alert-danger">
            <?= $erro; ?>
          </div>
        <?php endif; ?>

        <form method="POST" class="row g-3 mt-2 t-2">
          <div class="col-md-12">
            <label class="form-label">Nome Completo</label>
            <input type="text" name="nome" class="form-control" placeholder="Nome do usuário" required>
          </div>

          <div class="col-md-12">
            <label class="form-label">E-mail</label>
            <input type="email" name="email" class="form-control" placeholder="email@exemplo.com" required>
          </div>

          <div class="col-md-12">
            <label class="form-label">Senha</label>
            <input type="password" name="senha" class="form-control" placeholder="Crie uma senha segura" required>
          </div>

          <div class="col-md-12">
            <label class="form-label">Nível de Acesso</label>
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

          <div class="col-12 d-grid gap-2 d-md-flex justify-content-md-end mt-4">
            <a href="painelAdmin.php" class="btn btn-secondary">
              ← Cancelar
            </a>
            <button type="submit" class="btn btn-primary">
              💾 Cadastrar Usuário
            </button>
          </div>
        </form>

      </div>
    </div>
  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
