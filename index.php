<?php require 'config.php';
session_start(); ?>
<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Adoção</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800&family=Fredoka:wght@400;600&family=Poppins:wght@700;800;900&display=swap" rel="stylesheet">
  <style>
    :root {
      --pet-primary: #fa725dff;
      --pet-secondary: #4ECDC4;
      --pet-accent: #FFE66D;
      --pet-dark: #2d3748;
      --pet-light: #f7f7f7;
    }

    body {
      font-family: 'Nunito', system-ui, -apple-system, 'Segoe UI', Roboto, Arial;
      background: linear-gradient(135deg, #A9CBB7 0%, #FFF3E2 100%);
      color: var(--pet-dark);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      margin: 0;
    }

    /* Navbar */
    .navbar {
      position: relative;
      z-index: 1000;
      background-color: #f7c58dff;
      border-bottom: 2px solid rgba(255, 255, 255, 0.2);
    }

    .navbar .navbar-brand {
      align-items: center;
      display: flex;
      color: #000000ff !important;
      font-family: 'Fredoka', 'Nunito', sans-serif;
      font-size: 1.5rem;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
      transition: transform 0.3s ease;
    }

    .navbar .navbar-brand:hover {
      transform: translateY(-2px);
    }

    .brand-icon {
      font-size: 1.8rem;
      margin-right: 8px;
      display: inline-block;
    }

    /* Botões da Navbar */
    .btn-nav-login {
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

    .btn-nav-login:hover {
      background: #6ec275ff;
      color: #FFF3E2;
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(109, 159, 113, 0.4);
    }

    .btn-nav-cadastro {
      background: linear-gradient(135deg, #6D9F71 0%, #309439ff 100%);
      border: none;
      color: #FFF3E2;
      font-weight: 700;
      padding: 10px 24px;
      border-radius: 12px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(109, 159, 113, 0.4);
      text-decoration: none;
      display: inline-block;
    }

    .btn-nav-cadastro:hover {
      background: linear-gradient(135deg, #5a8a5e 0%, #58a55fff 100%);
      color: #FFF3E2;
      transform: translateY(-2px);
      box-shadow: 0 6px 18px rgba(109, 159, 113, 0.5);
    }

    main {
      padding-bottom: 50px;
    }

    /* Hero Card - Efeito Glassmorphism */
    .hero-card {
      padding: 35px;
    }

    /* Título */
    h3.section-title {
      color: var(--pet-primary);
      font-weight: 800;
      font-family: 'Fredoka', 'Nunito', sans-serif;
      font-size: 2.5rem;
    }

    /* Botão principal */
    .btn-primary-custom {
      background: linear-gradient(135deg, #d69040ff 0%, #c47f35 100%);
      border: none;
      border-radius: 12px;
      padding: 16px 32px;
      font-weight: 700;
      font-size: 1.1rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      box-shadow: 0 6px 16px rgba(214, 144, 64, 0.3);
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      color: white;
      position: relative;
      overflow: hidden;
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
      transition: width 0.6s ease, height 0.6s ease;
    }

    .btn-primary-custom:hover::before {
      width: 300px;
      height: 300px;
    }

    .btn-primary-custom:hover {
      background: linear-gradient(135deg, #c47f35 0%, #b87030 100%);
      transform: translateY(-3px) scale(1.02);
      box-shadow: 0 10px 25px rgba(214, 144, 64, 0.5);
      color: white;
      letter-spacing: 1.5px;
    }

    .btn-primary-custom:active {
      transform: translateY(-1px) scale(0.98);
      box-shadow: 0 5px 15px rgba(214, 144, 64, 0.4);
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

    .table thead {
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

    .table tbody tr {
      transition: all 0.3s ease;
      background: white;
    }

    .table tbody tr:hover {
      background: rgba(78, 205, 196, 0.08);
      transform: translateX(2px);
    }

    /* Botões de ação */
    .action-btn {
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
    .banner {
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
      padding: 200px;
    }

    .banner h1 {
      font-family: 'Poppins', sans-serif;
      font-size: 4.5rem;
      font-weight: 700;
      color: #FFF3E2;
      margin-bottom: 25px;
      line-height: 1.2;
      text-shadow: 4px 4px 8px rgba(0, 0, 0, 0.7);
      letter-spacing: 1px;
      animation: zoomIn 1.2s ease-out;
    }

    .banner p {
      font-family: 'Nunito', sans-serif;
      font-size: 2rem;
      font-weight: 800;
      color: #6ec275ff;
      text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.7);
      letter-spacing: 0.5px;
      animation: slideInLeft 1.2s ease-out 0.3s backwards;
    }

    @keyframes zoomIn {
      from {
        opacity: 0;
        transform: scale(0.8);
      }

      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    @keyframes slideInLeft {
      from {
        opacity: 0;
        transform: translateX(-100px);
      }

      to {
        opacity: 1;
        transform: translateX(0);
      }
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

    /* Animação para Nosso Objetivo */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .objetivo-title {
      opacity: 0;
    }

    .objetivo-title.animate {
      animation: fadeInUp 1s ease-out forwards;
    }

    /* Footer */
    footer {
      background: #119b4bff;
      padding: 20px;
      text-align: center;
      margin-top: auto;
      color: #FFF3E2;
      box-shadow: 0 -4px 12px rgba(78, 205, 196, 0.2);
      border-top: 2px solid rgba(255, 255, 255, 0.2);
    }

    footer p {
      margin: 0;
      font-family: 'Fredoka', 'Nunito', sans-serif;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }

    footer a:hover {
      color: #6D9F71 !important;
      transform: translateX(5px);
    }
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid px-4">
      <a style="margin-left: 30px;"><img src="assets/img/logorealista.png" alt="logo aucolher"></a>
      <div class="d-flex gap-3" style="margin-right: 30px;">
        <a href="#login-section" class="btn-nav-login">
          Login
        </a>
        <img src="assets/img/pata.png" alt="pata">
        <a href="public/cadastroUsuario.php" class="btn-nav-cadastro">
          Cadastre-se
        </a>
      </div>
    </div>
  </nav>
  <section style="background: #FFF3E2;">
    <div class="banner">
      <div class="banner-content">
        <h1>Encontre seu AUmigo para a vida!</h1>
        <p>Não compre felicidade — adote!</p>
      </div>
    </div>
  </section>


  <!-- Seção Sobre o Projeto -->
  <section class="py-5" style="background: #FFF3E2; ">
    <div class="container" style="margin-top: 50px;">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <h2 class="objetivo-title" style="font-family: 'Poppins', sans-serif; font-weight: 800; color: #d69040ff; font-size: 2.8rem; margin-bottom: 25px;">
            <img src="assets/img/logominimalista.png" alt="pata"> Nosso Objetivo
          </h2>
          <p style="font-size: 1.2rem; color: #4a5568; line-height: 1.8; margin-bottom: 20px;">
            O <strong style="color: #119b4bff;">Projeto AUcolher</strong> nasceu com a missão de conectar corações humanos a patinhas que precisam de um lar. Acreditamos que todo animal merece amor, cuidado e uma segunda chance.
          </p>
          <p style="font-size: 1.2rem; color: #4a5568; line-height: 1.8; margin-bottom: 30px;">
            Nossa plataforma facilita o processo de adoção, permitindo que pessoas encontrem seus companheiros ideais e transformem vidas através do amor incondicional.
          </p>

        </div>
      </div>
    </div>
  </section>
  <section style="background: linear-gradient( #FFF3E2, #6D9F71);" id="login-section">
    <main class="container mt-5">
      <div class="row justify-content-center align-items-center">
        <div class="col-12 col-md-6 col-lg-5">
          <div class="hero-card mb-4">
            <h3 class="mb-4 section-title text-center" style="color: #d69040ff;">Bem-vindo de volta!</h3>
            <p class="text-center" style="font-size: 1.1rem; color: #4a5568; font-weight: 600; margin-bottom: 25px;">Faça login para encontrar seu AUmigão.</p>
            <form action="auth/validaLogin.php" method="POST">
              <div class="mb-3">
                <label class="form-label fw-bold">📧 E-mail</label>
                <input type="email" name="email_usuario" class="form-control" placeholder="seu@email.com" required style="border: 2px solid #e2e8f0; border-radius: 12px; padding: 14px 18px;">
              </div>

              <div class="mb-4">
                <label class="form-label fw-bold">🔒 Senha</label>
                <input type="password" name="senha" class="form-control" placeholder="Digite sua senha" required style="border: 2px solid #e2e8f0; border-radius: 12px; padding: 14px 18px;">
              </div>

              <?php if (isset($_SESSION['erro'])): ?>
                <div class="text-danger text-center mt-3" style="margin-bottom: 20px;">
                  <?= $_SESSION['erro'];
                  unset($_SESSION['erro']); ?>
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
              <a href="public/cadastroUsuario.php" class="text-decoration-none fw-bold" style="color: #008638ff; font-size: 1.1rem;">
                🐾 Cadastre-se aqui
              </a>
            </div>
          </div>
        </div>

        <div class="col-12 col-md-6 col-lg-5 text-center">
          <img src="assets/img/dognoCarro.png" alt="Pet" style="border-radius: 20px; box-shadow: 0 8px 24px rgba(0,0,0,0.15);">
        </div>
      </div>
    </main>
  </section>


  <footer style="background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%); padding: 50px 0 30px 0; margin-top: auto; color: #e2e8f0; box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.15); border-top: 3px solid #d69040ff;">
    <div class="container">
      <div class="row">
        <!-- Coluna 1: Sobre -->
        <div class="col-md-4 mb-4">
          <h5 style="font-family: 'Fredoka', sans-serif; font-weight: 700; color: #d69040ff; margin-bottom: 20px; font-size: 1.3rem;">
            <img src="assets/img/patamenor.png" alt="logo AUcolher"> Projeto AUcolher
          </h5>
          <p style="color: #cbd5e0; line-height: 1.8; font-size: 0.95rem;">
            Conectando corações a patinhas desde 2025. Nossa missão é proporcionar um lar cheio de amor para cada animal que precisa de uma segunda chance.
          </p>
        </div>

        <!-- Coluna 2: Links Rápidos -->
        <div class="col-md-4 mb-4">
          <h5 style="font-family: 'Fredoka', sans-serif; font-weight: 700; color: #d69040ff; margin-bottom: 20px; font-size: 1.3rem;">
            Links Rápidos
          </h5>
          <ul style="list-style: none; padding: 0; line-height: 2.2;">
            <li><a href="#login-section" style="color: #cbd5e0; text-decoration: none; transition: all 0.3s; display: inline-block;">→ Login</a></li>
            <li><a href="public/cadastroUsuario.php" style="color: #cbd5e0; text-decoration: none; transition: all 0.3s; display: inline-block;">→ Cadastre-se</a></li>
            <li><a href="#" style="color: #cbd5e0; text-decoration: none; transition: all 0.3s; display: inline-block;">→ Como Adotar</a></li>
            <li><a href="#" style="color: #cbd5e0; text-decoration: none; transition: all 0.3s; display: inline-block;">→ Sobre Nós</a></li>
          </ul>
        </div>

        <!-- Coluna 3: Contato -->
        <div class="col-md-4 mb-4">
          <h5 style="font-family: 'Fredoka', sans-serif; font-weight: 700; color: #d69040ff; margin-bottom: 20px; font-size: 1.3rem;">
            Fale Conosco
          </h5>
          <p style="color: #cbd5e0; line-height: 2; font-size: 0.95rem;">
            📧 <a href="mailto:losgoatsdecedup@gmail.com" style="color: #6D9F71; text-decoration: none;">losgoatsdecedup@gmail.com</a><br>
            📱 <span style="color: #cbd5e0;">(48) 99662-1945</span><br>
            📍 <span style="color: #cbd5e0;">Criciúma, SC - Brasil</span>
          </p>
          <p style="color: #cbd5e0; font-size: 0.9rem; margin-top: 20px; font-style: italic;">
            "A grandeza de uma nação pode ser julgada pelo modo como seus animais são tratados." - Gandhi
          </p>
        </div>
      </div>

      <hr style="border-color: rgba(214, 144, 64, 0.3); margin: 30px 0 20px 0;">

      <div class="text-center">
        <p style="color: #a0aec0; font-size: 0.9rem; margin: 0; font-family: 'Nunito', sans-serif;">
          © 2025 <strong style="color: #d69040ff;">Projeto AUcolher</strong> • Todos os direitos reservados • Feito com ❤️ para os animais
        </p>
      </div>
    </div>
  </footer>

  <script>
    // Intersection Observer para animar quando a seção entrar na viewport
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('animate');
        }
      });
    }, {
      threshold: 0.5 // Anima quando 50% da seção estiver visível
    });

    // Observa o título
    const objetivoTitle = document.querySelector('.objetivo-title');
    if (objetivoTitle) {
      observer.observe(objetivoTitle);
    }
  </script>

</body>

</html>