<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = md5($_POST['senha']);
   

    $sql = "INSERT INTO usuarios (nome_usuario, email_usuario, senha_usuario) VALUES ('$nome', '$email', '$senha')";
    if ($conn->query($sql)) {
        $msg = "Usuário cadastrado com sucesso!";
        header("Location: painelUsuario.php");
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
    :root{
      --pet-primary: #FF6B6B;
      --pet-secondary: #4ECDC4;
      --pet-accent: #FFE66D;
      --pet-dark: #2d3748;
      --pet-light: #f7f7f7;
    }
    
    html,body{height:100%; margin:0; padding:0;}
    
    body {
      font-family: 'Nunito', system-ui, -apple-system, 'Segoe UI', Roboto, Arial;
      background: linear-gradient(135deg, #4ECDC4 0%, #44b8b0 100%);
      color: var(--pet-dark);
      padding-bottom:40px;
      min-height: 100vh;
    }
    
    /* Navbar moderna */
    .navbar {
      background: linear-gradient(135deg, #FF6B6B 0%, #ff5252 100%);
      box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
      border-bottom: 2px solid rgba(255, 255, 255, 0.2);
      position: relative;
      z-index: 1000;
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
    
    .brand-icon{ 
      font-size:1.8rem; 
      margin-right:8px;
      display: inline-block;
    }
    
    /* Container principal */
    main {
      position: relative;
      z-index: 1;
    }
    
    /* Card limpo */
    .card-pet{
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
    h3.section-title{ 
      color: var(--pet-primary);
      font-weight: 800;
      font-family: 'Fredoka', 'Nunito', sans-serif;
      font-size: 2.2rem;
    }
    
    .small-note{ 
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
    
    .form-control:focus{ 
      box-shadow: 0 0 0 3px rgba(78, 205, 196, 0.2);
      border-color: var(--pet-secondary);
      outline: none;
    }
    
    .form-control::placeholder {
      color: #cbd5e0;
    }
    
    /* Botão limpo */
    .btn-custom {
      background: linear-gradient(135deg, #FF6B6B 0%, #ff5252 100%);
      color: #fff;
      border: none;
      border-radius: 12px;
      padding: 16px 32px;
      font-weight: 700;
      font-size: 1.1rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      box-shadow: 0 6px 16px rgba(255, 107, 107, 0.3);
      transition: all 0.3s ease;
    }
    
    .btn-custom:hover{ 
      background: linear-gradient(135deg, #ff5252 0%, #ff3838 100%);
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(255, 107, 107, 0.4);
    }
    
    /* Footer estilizado */
    footer { 
      background: linear-gradient(135deg, #4ECDC4 0%, #44b8b0 100%);
      padding: 20px;
      text-align: center;
      margin-top: 50px;
      color: #fff;
      box-shadow: 0 -4px 12px rgba(78, 205, 196, 0.2);
      border-top: 2px solid rgba(255, 255, 255, 0.2);
      position: relative;
      z-index: 1;
    }
    
    footer p {
      margin: 0;
      font-family: 'Fredoka', 'Nunito', sans-serif;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
  <div class="container-fluid px-4">
    <a href="index.php" class="navbar-brand fw-bold"><span class="brand-icon">🐾</span>PetShop</a>
  </div>
</nav>

<main class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
      <div class="card-pet">
        <h3 class="mb-3 text-center section-title">Cadastro de usuário</h3>
        <p class="text-center small-note">Preencha os dados para criar sua conta no sistema de adoção.</p>

        <!--Formulario de cadastro-->
        <form method="POST" class="row g-3 mt-2">
          <div class="col-md-12">
            <label class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" placeholder="Nome completo" required>
          </div>

          <div class="col-md-12">
            <label class="form-label">E-mail</label>
            <input type="email" name="email" class="form-control" placeholder="seu@exemplo.com" required>
          </div>

          <div class="col-md-12">
            <label class="form-label">Senha</label>
            <input type="password" name="senha" class="form-control" placeholder="Crie uma senha" required>
          </div>

          <div class="col-12 d-grid mt-2">
            <button type="submit" class="btn btn-custom btn-lg">Cadastrar</button>
          </div>
          <?php if(isset($msg)): ?>
    <div class="alert alert-info text-center mt-3"><?= $msg; ?></div>
  <?php endif; ?>
        </form>

      </div>
    </div>
  </div>
</main>

<footer>
  <p class="fw-bold">PetShop Adoção</p>
</footer>

</body>
</html>

