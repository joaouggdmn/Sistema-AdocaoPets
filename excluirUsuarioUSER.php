<?php
session_start();
require 'config.php';

// Verifica se está logado
if (!isset($_SESSION['logado'])) {
    header("Location: login.php");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

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
        // Destrói a sessão
        session_destroy();
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['erro'] = "❌ Erro ao excluir conta: " . $conn->error;
        header("Location: painelUsuario.php");
        exit;
    }
}

// Busca dados do usuário para exibir
$sql = "SELECT * FROM usuarios WHERE id_usuario = $id_usuario";
$result = $conn->query($sql);
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
  <title>Excluir Conta</title>
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
      background: linear-gradient(135deg, #fee 0%, #fdd 100%);
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
    }
    
    .card-pet{
      background: white;
      border-radius: 20px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
      padding: 40px;
      border: 3px solid #FF6B6B;
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
      color: white;
    }

    .alert-warning {
      background: linear-gradient(135deg, #FFE66D 0%, #ffd93d 100%);
      border: none;
      border-radius: 15px;
      padding: 20px;
      color: var(--pet-dark);
      font-weight: 600;
      border-left: 5px solid #ff9800;
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
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
  <div class="container-fluid px-4">
    <a href="painelUsuario.php" class="navbar-brand fw-bold"><span style="font-size:1.8rem;">⚠️</span> Excluir Conta</a>
  </div>
</nav>

<main class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-8">
      <div class="card-pet">
        <h3 class="mb-3 text-center section-title">⚠️ Excluir Minha Conta</h3>
        <p class="text-center text-muted mb-4">Esta ação não pode ser desfeita!</p>

        <div class="alert alert-warning">
          <strong>⚠️ ATENÇÃO:</strong> Você está prestes a excluir permanentemente sua conta!
        </div>

        <div class="info-box">
          <h5>📋 Informações da Conta</h5>
          <div class="info-item">
            <strong>Nome:</strong> <?= $usuario['nome_usuario'] ?>
          </div>
          <div class="info-item">
            <strong>E-mail:</strong> <?= $usuario['email_usuario'] ?>
          </div>
          <div class="info-item">
            <strong>Animais cadastrados:</strong> <?= $count['total'] ?> pet(s)
          </div>
        </div>

        <div class="alert alert-warning mt-4">
          <h6 class="mb-2"><strong>⚠️ O que será excluído:</strong></h6>
          <ul class="mb-0">
            <li>Seus dados pessoais (nome, e-mail, senha)</li>
            <li>Todos os <?= $count['total'] ?> animais que você cadastrou</li>
            <li>Todas as fotos dos seus animais</li>
            <li>Seu histórico de atividades</li>
          </ul>
        </div>

        <div class="text-center mt-4">
          <p class="text-danger fw-bold mb-4"> Tem certeza absoluta que deseja continuar?</p>
          
          <div class="d-grid gap-2 d-md-flex justify-content-md-center">
            <a href="painelUsuario.php" class="btn btn-secondary btn-lg">
              ← Cancelar e Voltar
            </a>
            <a href="excluirUsuario.php?confirmar=sim" class="btn btn-danger btn-lg" onclick="return confirm('⚠️ ÚLTIMA CONFIRMAÇÃO!\n\nVocê tem CERTEZA ABSOLUTA que deseja excluir sua conta?\n\nEsta ação é IRREVERSÍVEL e todos os seus dados serão perdidos permanentemente!')">
              🗑️ Sim, Excluir Minha Conta
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
