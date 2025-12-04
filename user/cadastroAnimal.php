<?php
session_start();
require '../config.php';

// Verifica se está logado
if (!isset($_SESSION['logado'])) {
    header("Location: ../index.php#login-section");
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
  <link href="../css/forms.css" rel="stylesheet">
</head>
<body class="user-context">

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
        <form method="POST" action="../actions/salvarAnimal.php" enctype="multipart/form-data" class="row g-3 mt-2">
          
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
