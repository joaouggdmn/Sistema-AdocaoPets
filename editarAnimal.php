<?php
session_start();
require 'config.php';

// Verifica se está logado
if (!isset($_SESSION['logado'])) {
    header("Location: login.php");
    exit;
}

$id_animal = $_GET['id'];
$id_usuario = $_SESSION['id_usuario'];
$nivel_usuario = $_SESSION['nivel_usuario'];

// Busca o animal para editar
// Admin pode editar qualquer animal, usuário normal só os seus
if($nivel_usuario == 'admin'){
    $sql = "SELECT * FROM animais WHERE id_animal = $id_animal";
} else {
    $sql = "SELECT * FROM animais WHERE id_animal = $id_animal AND usuario_id = $id_usuario";
}

$result = $conn->query($sql);

if($result->num_rows == 0){
    $_SESSION['erro'] = "❌ Você não tem permissão para editar este animal!";
    $redirect = ($nivel_usuario == 'admin') ? 'painelAdmin.php' : 'painelUsuario.php';
    header("Location: $redirect");
    exit;
}

$animal = $result->fetch_assoc();

// Se o formulário foi enviado (POST)
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nome = $_POST['nome'];
    $tipo = $_POST['tipo'];
    $raca = $_POST['raca'];
    $idade = $_POST['idade'];
    $sexo = $_POST['sexo'];
    $descricao = $_POST['descricao'];
    
    // Processa o upload da nova foto (se houver)
    $foto_nome = $animal['foto_animal']; // Mantém a foto antiga por padrão
    
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0){
        // Remove a foto antiga se existir
        if($animal['foto_animal'] && file_exists('uploads/' . $animal['foto_animal'])){
            unlink('uploads/' . $animal['foto_animal']);
        }
        
        // Salva a nova foto
        $foto_nome = $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads/' . $foto_nome);
    }
    
    // Atualiza no banco
    $sql_update = "UPDATE animais SET 
                   nome_animal = '$nome',
                   tipo_animal = '$tipo',
                   raca_animal = '$raca',
                   idade_animal = '$idade',
                   sexo_animal = '$sexo',
                   descricao_animal = '$descricao',
                   foto_animal = '$foto_nome'
                   WHERE id_animal = '$id_animal'";
    
    if($conn->query($sql_update) === TRUE){
        $_SESSION['sucesso'] = "✅ Animal atualizado com sucesso!";
        $redirect = ($_SESSION['nivel_usuario'] == 'admin') ? 'painelAdmin.php' : 'painelUsuario.php';
        header("Location: $redirect");
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
  <title>Editar Animal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800&family=Fredoka:wght@400;600&display=swap" rel="stylesheet">
  <style>
    :root{
      --pet-primary: #6D9F71;
      --pet-secondary: #d69040ff;
      --pet-accent: #FFE66D;
      --pet-dark: #2d3748;
      --pet-cream: #FFF3E2;
    }
    
    body {
      font-family: 'Nunito', sans-serif;
      background: linear-gradient(135deg, #A9CBB7 0%, #6D9F71 100%);
      min-height: 100vh;
      padding-bottom: 40px;
    }
    
    .navbar {
      background: #f7c58dff;
      box-shadow: 0 4px 12px rgba(247, 197, 141, 0.3);
      border-bottom: 2px solid rgba(255, 255, 255, 0.2);
    }
    
    .navbar .navbar-brand{ 
      color: #000000ff !important; 
      font-family: 'Fredoka', 'Nunito', sans-serif;
      font-size: 1.5rem;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
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
      box-shadow: 0 0 0 3px rgba(214, 144, 64, 0.2);
      border-color: #d69040ff;
      outline: none;
    }
    
    textarea.form-control {
      min-height: 120px;
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
    }
    
    .btn-secondary {
      background: transparent;
      border: 2px solid #6D9F71;
      color: #6D9F71;
      border-radius: 12px;
      padding: 16px 32px;
      font-weight: 700;
      font-size: 1.1rem;
      transition: all 0.3s ease;
    }
    
    .btn-secondary:hover {
      background: #6D9F71;
      border-color: #6D9F71;
      color: white;
      transform: translateY(-2px);
    }
    
    .foto-atual {
      border-radius: 12px;
      box-shadow: 0 6px 16px rgba(0,0,0,0.1);
      max-width: 300px;
      margin: 10px 0;
    }
  </style>
</head>
<body>

<main class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-8">
      <div class="card-pet">
        <h3 class="mb-3 text-center section-title">✏️ Editar Dados do Animal</h3>
        <p class="text-center text-muted mb-4">Atualize as informações de <strong><?= $animal['nome_animal'] ?></strong></p>

        <?php if(isset($_SESSION['erro'])): ?>
          <div class="alert alert-danger">
            <?= $_SESSION['erro']; unset($_SESSION['erro']); ?>
          </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="row g-3 mt-2">
          
          <div class="col-md-12">
            <label class="form-label">Nome do Animal</label>
            <input type="text" name="nome" class="form-control" value="<?= $animal['nome_animal'] ?>" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Tipo</label>
            <select name="tipo" class="form-select" required>
              <option value="Cachorro" <?= $animal['tipo_animal'] == 'Cachorro' ? 'selected' : '' ?>>🐕 Cachorro</option>
              <option value="Gato" <?= $animal['tipo_animal'] == 'Gato' ? 'selected' : '' ?>>🐱 Gato</option>
              <option value="Coelho" <?= $animal['tipo_animal'] == 'Coelho' ? 'selected' : '' ?>>🐰 Coelho</option>
              <option value="Pássaro" <?= $animal['tipo_animal'] == 'Pássaro' ? 'selected' : '' ?>>🐦 Pássaro</option>
              <option value="Hamster" <?= $animal['tipo_animal'] == 'Hamster' ? 'selected' : '' ?>>🐹 Hamster</option>
              <option value="Outros" <?= $animal['tipo_animal'] == 'Outros' ? 'selected' : '' ?>>🐾 Outros</option>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">Raça</label>
            <input type="text" name="raca" class="form-control" value="<?= $animal['raca_animal'] ?>" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Idade (aproximada)</label>
            <input type="text" name="idade" class="form-control" value="<?= $animal['idade_animal'] ?>" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Sexo</label>
            <select name="sexo" class="form-select" required>
              <option value="Macho" <?= $animal['sexo_animal'] == 'Macho' ? 'selected' : '' ?>>Macho</option>
              <option value="Fêmea" <?= $animal['sexo_animal'] == 'Fêmea' ? 'selected' : '' ?>>Fêmea</option>
            </select>
          </div>

          <div class="col-md-12">
            <label class="form-label">Descrição / Características</label>
            <textarea name="descricao" class="form-control" required><?= $animal['descricao_animal'] ?></textarea>
          </div>

          <div class="col-md-12">
            <label class="form-label">Foto Atual</label><br>
            <?php if($animal['foto_animal']): ?>
              <img src="uploads/<?= $animal['foto_animal'] ?>" alt="Foto atual" class="foto-atual img-fluid">
              <p class="text-muted mt-2"><small>📸 Envie uma nova foto para substituir a atual</small></p>
            <?php else: ?>
              <p class="text-muted">Sem foto cadastrada</p>
            <?php endif; ?>
          </div>

          <div class="col-md-12">
            <label class="form-label">Nova Foto (opcional)</label>
            <input type="file" name="foto" class="form-control" accept="image/*">
            <small class="text-muted">Deixe em branco para manter a foto atual</small>
          </div>

          <div class="col-12 d-grid gap-2 d-md-flex justify-content-md-end mt-4">
            <a href="<?= $_SESSION['nivel_usuario'] == 'admin' ? 'painelAdmin.php' : 'painelUsuario.php' ?>" class="btn btn-secondary">
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
