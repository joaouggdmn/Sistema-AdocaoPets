<?php
session_start();
require 'config.php';

if (!isset($_SESSION['logado']) || $_SESSION['nivel_usuario'] != 'usuario') {
  header("Location: index.php");
  exit;
}
?>
<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Painel do Usuário</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800&family=Fredoka:wght@400;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --pet-primary: #FF6B6B;
      --pet-secondary: #4ECDC4;
      --pet-accent: #FFE66D;
      --pet-dark: #2d3748;
    }

    body {
      font-family: 'Nunito', sans-serif;
      background: linear-gradient(135deg, #A9CBB7 0%, #6D9F71 100%);
      min-height: 100vh;
    }

    .navbar {
      background: #f7c58dff;
      box-shadow: 0 4px 12px rgba(247, 197, 141, 0.3);
      border-bottom: 2px solid rgba(255, 255, 255, 0.2);
    }

    .navbar a {
      color: #2d3748 !important;
      font-family: 'Fredoka', 'Nunito', sans-serif;
      text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.5);
    }

    .card {
      background: white;
      border: none;
      border-radius: 20px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-warning {
      background: linear-gradient(135deg, #d69040ff 0%, #c47f35 100%);
      border: none;
      color: white;
      font-weight: 700;
      border-radius: 12px;
      padding: 10px 24px;
      box-shadow: 0 4px 12px rgba(214, 144, 64, 0.3);
      transition: all 0.3s ease;
    }

    .btn-warning:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(214, 144, 64, 0.4);
      background: linear-gradient(135deg, #c47f35 0%, #b87030 100%);
      color: white;
    }

    .btn-light {
      background: rgba(255, 255, 255, 0.95);
      border: 2px solid rgba(255, 255, 255, 0.5);
      color: var(--pet-dark);
      font-weight: 700;
      border-radius: 12px;
      padding: 10px 20px;
      transition: all 0.3s ease;
    }

    .btn-light:hover {
      background: white;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(255, 255, 255, 0.4);
      color: var(--pet-dark);
    }

    h3 {
      color: #d69040ff;
      font-weight: 800;
      font-family: 'Fredoka', sans-serif;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15) !important;
    }

    .alert {
      border-radius: 15px;
      border: none;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .alert-success {
      background: linear-gradient(135deg, #6D9F71 0%, #5a8a5e 100%);
      color: white;
      border-left: 5px solid #119b4bff;
    }

    .alert-danger {
      background: linear-gradient(135deg, #FF6B6B 0%, #ff5252 100%);
      color: white;
      border-left: 5px solid #ff3838;
    }

    .btn-sm {
      border-radius: 10px;
      font-weight: 700;
      padding: 8px 12px;
      font-size: 0.85rem;
      transition: all 0.3s ease;
    }

    .btn-danger {
      background: linear-gradient(135deg, #FF6B6B 0%, #ff5252 100%);
      border: none;
    }

    .btn-danger:hover {
      background: linear-gradient(135deg, #ff5252 0%, #ff3838 100%);
      transform: translateY(-2px);
    }

    /* Animação para botão de cadastrar animal */
    .btn-cadastrar-animal {
      position: relative;
      overflow: hidden;
      z-index: 1;
    }

    .btn-cadastrar-animal::before {
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
      z-index: -1;
    }

    .btn-cadastrar-animal:hover::before {
      width: 300px;
      height: 300px;
    }

    .btn-cadastrar-animal:hover {
      transform: translateY(-3px) scale(1.05);
      box-shadow: 0 10px 30px rgba(214, 144, 64, 0.5);
    }

    /* Animação para botão de adotar animal */
    .btn-adotar-animal {
      position: relative;
      overflow: hidden;
      z-index: 1;
      border-radius: 12px;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .btn-adotar-animal::before {
      content: '❤️';
      position: absolute;
      top: 50%;
      left: 50%;
      font-size: 0;
      transform: translate(-50%, -50%);
      transition: font-size 0.5s ease;
      z-index: -1;
    }

    .btn-adotar-animal:hover::before {
      font-size: 80px;
      opacity: 0.2;
    }

    .btn-adotar-animal:hover {
      transform: translateY(-4px) scale(1.08);
      box-shadow: 0 12px 35px rgba(17, 155, 75, 0.6);
      background: linear-gradient(135deg, #0d7a3c 0%, #119b4bff 100%);
    }

    @keyframes pulse {
      0% {
        box-shadow: 0 0 0 0 rgba(17, 155, 75, 0.7);
      }

      70% {
        box-shadow: 0 0 0 10px rgba(17, 155, 75, 0);
      }

      100% {
        box-shadow: 0 0 0 0 rgba(17, 155, 75, 0);
      }
    }

    .btn-adotar-animal:active {
      animation: pulse 0.5s;
      transform: scale(0.95);
    }

    /* Sidebar fixa à esquerda */
    .sidebar-left {
      position: fixed;
      left: 0;
      top: 0;
      width: 90px;
      height: 100vh;
      background: linear-gradient(180deg, #f7c58dff 0%, #d69040ff 100%);
      backdrop-filter: blur(10px);
      box-shadow: 4px 0 12px rgba(0, 0, 0, 0.15);
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 20px 0 15px 0;
      gap: 12px;
      z-index: 1000;
      border-right: 3px solid rgba(255, 255, 255, 0.3);
      overflow-y: auto;
      overflow-x: hidden;
    }

    .sidebar-left::-webkit-scrollbar {
      width: 5px;
    }

    .sidebar-left::-webkit-scrollbar-track {
      background: rgba(255, 255, 255, 0.1);
    }

    .sidebar-left::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, 0.3);
      border-radius: 10px;
    }

    .sidebar-left .logo-container {
      width: 60px;
      height: 60px;
      margin-bottom: 10px;
      border-radius: 50%;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
      flex-shrink: 0;
    }

    .sidebar-left .logo-container img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .sidebar-left .nav-btn {
      width: 55px;
      height: 55px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.7rem;
      transition: all 0.3s ease;
      cursor: pointer;
      border: 3px solid rgba(255, 255, 255, 0.4);
      position: relative;
      text-decoration: none;
      flex-shrink: 0;
    }

    .sidebar-left .nav-btn:hover {
      transform: scale(1.15) rotate(5deg);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
      border-color: white;
    }

    .sidebar-left .nav-btn.green {
      background: linear-gradient(135deg, #119b4bff 0%, #0d7a3c 100%);
    }

    .sidebar-left .nav-btn.gold {
      background: linear-gradient(135deg, #d69040ff 0%, #c47f35 100%);
    }

    .sidebar-left .nav-btn.red {
      background: linear-gradient(135deg, #FF6B6B 0%, #ff5252 100%);
    }

    .sidebar-left .nav-btn .tooltip-text {
      visibility: hidden;
      background-color: rgba(45, 55, 72, 0.95);
      color: white;
      text-align: center;
      border-radius: 8px;
      padding: 8px 15px;
      position: absolute;
      z-index: 1;
      left: 80px;
      white-space: nowrap;
      font-size: 0.9rem;
      font-weight: 700;
      opacity: 0;
      transition: opacity 0.3s;
      font-family: 'Fredoka', sans-serif;
    }

    .sidebar-left .nav-btn:hover .tooltip-text {
      visibility: visible;
      opacity: 1;
    }

    .sidebar-left .divider {
      width: 50%;
      height: 2px;
      background: rgba(255, 255, 255, 0.4);
      margin: 5px 0;
      flex-shrink: 0;
    }

    .sidebar-left .divider-primeiro {
      width: 50%;
      height: 2px;
      background: rgba(255, 255, 255, 0.4);
      margin: 5px 0;
      flex-shrink: 0;
    }

    @media (max-width: 768px) {
      .sidebar-left {
        width: 70px;
        gap: 10px;
        padding: 15px 0 10px 0;
      }

      .sidebar-left .logo-container {
        width: 45px;
        height: 45px;
        margin-bottom: 5px;
      }

      .sidebar-left .nav-btn {
        width: 45px;
        height: 45px;
        font-size: 1.4rem;
      }
    }

    /* Animações para título motivacional */
    @keyframes fadeInDown {
      from {
        opacity: 0;
        transform: translateY(-30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes bounceIn {
      0% {
        opacity: 0;
        transform: scale(0.3);
      }
      50% {
        opacity: 1;
        transform: scale(1.05);
      }
      70% {
        transform: scale(0.9);
      }
      100% {
        transform: scale(1);
      }
    }

    .titulo-animado {
      animation: fadeInDown 1s ease-out;
    }

    .subtitulo-animado {
      animation: bounceIn 1.2s ease-out 0.3s backwards;
    }
  </style>
</head>

<body style="padding-left: 90px;">
  <!-- Sidebar fixa à esquerda -->
  <div class="sidebar-left">
    <div class="logo-container">
      <img src="img/logorealista2.png" alt="logo">
    </div>


   
    <a href="#animais_cadastrados" class="nav-btn gold" style="margin-top: 60px;">
      <img src="img/gato.png" alt="gato">
      <span class="tooltip-text">Cadastrar Animal</span>
    </a>
     <a href="#animais-adocao" class="nav-btn green">
      <img src="img/casa.png" alt="casa">
      <span class="tooltip-text">Animais para Adoção</span>
    </a>
    <a href="#meus-adotados" class="nav-btn green">
      <img src="img/coracaoverde.png" alt="coração verde">
      <span class="tooltip-text">Meus Adotados</span>
    </a>

    <div class="divider"></div>

    <a href="editarUsuarioUSER.php" class="nav-btn gold">
      <span>✏️</span>
      <span class="tooltip-text">Editar Perfil</span>
    </a>

    <a href="logout.php" class="nav-btn gold" onclick="return confirm('🚪 Você realmente deseja sair do sistema?')">
      <span>🚪</span>
      <span class="tooltip-text">Sair</span>
    </a>
  </div>

  <div class="container">
    <!-- Título motivacional no topo -->
    <div class="text-center" style="margin-top: 30px; margin-bottom: 30px; padding: 15px;">
      <h1 class="titulo-animado" style="font-family: 'Fredoka', sans-serif; font-weight: 800; color: #d48224ff; font-size: 2.2rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.1);">
        Bem-vindo, <span style="color: #496b4cff;"><?= $_SESSION['nome_usuario']; ?></span>! <br> Seu novo melhor amigo tem quatro patas 
        e está te esperando.
      </h1>
      <p class="subtitulo-animado" style="font-size: 1.2rem; color: #2d3748; font-weight: 600; margin-top: 15px; line-height: 1.6;">
        Adote. Ame. Acolha.<br>
      </p>
    </div>

    <div id="animais_cadastrados" class="card p-4" style="margin-top: 40px;">
      <h4 style="color: var(--pet-dark); font-weight: 700; margin-bottom: 20px;">
        <img src="img/gato.png" alt="gato"> Meus Animais
      </h4>

      <div class="text-center mb-4">
        <p class="text-muted">Cadastre animais disponíveis para adoção e ajude a encontrar um lar para eles!</p>
        <a href="cadastroAnimal.php" class="btn btn-warning btn-lg mt-2 btn-cadastrar-animal">
          <span style="font-size: 1.3rem;">🐈</span> Cadastrar Novo Animal
        </a>
      </div>

      <hr class="my-4">

      <!-- Lista dos animais cadastrados pelo usuário -->
      <?php
      // Pega o id_usuario da sessão (tabela usuarios) para buscar na coluna usuario_id da tabela animais
      $id_usuario_sessao = $_SESSION['id_usuario'];
      $sql = "SELECT * FROM animais WHERE usuario_id = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $id_usuario_sessao);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
        echo "<div class='row g-4'>";
        while ($animal = $result->fetch_assoc()) {
          $foto = $animal['foto_animal'] ? 'uploads/' . $animal['foto_animal'] : 'https://via.placeholder.com/300x200?text=Sem+Foto';
          $status_class = $animal['status_adocao'] == 'Adotado' ? 'bg-secondary' : 'bg-success';

          echo "
            <div class='col-md-6 col-lg-4'>
              <div class='card h-100' style='border-radius: 20px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.1); transition: all 0.3s ease;'>
                <img src='{$foto}' class='card-img-top' alt='{$animal['nome_animal']}' style='height: 200px; object-fit: cover;'>
                <span class='badge {$status_class} position-absolute top-0 end-0 m-2' style='font-size: 0.85rem;'>{$animal['status_adocao']}</span>
                <div class='card-body'>
                  <h5 class='card-title' style='color: #d69040ff; font-weight: 800;'>{$animal['nome_animal']} 🐾</h5>
                  <p class='card-text mb-2'>
                    <strong>{$animal['tipo_animal']}</strong> • {$animal['raca_animal']}<br>
                    <small class='text-muted'>
                      {$animal['sexo_animal']} • {$animal['idade_animal']}
                    </small>
                  </p>
                  <p class='card-text' style='font-size: 0.9rem;'>{$animal['descricao_animal']}</p>
                  <div class='d-flex gap-2 mt-3'>
                    <a href='editarAnimal.php?id={$animal['id_animal']}' class='btn btn-warning btn-sm flex-fill'>✏️ Editar</a>
                    <a href='excluirAnimal.php?id={$animal['id_animal']}' class='btn btn-danger btn-sm flex-fill' onclick='return confirm(\"Tem certeza que deseja excluir este animal?\")'>🗑️ Excluir</a>
                  </div>
                </div>
              </div>
            </div>";
        }
        echo "</div>";
      } else {
        echo "
        <div class='alert text-center' style='background: linear-gradient(135deg, #ffd93d 0%, #ffed4e 100%); border: none; border-radius: 15px; padding: 30px;'>
          <h5 style='color: var(--pet-dark); font-weight: 700;'> Nenhum animal cadastrado ainda!</h5>
          <p class='mb-0'>Comece agora a ajudar pets a encontrarem um novo lar!</p>
        </div>";
      }
      $stmt->close();
      ?>
    </div>

    <?php
    // Exibe mensagem de sucesso se houver
    if (isset($_SESSION['sucesso'])) {
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert' style='border-radius: 15px; border-left: 5px solid #119b4bff; margin-top: 20px;'>
              <strong>{$_SESSION['sucesso']}</strong>
              <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            </div>";
      unset($_SESSION['sucesso']);
    }
    // Exibe mensagem de erro se houver
    if (isset($_SESSION['erro'])) {
      echo "<div class='alert alert-danger alert-dismissible fade show' role='alert' style='border-radius: 15px; border-left: 5px solid #ff6b9d;'>
              <strong>{$_SESSION['erro']}</strong>
              <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            </div>";
      unset($_SESSION['erro']);
    }
    ?>
  
    <!-- Seção de Animais Disponíveis para Adoção (de outros usuários) -->
    <div id="animais-adocao" class="card p-4 mt-4" style="scroll-margin-top: 100px;">
      <h4 style="color: var(--pet-dark); font-weight: 700; margin-bottom: 20px;">
        <img src="img/casa.png" alt="casa"> Animais Disponíveis para Adoção
      </h4>

      <p class="text-muted text-center mb-4">Veja todos os pets cadastrados por outros usuários que estão procurando um lar!</p>
      <hr class="my-4">

      <!-- Lista de animais cadastrados por OUTROS usuários -->
      <?php
      // Busca animais de outros usuários que estão disponíveis para adoção
      $sql_outros = "SELECT a.*, u.nome_usuario 
                   FROM animais a 
                   INNER JOIN usuarios u ON a.usuario_id = u.id_usuario 
                   WHERE a.usuario_id != ? AND a.status_adocao = 'Disponível'
                   ORDER BY a.id_animal DESC";
      $stmt_outros = $conn->prepare($sql_outros);
      $stmt_outros->bind_param("i", $id_usuario_sessao);
      $stmt_outros->execute();
      $result_outros = $stmt_outros->get_result();

      if ($result_outros->num_rows > 0) {
        echo "<div class='row g-4'>";
        while ($animal = $result_outros->fetch_assoc()) {
          $foto = $animal['foto_animal'] ? 'uploads/' . $animal['foto_animal'] : 'https://via.placeholder.com/300x200?text=Sem+Foto';

          echo "
            <div class='col-md-6 col-lg-4'>
              <div class='card h-100' style='border-radius: 20px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.1); transition: all 0.3s ease;'>
                <img src='{$foto}' class='card-img-top' alt='{$animal['nome_animal']}' style='height: 200px; object-fit: cover;'>
                <span class='badge bg-success position-absolute top-0 end-0 m-2' style='font-size: 0.85rem;'>Disponível</span>
                <div class='card-body'>
                  <h5 class='card-title' style='color: var(--pet-primary); font-weight: 800;'>{$animal['nome_animal']} 🐾</h5>
                  <p class='card-text mb-2'>
                    <strong>{$animal['tipo_animal']}</strong> • {$animal['raca_animal']}<br>
                    <small class='text-muted'>
                      {$animal['sexo_animal']} • {$animal['idade_animal']}
                    </small>
                  </p>
                  <p class='card-text' style='font-size: 0.9rem;'>{$animal['descricao_animal']}</p>
                  <div class='mt-3 p-2' style='background: linear-gradient(135deg, rgba(109, 159, 113, 0.1) 0%, rgba(90, 138, 94, 0.1) 100%); border-radius: 10px;'>
                    <small><strong>📞 Cadastrado por:</strong> {$animal['nome_usuario']}</small>
                  </div>
                  <div class='d-grid mt-3'>
                    <a href='adotarAnimal.php?id={$animal['id_animal']}' class='btn btn-adotar-animal' style='background: linear-gradient(135deg, #119b4bff 0%, #0d7a3c 100%); color: white; font-weight: 700;' onclick='return confirm(\"🐾 Você realmente deseja adotar {$animal['nome_animal']}? ❤️\")'>
                      💕 Adotar {$animal['nome_animal']}!
                    </a>
                  </div>
                </div>
              </div>
            </div>";
        }
        echo "</div>";
      } else {
        echo "
        <div class='alert text-center' style='background: linear-gradient(135deg, #c9fa6fff 0%, #5fd847ff 100%); color: white; border: none; border-radius: 15px; padding: 30px;'>
          <h5 style='color: white; font-weight: 700;'> Nenhum animal disponível no momento!</h5>
          <p class='mb-0'>Seja o primeiro a cadastrar um pet para adoção!</p>
        </div>";
      }
      $stmt_outros->close();
      ?>
    </div>

    <!-- Seção de Animais que eu Adotei -->
    <div id="meus-adotados" class="card p-4 mt-4" style="scroll-margin-top: 20px; margin-bottom: 40px;">
      <h4 style="color: var(--pet-dark); font-weight: 700; margin-bottom: 20px;">
        <img src="img/coracaoverde.png" alt="coração verde"> Meus Animais Adotados
      </h4>

      <p class="text-muted text-center mb-4">Animais que você adotou e agora fazem parte da sua família!</p>
      <hr class="my-4">

      <?php
      // Busca animais que o usuário atual adotou
      $sql_adotados = "SELECT * FROM animais WHERE adotante_id = ? ORDER BY id_animal DESC";
      $stmt_adotados = $conn->prepare($sql_adotados);
      $stmt_adotados->bind_param("i", $id_usuario_sessao);
      $stmt_adotados->execute();
      $result_adotados = $stmt_adotados->get_result();

      if ($result_adotados->num_rows > 0) {
        echo "<div class='row g-4'>";
        while ($animal = $result_adotados->fetch_assoc()) {
          $foto = $animal['foto_animal'] ? 'uploads/' . $animal['foto_animal'] : 'https://via.placeholder.com/300x200?text=Sem+Foto';

          echo "
            <div class='col-md-6 col-lg-4'>
              <div class='card h-100' style='border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(109, 159, 113, 0.3); transition: all 0.4s ease; border: none; background: linear-gradient(145deg, #ffffff 0%, #f5fff7 100%); position: relative;'>
                <div style='position: absolute; top: 0; left: 0; right: 0; height: 5px; background: linear-gradient(90deg, #6D9F71 0%, #119b4bff 50%, #6D9F71 100%); z-index: 10;'></div>
                <img src='{$foto}' class='card-img-top' alt='{$animal['nome_animal']}' style='height: 220px; object-fit: cover; border-bottom: 3px solid #6D9F71;'>
                <div style='position: absolute; top: 15px; right: 15px; background: linear-gradient(135deg, #6D9F71 0%, #5a8a5e 100%); padding: 8px 15px; border-radius: 20px; box-shadow: 0 4px 15px rgba(109, 159, 113, 0.4); border: 2px solid white;'>
                  <span style='font-size: 0.9rem; color: white; font-weight: 700; display: flex; align-items: center; gap: 5px;'>
                    <span style='font-size: 1.2rem;'>💚</span> Seu Pet!
                  </span>
                </div>
                <div class='card-body' style='padding: 25px;'>
                  <div style='text-align: center; margin-bottom: 15px; padding: 10px; background: linear-gradient(135deg, rgba(109, 159, 113, 0.1) 0%, rgba(90, 138, 94, 0.05) 100%); border-radius: 12px; border-left: 4px solid #6D9F71;'>
                    <h5 class='card-title' style='color: #6D9F71; font-weight: 800; margin: 0; font-size: 1.4rem; font-family: \"Fredoka\", sans-serif;'>{$animal['nome_animal']} 🐾</h5>
                  </div>
                  <div style='background: white; padding: 15px; border-radius: 12px; margin-bottom: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);'>
                    <p class='card-text mb-2' style='font-size: 0.95rem;'>
                      <strong style='color: #6D9F71;'>{$animal['tipo_animal']}</strong> • {$animal['raca_animal']}<br>
                      <small class='text-muted' style='display: flex; align-items: center; gap: 8px; margin-top: 8px;'>
                        <span>👤 {$animal['sexo_animal']}</span> • <span>📅 {$animal['idade_animal']}</span>
                      </small>
                    </p>
                    <p class='card-text' style='font-size: 0.9rem; color: #555; line-height: 1.5; margin-top: 10px;'>{$animal['descricao_animal']}</p>
                  </div>
                </div>
              </div>
            </div>";
        }
        echo "</div>";
      } else {
        echo "
        <div class='alert text-center' style='background:  #119b4bff; border: none; border-radius: 15px; padding: 30px;'>
          <h5 style='color: #FFF3E2; font-weight: 700;'> Você ainda não adotou nenhum animal!</h5>
          <p class='mb-0' style='color: #FFF3E2;'>Que tal dar um lar para um pet que precisa de você?</p>
        </div>";
      }
      $stmt_adotados->close();
      ?>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>