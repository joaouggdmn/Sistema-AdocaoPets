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
  background: linear-gradient(135deg, #ffeaea 0%, #ffd6d6 100%);
  min-height: 100vh;
}

.navbar { 
  background: linear-gradient(135deg, #FF6B6B 0%, #ff5252 100%);
  box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
  border-bottom: 2px solid rgba(255, 255, 255, 0.2);
}

.navbar a { 
  color: #fff !important;
  font-family: 'Fredoka', 'Nunito', sans-serif;
  text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
}

.card { 
  background: white;
  border: none;
  border-radius: 20px;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.btn-light { 
  background: rgba(255, 255, 255, 0.9);
  border: 2px solid rgba(255, 255, 255, 0.5);
  color: var(--pet-dark);
  font-weight: 700;
  border-radius: 12px;
  padding: 10px 24px;
  transition: all 0.3s ease;
}

.btn-light:hover {
  background: white;
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(255, 255, 255, 0.3);
}

.btn-dark { 
  background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
  border: none;
  font-weight: 700;
  border-radius: 12px;
  padding: 10px 24px;
  box-shadow: 0 6px 20px rgba(45, 55, 72, 0.4);
  transition: all 0.3s ease;
}

.btn-dark:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(45, 55, 72, 0.5);
}

h3 {
  color: var(--pet-primary);
  font-weight: 800;
  font-family: 'Fredoka', sans-serif;
}

.table {
  background: white;
  border-radius: 20px;
  overflow: hidden;
}

.table thead {
  background: linear-gradient(135deg, #ffd93d 0%, #ffed4e 100%);
}

.table thead th {
  font-weight: 800;
  color: var(--pet-dark);
  padding: 18px 15px;
  border: none;
}

.table tbody tr {
  transition: all 0.3s ease;
}

.table tbody tr:hover{ 
  background: rgba(78, 205, 196, 0.08);
  transform: translateX(2px);
}
</style>
</head>
<body style="padding-top: 70px;">
<nav class="navbar fixed-top mb-4">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="painelAdmin.php">👑 Painel Admin</a>
    <div class="d-flex gap-2">
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" style="border: 2px solid white; color: white;">
        <span class="navbar-toggler-icon" style="filter: brightness(0) invert(1);"></span>
      </button>
    </div>
  </div>
  
  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
    <div class="offcanvas-header" style="background: linear-gradient(135deg, #FF6B6B 0%, #ff5252 100%); color: white;">
      <h5 class="offcanvas-title fw-bold" id="offcanvasNavbarLabel" style="font-family: 'Fredoka', sans-serif;">👑 Menu Admin</h5>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <div class="mb-4 p-3" style="background: linear-gradient(135deg, #ffeaea 0%, #ffd6d6 100%); border-radius: 12px;">
        <h6 class="fw-bold" style="color: var(--pet-primary);">👑 <?= $_SESSION['nome']; ?></h6>
        <p class="mb-0 small text-muted">Administrador</p>
      </div>
      
      <ul class="navbar-nav flex-grow-1">
        <li class="nav-item">
          <a class="nav-link fw-bold" href="painelAdmin.php" style="color: var(--pet-primary); font-size: 1.05rem;">
            🏠 Início
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cadastroUsuarioADMIN.php" style="color: var(--pet-dark);">
            ➕ Cadastrar Usuário
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="painelAdmin.php" style="color: var(--pet-dark);">
            📋 Gerenciar Usuários
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
</nav>
<div class="container">
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

  <div class="card p-4">
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
