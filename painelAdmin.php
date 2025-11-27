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
:root{
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

.table tbody tr:hover{ 
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
  background: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2rem;
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
</style>
</head>
<body style="padding-left: 90px;">
  <!-- Sidebar fixa à esquerda -->
  <div class="sidebar-left">
    <div class="logo-container">
      👑
    </div>

    <div class="divider"></div>

    <a href="#usuarios" class="nav-btn gold">
      <span>👥</span>
      <span class="tooltip-text">Gerenciar Usuários</span>
    </a>
    <a href="cadastroUsuarioADMIN.php" class="nav-btn gold">
      <span>➕</span>
      <span class="tooltip-text">Cadastrar Usuário</span>
    </a>
    <a href="#animais-adocao" class="nav-btn gold">
      <span>🐾</span>
      <span class="tooltip-text">Gerenciar Animais</span>
    </a>

    <div class="divider"></div>

    <a href="logout.php" class="nav-btn red">
      <span>🚪</span>
      <span class="tooltip-text">Sair</span>
    </a>
  </div>

  <!-- Offcanvas para mobile -->
  <div class="d-md-none">
    <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" style="position: fixed; top: 20px; right: 20px; z-index: 1100; background: linear-gradient(135deg, #d69040ff 0%, #c47f35 100%); color: white; border: none; border-radius: 50%; width: 50px; height: 50px; box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
      <span style="font-size: 1.5rem;">☰</span>
    </button>
  </div>

  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
    <div class="offcanvas-header" style="background: linear-gradient(135deg, #d69040ff 0%, #c47f35 100%); color: white;">
      <h5 class="offcanvas-title fw-bold" id="offcanvasNavbarLabel" style="font-family: 'Fredoka', sans-serif;">👑 Menu Admin</h5>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <div class="mb-4 p-3" style="background: linear-gradient(135deg, #FFF3E2 0%, #f7e5c8 100%); border-radius: 12px;">
        <h6 class="fw-bold" style="color: #d69040ff;">👑 <?= $_SESSION['nome']; ?></h6>
        <p class="mb-0 small text-muted">Administrador</p>
      </div>
      
      <ul class="navbar-nav flex-grow-1">
        <li class="nav-item">
          <a class="nav-link fw-bold" href="#usuarios" style="color: #d69040ff; font-size: 1.05rem;">
            👥 Gerenciar Usuários
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cadastroUsuarioADMIN.php" style="color: var(--pet-dark);">
            ➕ Cadastrar Usuário
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#animais-adocao" style="color: var(--pet-dark);">
            🐾 Gerenciar Animais
          </a>
        </li>
        <li><hr class="dropdown-divider"></li>
        <li class="nav-item">
          <a class="nav-link fw-bold" href="logout.php" style="color: #2d3748;">
            🚪 Sair
          </a>
        </li>
      </ul>
    </div>
  </div>

<div class="container" style="margin-top: 40px;">
  <div class="card p-4 mb-4">
    <h3>Bem-vindo, <?= $_SESSION['nome']; ?> 👑</h3>
    <p class="text-muted">Você está logado como <b>Administrador</b>.</p>
  </div>

  <?php
  // Exibe mensagem de sucesso se houver
  if(isset($_SESSION['sucesso'])){
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert' style='border-radius: 15px; border-left: 5px solid #4ecdc4;'>
              <strong>{$_SESSION['sucesso']}</strong>
              <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            </div>";
      unset($_SESSION['sucesso']);
  }
  
  // Exibe mensagem de erro se houver
  if(isset($_SESSION['erro'])){
      echo "<div class='alert alert-danger alert-dismissible fade show' role='alert' style='border-radius: 15px; border-left: 5px solid #FF6B6B;'>
              <strong>{$_SESSION['erro']}</strong>
              <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            </div>";
      unset($_SESSION['erro']);
  }
  ?>

  <div id="usuarios" class="card p-4" style="scroll-margin-top: 20px;">
    <h4 class="mb-4" style="color: var(--pet-dark); font-weight: 700;">📋 Gerenciar Usuários</h4>
    <table class="table table-striped table-bordered align-middle mb-0">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Nome</th>
          <th scope="col">Email</th>
          <th scope="col">Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $sql = "SELECT * FROM usuarios ORDER BY id_usuario ASC";
          $result = $conn->query($sql);
          if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
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
        <div class='alert text-center' style='background: linear-gradient(135deg, #a78bfa 0%, #9370db 100%); color: white; border: none; border-radius: 15px; padding: 30px;'>
          <h5 style='color: white; font-weight: 700;'>🔍 Nenhum usuário cadastrado no sistema</h5>
        </div>";
          }
        ?>
      </tbody>
    </table>
  </div>

  <div id="animais-adocao" class="card p-4 mt-4" style="scroll-margin-top: 100px;">
    <h4 style="color: var(--pet-dark); font-weight: 700; margin-bottom: 20px;">
      📋 Gerenciar Animais
    </h4>
    
    <hr class="my-4">
    
   
    <?php
    $sql_animais = "SELECT a.*, u.nome_usuario 
                    FROM animais a 
                    INNER JOIN usuarios u ON a.usuario_id = u.id_usuario 
                    ORDER BY a.id_animal DESC";
    $result_animais = $conn->query($sql_animais);
    
    if($result_animais->num_rows > 0){
        echo "<div class='row g-4'>";
        while($animal = $result_animais->fetch_assoc()){
            $foto = $animal['foto_animal'] ? 'uploads/' . $animal['foto_animal'] : 'https://via.placeholder.com/300x200?text=Sem+Foto';
            $status_class = $animal['status_adocao'] == 'Adotado' ? 'bg-secondary' : 'bg-success';
            
            echo "
            <div class='col-md-6 col-lg-4'>
              <div class='card h-100' style='border-radius: 20px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.1); transition: all 0.3s ease;'>
                <img src='{$foto}' class='card-img-top' alt='{$animal['nome_animal']}' style='height: 200px; object-fit: cover;'>
                <span class='badge {$status_class} position-absolute top-0 end-0 m-2' style='font-size: 0.85rem;'>{$animal['status_adocao']}</span>
                <div class='card-body'>
                  <h5 class='card-title' style='color: var(--pet-primary); font-weight: 800;'>{$animal['nome_animal']} 🐾</h5>
                  <p class='card-text mb-2'>
                    <strong>{$animal['tipo_animal']}</strong> • {$animal['raca_animal']}<br>
                    <small class='text-muted'>
                      {$animal['sexo_animal']} • {$animal['idade_animal']}
                    </small>
                  </p>
                  <p class='card-text' style='font-size: 0.9rem;'>{$animal['descricao_animal']}</p>
                  <div class='mt-3 p-2' style='background: linear-gradient(135deg, rgba(78, 205, 196, 0.1) 0%, rgba(68, 168, 160, 0.1) 100%); border-radius: 10px;'>
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
        <div class='alert text-center' style='background: linear-gradient(135deg, #a78bfa 0%, #9370db 100%); color: white; border: none; border-radius: 15px; padding: 30px;'>
          <h5 style='color: white; font-weight: 700;'>🔍 Nenhum animal cadastrado no sistema</h5>
          <p class='mb-0'>Aguarde os usuários cadastrarem animais para adoção!</p>
        </div>";
    }
    ?>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
