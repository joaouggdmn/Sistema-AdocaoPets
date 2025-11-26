<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nome = $_POST['nome'];
  $email = $_POST['email'];
  $senha = md5($_POST['senha']);


  $sql = "INSERT INTO usuarios (nome_usuario, email_usuario, senha_usuario) VALUES ('$nome', '$email', '$senha')";
  if ($conn->query($sql)) {
    // Buscar o ID do usuário recém-cadastrado
    $id_usuario = $conn->insert_id;
    
    // Criar a sessão automaticamente
    $_SESSION['logado'] = true;
    $_SESSION['id_usuario'] = $id_usuario;
    $_SESSION['nome_usuario'] = $nome;
    $_SESSION['email_usuario'] = $email;
    $_SESSION['nivel_usuario'] = 'usuario'; // Usuário comum por padrão
    
    // Redirecionar para o painel
    header("Location: painelUsuario.php");
    exit;
  } else {
    $msg = "Erro ao cadastrar: " . $conn->error;
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
  <style>
    :root {
      --pet-primary: #FF6B6B;
      --pet-secondary: #4ECDC4;
      --pet-accent: #FFE66D;
      --pet-dark: #2d3748;
      --pet-light: #f7f7f7;
    }

    body {
      font-family: 'Nunito', system-ui, -apple-system, 'Segoe UI', Roboto, Arial;
      background: linear-gradient(135deg, #A9CBB7 0%, #6D9F71 100%);
      padding-bottom: 40px;
      min-height: 100vh;
    }

  

    /* Card limpo */
    .card-pet {
      background: white;
      border-radius: 20px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
      padding: 40px;
      position: relative;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-pet:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
    }

    /* Título limpo */
    h3.section-title {
      color: #d69040ff;
      font-weight: 800;
      font-family: 'Fredoka', 'Nunito', sans-serif;
      font-size: 2.2rem;
    }

    .small-note {
      color: #64748b;
      font-size: 0.95rem;
      font-weight: 600;
    }

    /* Labels estilizadas */
    .form-label {
      color: var(--pet-dark);
      font-weight: 700;
      font-size: 0.95rem;
      margin-bottom: 8px;
    }

    /* Inputs modernos */
    .form-control {
      border: 2px solid #e2e8f0;
      border-radius: 12px;
      padding: 14px 18px;
      font-size: 1rem;
      transition: all 0.3s ease;
      background: white;
    }

    .form-control:focus {
      box-shadow: 0 0 0 3px rgba(109, 159, 113, 0.2);
      border-color: #6D9F71;
      outline: none;
    }

    .form-control::placeholder {
      color: #cbd5e0;
    }

    /* Botão limpo */
    .btn-custom {
      background: linear-gradient(135deg, #d69040ff 0%, #c47f35 100%);
      color: #fff;
      border: none;
      border-radius: 12px;
      padding: 16px 32px;
      font-weight: 700;
      font-size: 1.1rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      box-shadow: 0 6px 16px rgba(214, 144, 64, 0.3);
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
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
      transition: width 0.6s ease, height 0.6s ease;
    }
    
    .btn-custom:hover::before {
      width: 300px;
      height: 300px;
    }

    .btn-custom:hover {
      background: linear-gradient(135deg, #c47f35 0%, #b87030 100%);
      transform: translateY(-3px) scale(1.02);
      box-shadow: 0 10px 25px rgba(214, 144, 64, 0.5);
      letter-spacing: 1.5px;
    }
    
    .btn-custom:active {
      transform: translateY(-1px) scale(0.98);
      box-shadow: 0 5px 15px rgba(214, 144, 64, 0.4);
    }
    
    /* Botão voltar */
    .btn-voltar {
      background: transparent;
      border: 2.5px solid #6D9F71;
      color: #6D9F71;
      font-weight: 700;
      padding: 10px 24px;
      border-radius: 12px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 10px rgba(109, 159, 113, 0.2);
      text-decoration: none;
      display: inline-block;
    }
    
    .btn-voltar:hover {
      background: #119b4bff;
      color: #FFF3E2;
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(109, 159, 113, 0.4);
    }

  </style>
</head>

<body>

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
              <input type="text" name="nome" class="form-control" placeholder="Nome completo" required>
            </div>

            <div class="col-md-12">
              <label class="form-label">📧 E-mail</label>
              <input type="email" name="email" class="form-control" placeholder="seu@exemplo.com" required>
            </div>

            <div class="col-md-12">
              <label class="form-label">🔒 Senha</label>
              <input type="password" name="senha" class="form-control" placeholder="Crie uma senha" required>
            </div>

            <div class="col-12 mt-2" style="padding-top: 25px;">
              <div class="row g-2">
                <div class="col-7">
                  <button type="submit" class="btn btn-custom w-100">Cadastrar</button>
                </div>
                <div class="col-5">
                  <a href="index.php" class="btn-voltar w-100 d-flex align-items-center justify-content-center" style="height: 100%;">
                    ← Voltar
                  </a>
                </div>
              </div>
            </div>
            <?php if (isset($msg)): ?>
              <div class="alert alert-info text-center mt-3"><?= $msg; ?></div>
            <?php endif; ?>
          </form>
        </div>
      </div>
    </div>
  </main>

</body>

</html>