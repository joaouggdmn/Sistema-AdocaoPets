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
  </style>
</head>
<body>

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
