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
      --pet-primary: #FF6B6B;
      --pet-secondary: #4ECDC4;
      --pet-accent: #FFE66D;
      --pet-dark: #2d3748;
    }
    
    html,body{height:100%; margin:0; padding:0;}
    
    body {
      font-family: 'Nunito', system-ui, -apple-system, 'Segoe UI', Roboto, Arial;
      background: linear-gradient(135deg, #e8f5f4 0%, #d4f1ee 100%);
      color: var(--pet-dark);
      padding-bottom:40px;
      min-height: 100vh;
    }
    
    /* Navbar */
    .navbar {
      background: linear-gradient(135deg, #4ECDC4 0%, #44b8b0 100%);
      box-shadow: 0 4px 12px rgba(78, 205, 196, 0.3);
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
      color: var(--pet-secondary);
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
    .form-control, .form-select {
      border: 2px solid #e2e8f0;
      border-radius: 12px;
      padding: 14px 18px;
      font-size: 1rem;
      transition: all 0.3s ease;
      background: white;
    }
    
    .form-control:focus, .form-select:focus{ 
      box-shadow: 0 0 0 3px rgba(78, 205, 196, 0.2);
      border-color: var(--pet-secondary);
      outline: none;
    }
    
    .form-control::placeholder {
      color: #cbd5e0;
    }
    
    textarea.form-control {
      min-height: 120px;
      resize: vertical;
    }
    
    /* Botão limpo */
    .btn-custom {
      background: linear-gradient(135deg, #4ECDC4 0%, #44b8b0 100%);
      color: #fff;
      border: none;
      border-radius: 12px;
      padding: 16px 32px;
      font-weight: 700;
      font-size: 1.1rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      box-shadow: 0 6px 16px rgba(78, 205, 196, 0.3);
      transition: all 0.3s ease;
    }
    
    .btn-custom:hover{ 
      background: linear-gradient(135deg, #44b8b0 0%, #3ba89e 100%);
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(78, 205, 196, 0.4);
    }
    
    .btn-secondary {
      background: #6c757d;
      border: none;
      border-radius: 12px;
      padding: 16px 32px;
      font-weight: 700;
      font-size: 1.1rem;
      color: white;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
    }
    
    .btn-secondary:hover {
      background: #5a6268;
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(108, 117, 125, 0.4);
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
    
    /* Alerts */
    .alert {
      border-radius: 15px;
      border: none;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      font-weight: 600;
    }
    
    .alert-success {
      background: linear-gradient(135deg, #4ECDC4 0%, #44b8b0 100%);
      color: white;
    }
    
    .alert-danger {
      background: linear-gradient(135deg, #FF6B6B 0%, #ff5252 100%);
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
