<?php
session_start();
require 'config.php';

// Verifica se está logado
if (!isset($_SESSION['logado'])) {
    header("Location: login.php");
    exit;
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Cadastrar Animal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
    
    html,body{height:100%; margin:0; padding:0;}
    
    body {
      font-family: 'Nunito', system-ui, -apple-system, 'Segoe UI', Roboto, Arial;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #4facfe 75%, #00f2fe 100%);
      background-size: 400% 400%;
      animation: gradientShift 15s ease infinite;
      color: var(--pet-dark);
      padding-bottom:40px;
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
      content: '🐕';
      position: fixed;
      top: 10%;
      left: 5%;
      font-size: 60px;
      opacity: 0.1;
      animation: float 6s ease-in-out infinite;
      z-index: 0;
    }
    
    body::after {
      content: '🐱';
      position: fixed;
      bottom: 15%;
      right: 8%;
      font-size: 80px;
      opacity: 0.1;
      animation: float 8s ease-in-out infinite reverse;
      z-index: 0;
    }
    
    @keyframes float {
      0%, 100% { transform: translateY(0px) rotate(0deg); }
      50% { transform: translateY(-20px) rotate(10deg); }
    }
    
    /* Navbar */
    .navbar {
      background: linear-gradient(135deg, #4ecdc4 0%, #44a8a0 100%);
      box-shadow: 0 8px 32px rgba(78, 205, 196, 0.4);
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
      color:#fff !important; 
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
      font-size:1.8rem; 
      margin-right:8px;
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
    
    /* Card com efeito glassmorphism */
    .card-pet{
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border-radius: 30px;
      box-shadow: 
        0 20px 60px rgba(0, 0, 0, 0.15),
        0 0 0 1px rgba(255, 255, 255, 0.5) inset,
        0 8px 16px rgba(78, 205, 196, 0.2);
      padding: 40px;
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
    
    /* Decoração do card */
    .card-pet::before {
      content: '🐾';
      position: absolute;
      top: -20px;
      right: -20px;
      font-size: 120px;
      opacity: 0.05;
      transform: rotate(15deg);
    }
    
    /* Título com efeito gradiente */
    h3.section-title{ 
      color: transparent;
      background: linear-gradient(135deg, #4ecdc4 0%, #44a8a0 50%, #3ba89e 100%);
      background-clip: text;
      -webkit-background-clip: text;
      font-weight: 800;
      font-family: 'Fredoka', 'Nunito', sans-serif;
      font-size: 2.2rem;
      text-shadow: 0 4px 12px rgba(78, 205, 196, 0.2);
      animation: titleGlow 3s ease-in-out infinite;
      position: relative;
    }
    
    @keyframes titleGlow {
      0%, 100% { filter: brightness(1); }
      50% { filter: brightness(1.2); }
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
      display: flex;
      align-items: center;
      gap: 6px;
    }
    
    .form-label::before {
      content: '🐾';
      font-size: 0.9rem;
    }
    
    /* Inputs modernos */
    .form-control, .form-select {
      border: 2px solid #e2e8f0;
      border-radius: 15px;
      padding: 14px 18px;
      font-size: 1rem;
      transition: all 0.3s ease;
      background: rgba(255, 255, 255, 0.9);
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
    
    .form-control:focus, .form-select:focus{ 
      box-shadow: 
        0 0 0 4px rgba(78, 205, 196, 0.15),
        0 8px 20px rgba(78, 205, 196, 0.2);
      border-color: var(--pet-secondary);
      transform: translateY(-2px);
      background: white;
    }
    
    .form-control::placeholder {
      color: #cbd5e0;
    }
    
    textarea.form-control {
      min-height: 120px;
      resize: vertical;
    }
    
    /* Botão com animações e efeitos */
    .btn-custom {
      background: linear-gradient(135deg, #4ecdc4 0%, #44a8a0 50%, #3ba89e 100%);
      color: #fff;
      border: none;
      border-radius: 15px;
      padding: 16px 32px;
      font-weight: 700;
      font-size: 1.1rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      box-shadow: 
        0 10px 30px rgba(78, 205, 196, 0.4),
        0 0 0 3px rgba(255, 255, 255, 0.3);
      transition: all 0.3s ease;
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
      background: linear-gradient(135deg, #3ba89e 0%, #32938b 50%, #2a7f79 100%);
      transform: translateY(-3px);
      box-shadow: 
        0 15px 40px rgba(78, 205, 196, 0.5),
        0 0 0 4px rgba(255, 255, 255, 0.4);
    }
    
    .btn-custom:active {
      transform: translateY(-1px);
    }
    
    .btn-secondary {
      background: linear-gradient(135deg, #a78bfa 0%, #9370db 100%);
      border: none;
      border-radius: 15px;
      padding: 16px 32px;
      font-weight: 700;
      font-size: 1.1rem;
      color: white;
      transition: all 0.3s ease;
      box-shadow: 0 8px 20px rgba(167, 139, 250, 0.3);
    }
    
    .btn-secondary:hover {
      background: linear-gradient(135deg, #9370db 0%, #8a5cdb 100%);
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(167, 139, 250, 0.4);
    }
    
    /* Footer estilizado */
    footer { 
      background: linear-gradient(135deg, #4ecdc4 0%, #44a8a0 100%);
      padding: 20px;
      text-align: center;
      margin-top: 50px;
      color: #fff;
      box-shadow: 0 -8px 32px rgba(78, 205, 196, 0.3);
      border-top: 3px solid rgba(255, 255, 255, 0.3);
      position: relative;
      z-index: 1;
    }
    
    footer p {
      margin: 0;
      font-family: 'Fredoka', 'Nunito', sans-serif;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }
    
    /* Alerts */
    .alert {
      border-radius: 15px;
      border: none;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      font-weight: 600;
    }
    
    .alert-success {
      background: linear-gradient(135deg, #4ecdc4 0%, #44a8a0 100%);
      color: white;
    }
    
    .alert-danger {
      background: linear-gradient(135deg, #ff6b9d 0%, #ff558a 100%);
      color: white;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
  <div class="container-fluid px-4">
    <a href="painelUsuario.php" class="navbar-brand fw-bold"><span class="brand-icon">🐾</span>Painel do Usuário</a>
  </div>
</nav>

<main class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-8">
      <div class="card-pet">
        <h3 class="mb-3 text-center section-title">Cadastrar Animal para Adoção</h3>
        <p class="text-center small-note">Preencha os dados do pet que você quer disponibilizar para adoção. 🐕🐱</p>

        <?php
        // Exibe mensagem de erro se houver
        if(isset($_SESSION['erro'])){
            echo "<div class='alert alert-danger alert-dismissible fade show mt-3' role='alert'>
                    <strong>{$_SESSION['erro']}</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                  </div>";
            unset($_SESSION['erro']);
        }
        
        // Exibe mensagem de sucesso se houver
        if(isset($_SESSION['sucesso'])){
            echo "<div class='alert alert-success alert-dismissible fade show mt-3' role='alert'>
                    <strong>{$_SESSION['sucesso']}</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                  </div>";
            unset($_SESSION['sucesso']);
        }

        ?>

        <!--Formulario de cadastro de animal-->
        <form method="POST" action="salvarAnimal.php" enctype="multipart/form-data" class="row g-3 mt-2">
          
          <div class="col-md-12">
            <label class="form-label">Nome do Animal</label>
            <input type="text" name="nome" class="form-control" placeholder="Ex: Totó, Mimi, Rex..." required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Tipo</label>
            <select name="tipo" class="form-select" required>
              <option value="">Selecione...</option>
              <option value="Cachorro">🐕 Cachorro</option>
              <option value="Gato">🐱 Gato</option>
              <option value="Coelho">🐰 Coelho</option>
              <option value="Pássaro">🐦 Pássaro</option>
              <option value="Hamster">🐹 Hamster</option>
              <option value="Outros">🐾 Outros</option>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">Raça</label>
            <input type="text" name="raca" class="form-control" placeholder="Ex: Vira-lata, Persa, SRD..." required>
          </div>

          <div class="col-md-4">
            <label class="form-label">Idade</label>
            <input type="text" name="idade" class="form-control" placeholder="Ex: 2 anos, 6 meses..." required>
          </div>


          <div class="col-md-4">
            <label class="form-label">Sexo</label>
            <select name="sexo" class="form-select" required>
              <option value="">Selecione...</option>
              <option value="Macho">Macho</option>
              <option value="Fêmea">Fêmea</option>
            </select>
          </div>

          <div class="col-md-12">
            <label class="form-label">Descrição / Características</label>
            <textarea name="descricao" class="form-control" placeholder="Conte um pouco sobre o temperamento, cuidados especiais, histórico do animal..." required></textarea>
          </div>


          <div class="col-md-12">
            <label class="form-label">Foto do Animal (opcional)</label>
            <input type="file" name="foto" class="form-control" accept="image/*">
            <small class="text-muted">Formatos aceitos: JPG, PNG, GIF (máx. 5MB)</small>
          </div>

          <div class="col-12 d-grid gap-2 d-md-flex justify-content-md-end mt-4">
            <a href="painelUsuario.php" class="btn btn-secondary">
              ← Voltar
            </a>
            <button type="submit" class="btn btn-custom">
              💾 Cadastrar Animal
            </button>
          </div>
        </form>

      </div>
    </div>
  </div>
</main>

<footer>
  <p class="fw-bold">PetShop Adoção - Sistema de Cadastro de Animais</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
