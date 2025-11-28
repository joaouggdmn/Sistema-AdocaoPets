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

// Impede que o admin exclua sua própria conta
if($id_usuario == $_SESSION['id_usuario']){
    $_SESSION['erro'] = "❌ Você não pode excluir sua própria conta!";
    header("Location: painelAdmin.php");
    exit;
}

// Verifica se o usuário confirmou a exclusão
if(isset($_GET['confirmar']) && $_GET['confirmar'] == 'sim'){
    
    // Busca todos os animais do usuário para deletar as fotos
    $sql_animais = "SELECT foto_animal FROM animais WHERE usuario_id = $id_usuario";
    $result_animais = $conn->query($sql_animais);
    
    // Deleta todas as fotos dos animais
    while($animal = $result_animais->fetch_assoc()){
        if($animal['foto_animal'] && file_exists('uploads/' . $animal['foto_animal'])){
            unlink('uploads/' . $animal['foto_animal']);
        }
    }
    
    // Deleta todos os animais do usuário
    $sql_delete_animais = "DELETE FROM animais WHERE usuario_id = $id_usuario";
    $conn->query($sql_delete_animais);
    
    // Deleta o usuário
    $sql_delete = "DELETE FROM usuarios WHERE id_usuario = $id_usuario";
    
    if($conn->query($sql_delete) === TRUE){
        $_SESSION['sucesso'] = "✅ Usuário excluído com sucesso!";
        header("Location: painelAdmin.php");
        exit;
    } else {
        $_SESSION['erro'] = "❌ Erro ao excluir usuário: " . $conn->error;
        header("Location: painelAdmin.php");
        exit;
    }
}

// Busca dados do usuário para exibir
$sql = "SELECT * FROM usuarios WHERE id_usuario = $id_usuario";
$result = $conn->query($sql);

if($result->num_rows == 0){
    $_SESSION['erro'] = "❌ Usuário não encontrado!";
    header("Location: painelAdmin.php");
    exit;
}

$usuario = $result->fetch_assoc();

// Conta quantos animais o usuário tem
$sql_count = "SELECT COUNT(*) as total FROM animais WHERE usuario_id = $id_usuario";
$result_count = $conn->query($sql_count);
$count = $result_count->fetch_assoc();
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Excluir Usuário - Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800&family=Fredoka:wght@400;600&display=swap" rel="stylesheet">
  <style>
    :root{
      --pet-primary: #FF6B6B;
      --pet-secondary: #4ECDC4;
      --pet-dark: #2d3748;
    }
    
    body {
      font-family: 'Nunito', sans-serif;
      background: linear-gradient(135deg, #ffccc9ff 0%, #ff8839ff 100%);
      min-height: 100vh;
      padding-bottom: 40px;
    }
    
    .navbar {
      background: linear-gradient(135deg, #d69040ff 0%, #c47f35 100%);
      box-shadow: 0 4px 12px rgba(214, 144, 64, 0.3);
      border-bottom: 2px solid rgba(255, 255, 255, 0.2);
    }
    
    .navbar .navbar-brand{ 
      color:#fff !important; 
      font-family: 'Fredoka', 'Nunito', sans-serif;
      font-size: 1.5rem;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }
    
    .card-pet{
      background: white;
      border-radius: 20px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
      padding: 40px;
      border: 3px solid #FF6B6B;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    h3.section-title{ 
      color: var(--pet-primary);
      font-weight: 800;
      font-family: 'Fredoka', 'Nunito', sans-serif;
      font-size: 2.2rem;
    }
    
    .btn-danger {
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
    
    .btn-danger:hover{ 
      background: linear-gradient(135deg, #ff5252 0%, #ff3838 100%);
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(255, 107, 107, 0.4);
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

    .alert-warning {
      background: linear-gradient(135deg, #FFF3E2 0%, #f7e5c8 100%);
      border: none;
      border-radius: 15px;
      padding: 20px;
      color: var(--pet-dark);
      font-weight: 600;
      border-left: 5px solid #d69040ff;
    }

    .info-box {
      background: #f8f9fa;
      border-radius: 12px;
      padding: 20px;
      margin: 20px 0;
      border-left: 4px solid #FF6B6B;
    }

    .info-box h5 {
      color: var(--pet-primary);
      font-weight: 700;
      margin-bottom: 15px;
    }

    .info-item {
      padding: 10px 0;
      border-bottom: 1px solid #dee2e6;
    }

    .info-item:last-child {
      border-bottom: none;
    }

    .badge {
      padding: 8px 16px;
      border-radius: 10px;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>

<main class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-8">
      <div class="card-pet">
        <h3 class="mb-3 text-center section-title"> Excluir Usuário</h3>
        <p class="text-center text-muted mb-4">Esta ação não pode ser desfeita!</p>

        <div class="alert alert-warning">
          <strong>⚠️ ATENÇÃO:</strong> Você está prestes a excluir permanentemente este usuário!
        </div>

        <div class="info-box">
          <h5>📋 Informações do Usuário</h5>
          <div class="info-item">
            <strong>ID:</strong> <?= $usuario['id_usuario'] ?>
          </div>
          <div class="info-item">
            <strong>Nome:</strong> <?= $usuario['nome_usuario'] ?>
          </div>
          <div class="info-item">
            <strong>E-mail:</strong> <?= $usuario['email_usuario'] ?>
          </div>
          <div class="info-item">
            <strong>Nível:</strong> 
            <span class="badge <?= $usuario['nivel_usuario'] == 'admin' ? 'bg-danger' : 'bg-primary' ?>">
              <?= $usuario['nivel_usuario'] == 'admin' ? '👑 Administrador' : '👤 Usuário' ?>
            </span>
          </div>
          <div class="info-item">
            <strong>Animais cadastrados:</strong> <?= $count['total'] ?> pet(s)
          </div>
        </div>

        <div class="alert alert-warning mt-4">
          <h6 class="mb-2"><strong>O que será excluído:</strong></h6>
          <ul class="mb-0">
            <li>Dados pessoais do usuário (nome, e-mail, senha)</li>
            <li>Todos os <?= $count['total'] ?> animais cadastrados por este usuário</li>
            <li>Todas as fotos dos animais</li>
            <li>Histórico de atividades do usuário</li>
          </ul>
        </div>

        <div class="text-center mt-4">
          <p class="text-danger fw-bold mb-4">⚠️ Tem certeza que deseja continuar?</p>
          
          <div class="d-grid gap-2 d-md-flex justify-content-md-center">
            <a href="painelAdmin.php" class="btn btn-secondary btn-lg">
              ← Cancelar
            </a>
            <a href="excluirUsuarioADMIN.php?id=<?= $id_usuario ?>&confirmar=sim" class="btn btn-danger btn-lg">
              🗑️ Sim, Excluir Usuário
            </a>
          </div>
        </div>

      </div>
    </div>
  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
