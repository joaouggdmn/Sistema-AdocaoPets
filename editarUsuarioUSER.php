<?php
session_start();
require 'config.php';

// Verifica se está logado
if (!isset($_SESSION['logado'])) {
    header("Location: login.php");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

// Busca os dados do usuário
$sql = "SELECT * FROM usuarios WHERE id_usuario = $id_usuario";
$result = $conn->query($sql);

if($result->num_rows == 0){
    $_SESSION['erro'] = "❌ Usuário não encontrado!";
    header("Location: painelUsuario.php");
    exit;
}

$usuario = $result->fetch_assoc();

// Se o formulário foi enviado (POST)
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    
    // Verifica se a senha foi preenchida
    if(!empty($_POST['senha'])){
        $senha = md5($_POST['senha']);
        $sql_update = "UPDATE usuarios SET nome_usuario = '$nome', email_usuario = '$email', senha_usuario = '$senha' WHERE id_usuario = $id_usuario";
    } else {
        $sql_update = "UPDATE usuarios SET nome_usuario = '$nome', email_usuario = '$email' WHERE id_usuario = $id_usuario";
    }
    
    if($conn->query($sql_update) === TRUE){
        $_SESSION['nome_usuario'] = $nome; // Atualiza o nome na sessão
        $_SESSION['sucesso'] = "✅ Perfil atualizado com sucesso!";
        header("Location: painelUsuario.php");
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
  <title>Editar Perfil</title>
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
      background: linear-gradient(135deg, #A9CBB7 0%, #6D9F71 100%);
      min-height: 100vh;
      padding-bottom: 40px;
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
      color: #d69040ff;
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
    
    .form-control {
      border: 2px solid #e2e8f0;
      border-radius: 12px;
      padding: 14px 18px;
      font-size: 1rem;
      transition: all 0.3s ease;
      background: white;
    }
    
    .form-control:focus{ 
      box-shadow: 0 0 0 3px rgba(214, 144, 64, 0.2);
      border-color: #d69040ff;
      outline: none;
    }
    
    .btn-custom {
      background: linear-gradient(135deg, #d69040ff 0%, #c47f35 100%);
      color: #fff;
      border: none;
      border-radius: 12px;
      padding: 16px 32px;
      font-weight: 700;
      font-size: 1.1rem;
      transition: all 0.3s ease;
      box-shadow: 0 6px 16px rgba(214, 144, 64, 0.3);
      position: relative;
      overflow: hidden;
    }
    
    .btn-custom::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.3);
      transform: translate(-50%, -50%);
      transition: width 0.6s, height 0.6s;
    }
    
    .btn-custom:hover::before {
      width: 300px;
      height: 300px;
    }
    
    .btn-custom:hover{ 
      background: linear-gradient(135deg, #c47f35 0%, #b87030 100%);
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(214, 144, 64, 0.4);
      color: white;
    }
    
    .btn-secondary {
      background: white;
      border: 2px solid #6D9F71;
      border-radius: 12px;
      padding: 16px 32px;
      font-weight: 700;
      font-size: 1.1rem;
      color: #6D9F71;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(109, 159, 113, 0.2);
    }
    
    .btn-secondary:hover {
      background: #6D9F71;
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(109, 159, 113, 0.4);
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
  </style>
</head>
<body>

<main class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-8">
      <div class="card-pet">
        <h3 class="mb-3 text-center section-title">👤 Editar Meu Perfil</h3>
        <p class="text-center text-muted mb-4">Atualize suas informações pessoais</p>

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
            <label class="form-label">Nova Senha (deixe em branco para manter a atual)</label>
            <input type="password" name="senha" class="form-control" placeholder="Digite apenas se quiser alterar a senha">
            <small class="text-muted">Deixe vazio se não deseja alterar sua senha</small>
          </div>

          <div class="col-12 d-grid gap-2 d-md-flex justify-content-md-end mt-4">
            <a href="painelUsuario.php" class="btn btn-secondary">
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
