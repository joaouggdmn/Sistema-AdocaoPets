<?php require 'config.php'; 
session_start();?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Adoção</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800&family=Fredoka:wght@400;600&display=swap" rel="stylesheet">
  <style>
    :root{
      --pet-primary: #fa725dff;
      --pet-secondary: #4ECDC4;
      --pet-accent: #FFE66D;
      --pet-dark: #2d3748;
      --pet-light: #f7f7f7;
    }
    
    body{
      font-family: 'Nunito', system-ui, -apple-system, 'Segoe UI', Roboto, Arial;
      background: linear-gradient(135deg, #faee48ff 0%, #fffd7dff 100%);
      color: var(--pet-dark);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      margin: 0;
    }
    
    /* Navbar */
    .navbar{
      position: relative;
      z-index: 1000;
    }
      
    .navbar .navbar-brand { 
      align-items: center;
      display: flex;
      color: #000000ff !important;
      font-family: 'Fredoka', 'Nunito', sans-serif;
      font-size: 1.5rem;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
      transition: transform 0.3s ease;
    }
    
    .navbar .navbar-brand:hover {
      transform: translateY(-2px);
    }
    
    .brand-icon{ 
      font-size: 1.8rem;
      margin-right: 8px;
      display: inline-block;
    }
    
    main {
      position: relative;
      z-index: 1;
      flex: 1;
    }
    
    /* Hero Card - Efeito Glassmorphism */
    .hero-card{
      padding: 35px;
    }
    /* Título */
    h3.section-title{ 
      color: var(--pet-primary);
      font-weight: 800;
      font-family: 'Fredoka', 'Nunito', sans-serif;
      font-size: 2.5rem;
    }
    
    /* Botão principal */
    .btn-primary-custom{ 
      background: linear-gradient(135deg, #FF6B6B 0%, #ff5252 100%);
      border: none;
      border-radius: 12px;
      padding: 16px 32px;
      font-weight: 700;
      font-size: 1.1rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      box-shadow: 0 6px 16px rgba(255, 107, 107, 0.3);
      transition: all 0.3s ease;
      color: white;
    }
    
    .btn-primary-custom:hover{ 
      background: linear-gradient(135deg, #ff5252 0%, #ff3838 100%);
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(255, 107, 107, 0.4);
      color: white;
    }
    
    /* Card da tabela */
    .card-pet {
      background: white;
      border-radius: 20px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
      overflow: hidden;
    }
    
    /* Tabela estilizada */
    .table {
      margin-bottom: 0;
      border-radius: 20px;
      overflow: hidden;
    }
    
    .table thead{ 
      background: linear-gradient(135deg, #FFE66D 0%, #ffd93d 100%);
      border-bottom: 2px solid rgba(78, 205, 196, 0.3);
    }
    
    .table thead th {
      font-weight: 800;
      font-family: 'Fredoka', 'Nunito', sans-serif;
      color: var(--pet-dark);
      text-transform: uppercase;
      letter-spacing: 0.5px;
      padding: 18px 15px;
      border: none;
      font-size: 0.95rem;
    }
    
    .table tbody td {
      padding: 16px 15px;
      vertical-align: middle;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
      font-weight: 600;
    }
    
    .table tbody tr{ 
      transition: all 0.3s ease;
      background: white;
    }
    
    .table tbody tr:hover{ 
      background: rgba(78, 205, 196, 0.08);
      transform: translateX(2px);
    }
    
    /* Botões de ação */
    .action-btn{ 
      margin-right: 8px;
      border-radius: 10px;
      font-weight: 700;
      padding: 8px 16px;
      text-transform: uppercase;
      font-size: 0.85rem;
      letter-spacing: 0.5px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .action-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    }
    
    .btn-warning {
      background: linear-gradient(135deg, #FFE66D 0%, #ffd93d 100%);
      border: none;
      color: var(--pet-dark);
    }
    
    .btn-warning:hover {
      background: linear-gradient(135deg, #ffd93d 0%, #ffc400 100%);
      color: var(--pet-dark);
    }

    /* banner */
    .banner{
      position: relative;
      background-image: url('https://www3.al.sp.gov.br/repositorio/noticia/N-12-2019/fg245895.jpg');
      background-size: cover;
      background-position: center;
      height: 550px;
      border-radius: 0px 0px 20px 20px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .banner::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.4);
      border-radius: 0px 0px 20px 20px;
    }
    
    .banner-content {
      position: relative;
      z-index: 2;
      text-align: center;
      padding: 20px;
    }
    
    .banner h1 {
      font-family: 'Fredoka', sans-serif;
      font-size: 4rem;
      font-weight: 800;
      color: #ffffffff;
      margin-bottom: 20px;
      line-height: 1.2;
    }
    
    .banner p {
      font-family: 'Nunito', sans-serif;
      font-size: 1.8rem;
      font-weight: 700;
      color: #ffffffff;
    }
    
    .btn-danger {
      background: linear-gradient(135deg, #FF6B6B 0%, #ff5252 100%);
      border: none;
      border-radius: 10px;
      font-weight: 700;
      padding: 8px 16px;
      text-transform: uppercase;
      font-size: 0.85rem;
      letter-spacing: 0.5px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
    }
    
    .btn-danger:hover {
      background: linear-gradient(135deg, #ff5252 0%, #ff3838 100%);
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(255, 107, 107, 0.4);
    }
    
    /* Footer */
    footer { 
      background: linear-gradient(135deg, #17c726ff 0%, #7dff55ff 100%);
      padding: 20px;
      text-align: center;
      margin-top: auto;
      color: #ffef5eff;
      box-shadow: 0 -4px 12px rgba(78, 205, 196, 0.2);
      border-top: 2px solid rgba(255, 255, 255, 0.2);
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
    <a class="navbar-brand fw-bold"><img src="img/AucolherLogo.png" alt="logo aucolher">Projeto AUcolher!</a>
  </div>
</nav>
<div class="banner">
    <div class="banner-content">
      <h1>Encontre seu AUmigo para a vida! 🐾</h1>
      <p>Adote um pet e transforme duas vidas hoje mesmo</p>
    </div>
  </div>
<main class="container mt-5" id="login-section">
  
  <div class="row justify-content-center align-items-center">
    <div class="col-12 col-md-6 col-lg-5">
      <div class="hero-card mb-4">
        <h3 class="mb-4 section-title text-center">Bem-vindo de volta!</h3>
        
        <form action="validaLogin.php" method="POST">
          <div class="mb-3">
            <label class="form-label fw-bold">📧 E-mail</label>
            <input type="email" name="email" class="form-control" placeholder="seu@email.com" required style="border: 2px solid #e2e8f0; border-radius: 12px; padding: 14px 18px;">
          </div>

          <div class="mb-4">
            <label class="form-label fw-bold">🔒 Senha</label>
            <input type="password" name="senha" class="form-control" placeholder="Digite sua senha" required style="border: 2px solid #e2e8f0; border-radius: 12px; padding: 14px 18px;">
          </div>

          <?php if(isset($_SESSION['erro'])): ?>
      <div class="text-danger text-center mt-3" style="margin-bottom: 20px;">
        <?= $_SESSION['erro']; unset($_SESSION['erro']); ?>
      </div>
    <?php endif; ?>

          <div class="d-grid mb-3">
            <button type="submit" class="btn btn-primary-custom">
              Entrar
            </button>
          </div>
          
        </form>

        <hr class="my-4">

        <div class="text-center">
          <p class="text-muted mb-2">Ainda não tem uma conta?</p>
          <a href="cadastroUsuario.php" class="text-decoration-none fw-bold" style="color: var(--pet-secondary); font-size: 1.1rem;">
            ✨ Cadastre-se aqui
          </a>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-5 text-center">
      <img src="img/dognoCarro.png" alt="Pet" style="border-radius: 20px; box-shadow: 0 8px 24px rgba(0,0,0,0.15);">
    </div>
  </div>
</main>

<footer>
  <p class="fw-bold">Projeto AUcolher! &nbsp;•&nbsp; los goats 2025</p>
</footer>

</body>
</html>