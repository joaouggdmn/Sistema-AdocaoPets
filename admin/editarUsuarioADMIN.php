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
  <link href="../css/forms.css" rel="stylesheet">
</head>
<body class="admin-context">

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
