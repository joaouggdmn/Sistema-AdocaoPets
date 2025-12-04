<?php
session_start();
require '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nome = $_POST['nome_usuario'];
  $email = $_POST['email_usuario'];
  $senha = md5($_POST['senha']);

  // Verifica se o email já está cadastrado
  $sql_verifica = "SELECT id_usuario FROM usuarios WHERE email_usuario = ?";
  $stmt_verifica = $conn->prepare($sql_verifica);
  $stmt_verifica->bind_param("s", $email);
  $stmt_verifica->execute();
  $result_verifica = $stmt_verifica->get_result();
  
  if($result_verifica->num_rows > 0){
    $msg = "❌ Este e-mail já está cadastrado! Tente fazer login ou use outro e-mail.";
    $msg_type = "danger";
    $stmt_verifica->close();
  } else {
    $stmt_verifica->close();
    
    $sql = "INSERT INTO usuarios (nome_usuario, email_usuario, senha_usuario, nivel_usuario) VALUES (?, ?, ?, 'usuario')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nome, $email, $senha);
    
    if ($stmt->execute()) {
      // Buscar o ID do usuário recém-cadastrado
      $id_usuario = $stmt->insert_id;
      
      // Criar a sessão automaticamente
      $_SESSION['logado'] = true;
      $_SESSION['id_usuario'] = $id_usuario;
      $_SESSION['nome_usuario'] = $nome;
      $_SESSION['email_usuario'] = $email;
      $_SESSION['nivel_usuario'] = 'usuario';
      
      $stmt->close();
      
      // Redirecionar para o painel
      header("Location: ../user/painelUsuario.php");
      exit;
    } else {
      $msg = "❌ Erro ao cadastrar: " . $stmt->error;
      $msg_type = "danger";
      $stmt->close();
    }
  }
}
?>
<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <title>Cadastro</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800&family=Fredoka:wght@400;600&display=swap" rel="stylesheet">
  <link href="../css/forms.css" rel="stylesheet">
</head>

<body class="user-context">

  <main class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-12 col-md-8 col-lg-6">
        <div class="card-pet">
          <h3 class="mb-3 text-center section-title">Cadastro de usuário</h3>
          <p class="text-center small-note" >Preencha os dados para criar sua conta e se conectar com os pets.</p>

          <!--Formulario de cadastro-->
          <form method="POST" class="row g-3 mt-2">
            <div class="col-md-12">
              <label class="form-label">👤 Nome</label>
              <input type="text" name="nome_usuario" class="form-control" placeholder="Digite seu nome" required>
            </div>

            <div class="col-md-12">
              <label class="form-label">📧 E-mail</label>
              <input type="email" name="email_usuario" class="form-control" placeholder="seu@exemplo.com" required>
            </div>

            <div class="col-md-12">
              <label class="form-label">🔒 Senha</label>
              <input type="password" name="senha" class="form-control" placeholder="Crie uma senha" required>
            </div>

            <?php if (isset($msg)): ?>
              <div class="text-danger text-center mt-3"><?= $msg; ?></div>
            <?php endif; ?>

            <div class="col-12 mt-2" style="padding-top: 25px;">
              <div class="row g-2">
                <div class="col-5">
                  <a href="../index.php" class="btn-voltar w-100 d-flex align-items-center justify-content-center" style="height: 100%;">
                    ← Voltar
                  </a>
                </div>
                <div class="col-7">
                  <button type="submit" class="btn btn-custom w-100">Cadastrar</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>

</body>

</html>