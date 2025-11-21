<?php
session_start();
require 'config.php';

// Verifica se é admin
if (!isset($_SESSION['logado']) || $_SESSION['nivel_usuario'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Verifica se o ID foi passado
if(!isset($_GET['id']) || empty($_GET['id'])){
    $_SESSION['erro'] = "❌ Usuário não encontrado!";
    header("Location: painelAdmin.php");
    exit;
}

$id_usuario = $_GET['id'];

// Busca os dados do usuário
$sql = "SELECT * FROM usuarios WHERE id_usuario = $id_usuario";
$result = $conn->query($sql);

if($result->num_rows == 0){
    $_SESSION['erro'] = "❌ Usuário não encontrado!";
    header("Location: painelAdmin.php");
    exit;
}

$usuario = $result->fetch_assoc();

// Se o formulário foi enviado (POST)
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $nivel = $_POST['nivel'];
    
    // Verifica se a senha foi preenchida
    if(!empty($_POST['senha'])){
        $senha = md5($_POST['senha']);
        $sql_update = "UPDATE usuarios SET nome_usuario = '$nome', email_usuario = '$email', senha_usuario = '$senha', nivel_usuario = '$nivel' WHERE id_usuario = $id_usuario";
    } else {
        $sql_update = "UPDATE usuarios SET nome_usuario = '$nome', email_usuario = '$email', nivel_usuario = '$nivel' WHERE id_usuario = $id_usuario";
    }
    
    if($conn->query($sql_update) === TRUE){
        $_SESSION['sucesso'] = "✅ Usuário atualizado com sucesso!";
        header("Location: painelAdmin.php");
        exit;
    } else {
        $_SESSION['erro'] = "❌ Erro ao atualizar: " . $conn->error;
    }
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Editar Usuário - Admin</title>
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
      padding-bottom: 40px;
    }
    
    .navbar {
      background: linear-gradient(135deg, #FF6B6B 0%, #ff5252 100%);
      box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
      border-bottom: 2px solid rgba(255, 255, 255, 0.2);
    }
    
    .navbar .navbar-brand{ 
      color:#fff !important; 
      font-family: 'Fredoka', 'Nunito', sans-serif;
      font-size: 1.5rem;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
      transition: transform 0.3s ease;
    }
    
    .navbar .navbar-brand:hover {
      transform: translateY(-2px);
    }
    
    .card-pet{
      background: white;
      border-radius: 20px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
      padding: 40px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card-pet:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
    }
    
    h3.section-title{ 
      color: var(--pet-primary);
      font-weight: 800;
      font-family: 'Fredoka', 'Nunito', sans-serif;
      font-size: 2.2rem;
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
    
    .form-control:focus, .form-select:focus{ 
      box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.2);
      border-color: var(--pet-primary);
      outline: none;
    }
    
    .btn-custom {
      background: linear-gradient(135deg, #FF6B6B 0%, #ff5252 100%);
      color: #fff;
      border: none;
      border-radius: 12px;
      padding: 16px 32px;
      font-weight: 700;
      font-size: 1.1rem;
      transition: all 0.3s ease;
      box-shadow: 0 6px 16px rgba(255, 107, 107, 0.3);
    }
    
    .btn-custom:hover{ 
      background: linear-gradient(135deg, #ff5252 0%, #ff3838 100%);
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(255, 107, 107, 0.4);
    }
    
    .btn-secondary {
      background: #6c757d;
      border: none;
      border-radius: 12px;
      padding: 16px 32px;
      font-weight: 700;
      font-size: 1.1rem;
      color: white;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
    }
    
    .btn-secondary:hover {
      background: #5a6268;
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(108, 117, 125, 0.4);
    }

    .alert {
      border-radius: 15px;
      border: none;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      font-weight: 600;
    }
    
    .alert-danger {
      background: linear-gradient(135deg, #FF6B6B 0%, #ff5252 100%);
      color: white;
    }

    .badge {
      padding: 8px 16px;
      border-radius: 10px;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
  <div class="container-fluid px-4">
    <a href="painelAdmin.php" class="navbar-brand fw-bold"><span style="font-size:1.8rem;">👤</span> Editar Usuário</a>
  </div>
</nav>

<main class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-8">
      <div class="card-pet">
        <div class="text-center mb-4">
          <h3 class="mb-3 section-title">✏️ Editar Usuário</h3>
          <p class="text-muted">Editando: <strong><?= $usuario['nome_usuario'] ?></strong></p>
          <span class="badge <?= $usuario['nivel_usuario'] == 'admin' ? 'bg-danger' : 'bg-primary' ?>">
            <?= $usuario['nivel_usuario'] == 'admin' ? '👑 Administrador' : '👤 Usuário' ?>
          </span>
        </div>

        <?php if(isset($_SESSION['erro'])): ?>
          <div class="alert alert-danger">
            <?= $_SESSION['erro']; unset($_SESSION['erro']); ?>
          </div>
        <?php endif; ?>

        <form method="POST" class="row g-3 mt-2">
          
          <div class="col-md-12">
            <label class="form-label">Nome Completo</label>
            <input type="text" name="nome" class="form-control" value="<?= $usuario['nome_usuario'] ?>" required>
          </div>

          <div class="col-md-12">
            <label class="form-label">E-mail</label>
            <input type="email" name="email" class="form-control" value="<?= $usuario['email_usuario'] ?>" required>
          </div>

          <div class="col-md-12">
            <label class="form-label">Nível de Acesso</label>
            <select name="nivel" class="form-select" required>
              <option value="usuario" <?= $usuario['nivel_usuario'] == 'usuario' ? 'selected' : '' ?>>👤 Usuário</option>
              <option value="admin" <?= $usuario['nivel_usuario'] == 'admin' ? 'selected' : '' ?>>👑 Administrador</option>
            </select>
          </div>

          <div class="col-md-12">
            <label class="form-label">Nova Senha (deixe em branco para manter a atual)</label>
            <input type="password" name="senha" class="form-control" placeholder="Digite apenas se quiser alterar a senha">
            <small class="text-muted">Deixe vazio se não deseja alterar a senha do usuário</small>
          </div>

          <div class="col-12 d-grid gap-2 d-md-flex justify-content-md-end mt-4">
            <a href="painelAdmin.php" class="btn btn-secondary">
              ← Cancelar
            </a>
            <button type="submit" class="btn btn-custom">
              💾 Salvar Alterações
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
