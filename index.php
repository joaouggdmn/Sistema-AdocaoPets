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
      --pet-primary: #ff6b9d;
      --pet-secondary: #4ecdc4;
      --pet-accent: #ffd93d;
      --pet-purple: #a78bfa;
      --pet-orange: #ff9966;
      --pet-dark: #2d3748;
      --card-bg: #fffbf5;
    }
    
    body{
      font-family: 'Nunito', system-ui, -apple-system, 'Segoe UI', Roboto, Arial;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #4facfe 75%, #00f2fe 100%);
      background-size: 400% 400%;
      animation: gradientShift 15s ease infinite;
      color: var(--pet-dark);
      min-height: 100vh;
      padding-bottom: 40px;
      position: relative;
      overflow-x: hidden;
    }
    
    @keyframes gradientShift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    
    /* Decorações de fundo */
    body::before {
      content: '🐾';
      position: fixed;
      top: 15%;
      left: 8%;
      font-size: 70px;
      opacity: 0.1;
      animation: float 7s ease-in-out infinite;
      z-index: 0;
    }
    
    body::after {
      content: '🦴';
      position: fixed;
      bottom: 20%;
      right: 10%;
      font-size: 60px;
      opacity: 0.1;
      animation: float 9s ease-in-out infinite reverse;
      z-index: 0;
    }
    
    @keyframes float {
      0%, 100% { transform: translateY(0px) rotate(0deg); }
      50% { transform: translateY(-20px) rotate(10deg); }
    }
    
    /* Navbar */
    .navbar{
      background: linear-gradient(135deg, #ff6b9d 0%, #ff8fab 50%, #ffa8ba 100%);
      box-shadow: 0 8px 32px rgba(255, 107, 157, 0.4);
      backdrop-filter: blur(10px);
      border-bottom: 3px solid rgba(255, 255, 255, 0.3);
      position: relative;
      overflow: hidden;
      z-index: 1000;
    }
    
    .navbar::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255,255,255,0.1) 10%, transparent 40%);
      animation: navShine 10s linear infinite;
    }
    
    @keyframes navShine {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    
    .navbar .navbar-brand{ 
      color: #fff !important;
      font-family: 'Fredoka', 'Nunito', sans-serif;
      font-size: 1.5rem;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
      position: relative;
      z-index: 1;
      transition: transform 0.3s ease;
    }
    
    .navbar .navbar-brand:hover {
      transform: scale(1.05) translateY(-2px);
    }
    
    .brand-icon{ 
      font-size: 1.8rem;
      margin-right: 8px;
      display: inline-block;
      animation: pawBounce 2s ease-in-out infinite;
    }
    
    @keyframes pawBounce {
      0%, 100% { transform: rotate(0deg) scale(1); }
      25% { transform: rotate(-10deg) scale(1.1); }
      75% { transform: rotate(10deg) scale(1.1); }
    }
    
    main {
      position: relative;
      z-index: 1;
    }
    
    /* Hero Card */
    .hero-card{
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-radius: 30px;
      padding: 35px;
      box-shadow: 
        0 20px 60px rgba(0, 0, 0, 0.15),
        0 0 0 1px rgba(255, 255, 255, 0.5) inset,
        0 8px 16px rgba(255, 107, 157, 0.2);
      border: 2px solid rgba(255, 255, 255, 0.3);
      position: relative;
      overflow: hidden;
      animation: cardEntrance 0.8s ease-out;
    }
    
    @keyframes cardEntrance {
      from {
        opacity: 0;
        transform: translateY(30px) scale(0.95);
      }
      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }
    
    .hero-card::before {
      content: '🐕';
      position: absolute;
      top: -15px;
      right: -15px;
      font-size: 100px;
      opacity: 0.06;
      transform: rotate(15deg);
    }
    
    /* Título */
    h3.section-title{ 
      color: transparent;
      background: linear-gradient(135deg, #ff6b9d 0%, #a78bfa 50%, #4ecdc4 100%);
      background-clip: text;
      -webkit-background-clip: text;
      font-weight: 800;
      font-family: 'Fredoka', 'Nunito', sans-serif;
      font-size: 2.5rem;
      text-shadow: 0 4px 12px rgba(255, 107, 157, 0.2);
      animation: titleGlow 3s ease-in-out infinite;
    }
    
    @keyframes titleGlow {
      0%, 100% { filter: brightness(1); }
      50% { filter: brightness(1.2); }
    }
    
    /* Botão principal */
    .btn-primary-custom{ 
      background: linear-gradient(135deg, #ff6b9d 0%, #ff8fab 50%, #ffa8ba 100%);
      border: none;
      border-radius: 15px;
      padding: 16px 32px;
      font-weight: 700;
      font-size: 1.1rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      box-shadow: 
        0 10px 30px rgba(255, 107, 157, 0.4),
        0 0 0 3px rgba(255, 255, 255, 0.3);
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
      color: white;
    }
    
    .btn-primary-custom::before {
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
    
    .btn-primary-custom:hover::before {
      width: 300px;
      height: 300px;
    }
    
    .btn-primary-custom:hover{ 
      background: linear-gradient(135deg, #ff558a 0%, #ff6b9d 50%, #ff8fab 100%);
      transform: translateY(-3px);
      box-shadow: 
        0 15px 40px rgba(255, 107, 157, 0.5),
        0 0 0 4px rgba(255, 255, 255, 0.4);
      color: white;
    }
    
    /* Card da tabela */
    .card-pet {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-radius: 30px;
      box-shadow: 
        0 20px 60px rgba(0, 0, 0, 0.15),
        0 0 0 1px rgba(255, 255, 255, 0.5) inset,
        0 8px 16px rgba(255, 107, 157, 0.2);
      border: 2px solid rgba(255, 255, 255, 0.3);
      overflow: hidden;
      animation: cardEntrance 0.8s ease-out 0.2s backwards;
    }
    
    /* Tabela estilizada */
    .table {
      margin-bottom: 0;
      border-radius: 20px;
      overflow: hidden;
    }
    
    .table thead{ 
      background: linear-gradient(135deg, #ffd93d 0%, #ffed4e 50%, #ffe066 100%);
      border-bottom: 3px solid rgba(255, 107, 157, 0.3);
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
      background: linear-gradient(90deg, rgba(255, 107, 157, 0.08) 0%, rgba(167, 139, 250, 0.08) 100%);
      transform: scale(1.01);
      box-shadow: 0 4px 12px rgba(255, 107, 157, 0.15);
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
      background: linear-gradient(135deg, #ffd93d 0%, #ffed4e 100%);
      border: none;
      color: var(--pet-dark);
    }
    
    .btn-warning:hover {
      background: linear-gradient(135deg, #ffc400 0%, #ffd93d 100%);
      color: var(--pet-dark);
    }
    
    .btn-danger {
      background: linear-gradient(135deg, #ff6b9d 0%, #ff8fab 100%);
      border: none;
      border-radius: 10px;
      font-weight: 700;
      padding: 8px 16px;
      text-transform: uppercase;
      font-size: 0.85rem;
      letter-spacing: 0.5px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(255, 107, 157, 0.3);
    }
    
    .btn-danger:hover {
      background: linear-gradient(135deg, #ff558a 0%, #ff6b9d 100%);
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(255, 107, 157, 0.4);
    }
    
    /* Footer */
    footer { 
      background: linear-gradient(135deg, #ff6b9d 0%, #a78bfa 100%);
      padding: 20px;
      text-align: center;
      margin-top: 50px;
      color: #fff;
      box-shadow: 0 -8px 32px rgba(255, 107, 157, 0.3);
      border-top: 3px solid rgba(255, 255, 255, 0.3);
      position: relative;
      z-index: 1;
    }
    
    footer p {
      margin: 0;
      font-family: 'Fredoka', 'Nunito', sans-serif;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
      animation: footerPulse 3s ease-in-out infinite;
    }
    
    @keyframes footerPulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.9; }
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
  <div class="container-fluid px-4">
    <a class="navbar-brand fw-bold"><span class="brand-icon">🐾</span>PetShop - Adoção</a>
  </div>
</nav>

<main class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10">
      <div class="hero-card text-center mb-4">
        <h3 class="mb-3 section-title">Adote seu AUmigão</h3>
        <p class="text-center small-note">Preencha os dados para acessar sua conta no sistema de adoção.<br> Se ainda não possui uma conta, CADASTRE-SE.</p>
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
  <p class="fw-bold">PetShop - Adoção de animais &nbsp;•&nbsp; los goats 2025</p>
</footer>

</body>
</html>