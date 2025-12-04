<?php
session_start();
require '../config.php';

// Verifica se é admin
if (!isset($_SESSION['logado']) || $_SESSION['nivel_usuario'] != 'admin') {
    header("Location: ../index.php#login-section");
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
        if($animal['foto_animal'] && file_exists('../assets/uploads/' . $animal['foto_animal'])){
            unlink('../assets/uploads/' . $animal['foto_animal']);
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
  <link href="../css/forms.css" rel="stylesheet">
  <style>
    .card-pet {
      border: 3px solid #FF6B6B;
    }
    
    h3.section-title { 
      color: #FF6B6B !important;
    }
  </style>
</head>
<body class="admin-context">

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
