<?php require 'config.php'; ?>
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
      background: linear-gradient(135deg, #17c726ff 0%, #7dff55ff 100%);
      box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
      border-bottom: 2px solid rgba(255, 255, 255, 0.2);
      position: relative;
      z-index: 1000;
    }
      
    .navbar .navbar-brand{ 
      align-items: center;
      display: flex;
      color: #ffef5eff !important;
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
    
    /* Hero Card */
    .hero-card{
      background: white;
      border-radius: 20px;
      padding: 35px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
      position: relative;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .hero-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
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

<main class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10">
      <div class="hero-card text-center mb-4">
        <h3 class="mb-3 section-title">Adote seu AUmigão! 🐾</h3>
        <p class="text-center small-note">Preencha os dados para acessar sua conta.<br> Se ainda não possui uma conta, CADASTRE-SE.</p>
        <div class="d-grid gap-2 col-6 mx-auto">
          <a href="login.php" class="btn btn-primary btn-lg btn-primary-custom">Login</a>
        </div>
        <div class="d-grid gap-2 col-6 mx-auto" style="padding-top: 20px;">
          <a href="cadastroUsuario.php" class="btn btn-primary btn-lg btn-primary-custom">Cadastrar</a>
        </div>
      </div>
    </div>
  </div>
</main>

<footer>
  <p class="fw-bold">Projeto AUcolher! &nbsp;•&nbsp; los goats 2025</p>
</footer>

</body>
</html>