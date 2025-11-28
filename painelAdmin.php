<?php
session_start();
require 'config.php';

if (!isset($_SESSION['logado']) || $_SESSION['nivel_usuario'] != 'admin') {
  header("Location: login.php");
  exit;
}
?>
<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Painel do Administrador</title>
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
      background: linear-gradient(135deg, #ffccc9ff 0%, #ff8839ff 100%);
      min-height: 100vh;
    }

    .card {
      background: white;
      border: none;
      border-radius: 20px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15) !important;
    }

    h3 {
      color: #d69040ff;
      font-weight: 800;
      font-family: 'Fredoka', sans-serif;
    }

    .table {
      background: white;
      border-radius: 20px;
      overflow: hidden;
    }

    .table thead {
      background: linear-gradient(135deg, #d69040ff 0%, #c47f35 100%);
    }

    .table thead th {
      font-weight: 800;
      color: white;
      padding: 18px 15px;
      border: none;
    }

    .table tbody tr {
      transition: all 0.3s ease;
    }

    .table tbody tr:hover {
      background: rgba(109, 159, 113, 0.08);
      transform: translateX(2px);
    }

    .btn-warning {
      background: linear-gradient(135deg, #d69040ff 0%, #c47f35 100%);
      border: none;
      color: white;
      font-weight: 700;
    }

    .btn-warning:hover {
      background: linear-gradient(135deg, #c47f35 0%, #b87030 100%);
      color: white;
    }

    .btn-danger {
      background: linear-gradient(135deg, #FF6B6B 0%, #ff5252 100%);
      border: none;
    }

    .btn-danger:hover {
      background: linear-gradient(135deg, #ff5252 0%, #ff3838 100%);
    }

    /* Sidebar fixa à esquerda */
    .sidebar-left {
      position: fixed;
      left: 0;
      top: 0;
      width: 90px;
      height: 100vh;
      background: linear-gradient(180deg, #fd6868ff 0%, #9b2e2eff 100%);
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
      font-size: 0.85rem;
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

    .alert-success {
      background: linear-gradient(135deg, #6D9F71 0%, #5a8a5e 100%);
      color: white;
      border-left: 5px solid #119b4bff;
      border-radius: 15px;
    }

    .alert-danger {
      background: linear-gradient(135deg, #FF6B6B 0%, #ff5252 100%);
      color: white;
      border-left: 5px solid #ff3838;
      border-radius: 15px;
    }

    .admin-container {
      margin-top: 40px;
    }

    .welcome-card {
      background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);
      border: none;
      box-shadow: 0 15px 40px rgba(255, 107, 107, 0.2);
      position: relative;
      overflow: hidden;
    }

    .welcome-card .decoration-circle-1 {
      position: absolute;
      top: -50px;
      right: -50px;
      width: 300px;
      height: 300px;
      background: radial-gradient(circle, rgba(255, 107, 107, 0.15) 0%, transparent 70%);
      border-radius: 50%;
    }

    .welcome-card .decoration-circle-2 {
      position: absolute;
      bottom: -30px;
      left: -30px;
      width: 200px;
      height: 200px;
      background: radial-gradient(circle, rgba(214, 144, 64, 0.1) 0%, transparent 70%);
      border-radius: 50%;
    }

    .welcome-card .top-bar {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 5px;
      background: linear-gradient(90deg, #FF6B6B 0%, #d69040ff 50%, #FF6B6B 100%);
    }

    .welcome-card .content {
      position: relative;
      z-index: 1;
    }

    .welcome-card .icon-container {
      background: linear-gradient(135deg, #FF6B6B 0%, #ff5252 100%);
      padding: 20px;
      border-radius: 20px;
      box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
      display: flex;
      align-items: center;
      justify-content: center;
      min-width: 80px;
      height: 80px;
    }

    .welcome-card .icon-container span {
      font-size: 3rem;
    }

    .welcome-card .welcome-header {
      display: flex;
      align-items: center;
      gap: 25px;
      margin-bottom: 20px;
    }

    .welcome-card .welcome-title {
      color: #FF6B6B;
      font-family: 'Fredoka', sans-serif;
      font-weight: 800;
      font-size: 2rem;
      margin: 0;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.05);
    }

    .welcome-card .username {
      color: #d69040ff;
    }

    .welcome-card .badges {
      margin-top: 12px;
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .welcome-card .badge-admin {
      background: linear-gradient(135deg, #FF6B6B 0%, #ff5252 100%);
      padding: 8px 20px;
      border-radius: 25px;
      color: white;
      font-size: 0.95rem;
      font-weight: 700;
      box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .welcome-card .badge-access {
      background: rgba(214, 144, 64, 0.15);
      padding: 8px 15px;
      border-radius: 20px;
      color: #d69040ff;
      font-size: 0.9rem;
      font-weight: 600;
      border: 2px solid rgba(214, 144, 64, 0.3);
    }

    .welcome-card .divider-line {
      height: 2px;
      background: linear-gradient(90deg, transparent 0%, rgba(255, 107, 107, 0.3) 50%, transparent 100%);
      margin: 20px 0;
    }

    .welcome-card .quick-actions {
      display: flex;
      gap: 20px;
      justify-content: space-around;
      margin-top: 15px;
    }

    .welcome-card .action-item {
      text-align: center;
      padding: 15px;
      border-radius: 15px;
      flex: 1;
    }

    .welcome-card .action-item:nth-child(1) {
      background: rgba(255, 107, 107, 0.05);
    }

    .welcome-card .action-item:nth-child(2) {
      background: rgba(214, 144, 64, 0.05);
    }

    .welcome-card .action-item:nth-child(3) {
      background: rgba(109, 159, 113, 0.05);
    }

    .welcome-card .action-icon {
      font-size: 1.8rem;
      margin-bottom: 5px;
    }

    .welcome-card .action-text {
      color: #2d3748;
      font-weight: 700;
      font-size: 0.9rem;
    }

    .section-card {
      scroll-margin-top: 20px;
    }

    .animais-section {
      scroll-margin-top: 100px;
    }

    .section-title {
      color: var(--pet-dark);
      font-weight: 700;
      margin-bottom: 20px;
    }

    .animal-card {
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      transition: all 0.3s ease;
    }

    .animal-card img {
      height: 200px;
      object-fit: cover;
    }

    .animal-card .card-title {
      color: var(--pet-primary);
      font-weight: 800;
    }

    .animal-card .owner-info {
      background: linear-gradient(135deg, rgba(78, 205, 196, 0.1) 0%, rgba(68, 168, 160, 0.1) 100%);
      border-radius: 10px;
    }

    .alert-info-custom {
      background: linear-gradient(135deg, #a78bfa 0%, #9370db 100%);
      color: white;
      border: none;
      border-radius: 15px;
      padding: 30px;
    }

    .alert-info-custom h5 {
      color: white;
      font-weight: 700;
    }
  </style>
</head>

<body style="padding-left: 90px;">
  <!-- Sidebar fixa à esquerda -->
  <div class="sidebar-left">
    <div class="logo-container">
      <img src="img/logorealista2.png" alt="">
    </div>

    <a href="#usuarios" class="nav-btn gold" style="margin-top: 70px;">
      <span>👥</span>
      <span class="tooltip-text">Gerenciar Usuários</span>
    </a>
    
    <a href="#animais-adocao" class="nav-btn gold">
      <span>🐾</span>
      <span class="tooltip-text">Gerenciar Animais</span>
    </a>

    <div class="divider"></div>

    <a href="cadastroUsuarioADMIN.php" class="nav-btn gold">
      <span>➕</span>
      <span class="tooltip-text">Cadastrar Usuário</span>
    </a>

    <div class="divider"></div>

    <a href="logout.php" class="nav-btn red" onclick="return confirm('🚪 Tem certeza que deseja sair do painel administrativo?')">
      <span>🚪</span>
      <span class="tooltip-text">Sair</span>
    </a>
  </div>

  <div class="container admin-container">
    <!-- Card de Boas-vindas do Admin -->
    <div class="card p-5 mb-4 welcome-card">
      <!-- Decoração de fundo -->
      <div class="decoration-circle-1"></div>
      <div class="decoration-circle-2"></div>

      
      <!-- Conteúdo -->
      <div class="content">
        <div class="welcome-header">
          <!-- Ícone Admin -->
          <div class="icon-container">
            <img src="img/adm.png" alt="">
          </div>
          
          <!-- Texto de boas-vindas -->
          <div style="flex: 1;">
            <h2 class="welcome-title">
              Bem-vindo de volta, <span class="username"><?= $_SESSION['nome']; ?></span>!
            </h2>
            <div class="badges">
              <span class="badge-access">
                <span>⚙️</span> Administrador do Sistema
              </span>
            </div>
          </div>
        </div>
        
        <!-- Linha divisória decorativa -->
        <div class="divider-line"></div>
        
        <!-- Informações rápidas -->
        <div class="quick-actions">
          <div class="action-item">
            <div class="action-icon">👥</div>
            <div class="action-text">Gerenciar Usuários</div>
          </div>
          <div class="action-item">
            <div class="action-icon">🐾</div>
            <div class="action-text">Gerenciar Animais</div>
          </div>
          <div class="action-item">
            <div class="action-icon">📊</div>
            <div class="action-text">Painel Completo</div>
          </div>
        </div>
      </div>
    </div>

    <?php
    // Exibe mensagem de sucesso se houver
    if (isset($_SESSION['sucesso'])) {
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert' style='border-radius: 15px; border-left: 5px solid #4ecdc4;'>
              <strong>{$_SESSION['sucesso']}</strong>
              <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            </div>";
      unset($_SESSION['sucesso']);
    }

    // Exibe mensagem de erro se houver
    if (isset($_SESSION['erro'])) {
      echo "<div class='alert alert-danger alert-dismissible fade show' role='alert' style='border-radius: 15px; border-left: 5px solid #FF6B6B;'>
              <strong>{$_SESSION['erro']}</strong>
              <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            </div>";
      unset($_SESSION['erro']);
    }
    ?>

    <div id="usuarios" class="card p-4 section-card">
      <h4 class="mb-4 section-title">📋 Gerenciar Usuários</h4>
      <table class="table table-striped table-bordered align-middle mb-0">
        <thead>
          <tr>
            <th scope="col" style="color:#c47f35; background-color:#f9f6f1;">ID</th>
            <th scope="col"style="color:#c47f35; background-color:#f9f6f1;">Nome</th>
            <th scope="col"style="color:#c47f35; background-color:#f9f6f1;">Email</th>
            <th scope="col"style="color:#c47f35; background-color:#f9f6f1;">Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * FROM usuarios ORDER BY id_usuario ASC";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>{$row['id_usuario']}</td>
                      <td>{$row['nome_usuario']}</td>
                      <td>{$row['email_usuario']}</td>
                      <td>
                        <a href='editarUsuarioADMIN.php?id={$row['id_usuario']}' class='btn btn-sm btn-warning'>EDITAR</a>
                        <a href='excluirUsuarioADMIN.php?id={$row['id_usuario']}' class='btn btn-sm btn-danger'>EXCLUIR</a>
                      </td>
                    </tr>";
            }
          } else {
            echo "
        <div class='alert text-center alert-info-custom'>
          <h5>🔍 Nenhum usuário cadastrado no sistema</h5>
        </div>";
          }
          ?>
        </tbody>
      </table>
    </div>

    <div id="animais-adocao" class="card p-4 mt-4 animais-section">
      <h4 class="section-title">
        📋 Gerenciar Animais
      </h4>

      <hr class="my-4">


      <?php
      $sql_animais = "SELECT a.*, u.nome_usuario 
                    FROM animais a 
                    INNER JOIN usuarios u ON a.usuario_id = u.id_usuario 
                    ORDER BY a.id_animal DESC";
      $result_animais = $conn->query($sql_animais);

      if ($result_animais->num_rows > 0) {
        echo "<div class='row g-4'>";
        while ($animal = $result_animais->fetch_assoc()) {
          $foto = $animal['foto_animal'] ? 'uploads/' . $animal['foto_animal'] : 'https://via.placeholder.com/300x200?text=Sem+Foto';
          $status_class = $animal['status_adocao'] == 'Adotado' ? 'bg-secondary' : 'bg-success';

          echo "
            <div class='col-md-6 col-lg-4'>
              <div class='card h-100 animal-card'>
                <img src='{$foto}' class='card-img-top' alt='{$animal['nome_animal']}'>
                <span class='badge {$status_class} position-absolute top-0 end-0 m-2' style='font-size: 0.85rem;'>{$animal['status_adocao']}</span>
                <div class='card-body'>
                  <h5 class='card-title'>{$animal['nome_animal']} 🐾</h5>
                  <p class='card-text mb-2'>
                    <strong>{$animal['tipo_animal']}</strong> • {$animal['raca_animal']}<br>
                    <small class='text-muted'>
                      {$animal['sexo_animal']} • {$animal['idade_animal']}
                    </small>
                  </p>
                  <p class='card-text' style='font-size: 0.9rem;'>{$animal['descricao_animal']}</p>
                  <div class='mt-3 p-2 owner-info'>
                    <small><strong>📞 Cadastrado por:</strong> {$animal['nome_usuario']}</small>
                  </div>
                  <div class='d-flex gap-2 mt-3'>
                    <a href='editarAnimal.php?id={$animal['id_animal']}' class='btn btn-warning btn-sm flex-fill'>✏️ Editar</a>
                    <a href='excluirAnimal.php?id={$animal['id_animal']}' class='btn btn-danger btn-sm flex-fill' onclick='return confirm(\"Tem certeza que deseja excluir {$animal['nome_animal']}?\")'>🗑️ Excluir</a>
                  </div>
                </div>
              </div>
            </div>";
        }
        echo "</div>";
      } else {
        echo "
        <div class='alert text-center alert-info-custom'>
          <h5>🔍 Nenhum animal cadastrado no sistema</h5>
          <p class='mb-0'>Aguarde os usuários cadastrarem animais para adoção!</p>
        </div>";
      }
      ?>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>