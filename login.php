<?php
session_start();
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Cadastro</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
 <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800&family=Fredoka:wght@400;600&display=swap" rel="stylesheet">
  <style>
    
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
        <h3 class="mb-3 text-center section-title">Login de usuário</h3>
        <p class="text-center small-note">Bem vindo de volta! <br>
    Preencha seus dados para reencontrar seus AUmigos.</p>

        <!--Formulario de login-->
        <form method="POST" action="validaLogin.php" class="row g-3 mt-2">

          <div class="col-md-12">
            <label class="form-label">E-mail</label>
            <input type="email" name="email" class="form-control" placeholder="seu@exemplo.com" required>
          </div>

          <div class="col-md-12">
            <label class="form-label">Senha</label>
            <input type="password" name="senha" class="form-control" placeholder="Digite sua senha" required>
          </div>

          <div class="col-12 d-grid mt-2">
            <button type="submit" class="btn btn-custom btn-lg">Entrar</button>
          </div>
          <?php if(isset($_SESSION['erro'])): ?>
      <div class="text-danger text-center mt-3">
        <?= $_SESSION['erro']; unset($_SESSION['erro']); ?>
      </div>
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

