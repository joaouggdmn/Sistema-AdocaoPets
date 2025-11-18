<?php
session_start();
require 'config.php';

if (!isset($_SESSION['logado']) || $_SESSION['nivel_usuario'] != 'usuario') {
    header("Location: login.php");
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
:root{
  --pet-primary: #ff6b9d;
  --pet-secondary: #4ecdc4;
  --pet-accent: #ffd93d;
  --pet-purple: #a78bfa;
  --pet-dark: #2d3748;
}

body { 
  font-family: 'Nunito', sans-serif;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #4facfe 75%, #00f2fe 100%);
  background-size: 400% 400%;
  animation: gradientShift 15s ease infinite;
  min-height: 100vh;
}

@keyframes gradientShift {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

.navbar { 
  background: linear-gradient(135deg, #4ecdc4 0%, #44a8a0 100%);
  box-shadow: 0 8px 32px rgba(78, 205, 196, 0.4);
  border-bottom: 3px solid rgba(255, 255, 255, 0.3);
}

.navbar a { 
  color: #fff !important;
  font-family: 'Fredoka', 'Nunito', sans-serif;
  text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
}

.card { 
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(20px);
  border: 2px solid rgba(255, 255, 255, 0.3);
  border-radius: 30px;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

@keyframes cardEntrance {
  from { opacity: 0; transform: translateY(30px); }
  to { opacity: 1; transform: translateY(0); }
}

.btn-warning { 
  background: linear-gradient(135deg, #ffd93d 0%, #ffed4e 100%);
  border: none;
  color: var(--pet-dark);
  font-weight: 700;
  border-radius: 12px;
  padding: 10px 24px;
  box-shadow: 0 6px 20px rgba(255, 217, 61, 0.4);
  transition: all 0.3s ease;
}

.btn-warning:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(255, 217, 61, 0.5);
  background: linear-gradient(135deg, #ffc400 0%, #ffd93d 100%);
  color: var(--pet-dark);
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
  color: transparent;
  background: linear-gradient(135deg, #4ecdc4 0%, #44a8a0 100%);
  background-clip: text;
  -webkit-background-clip: text;
  font-weight: 800;
  font-family: 'Fredoka', sans-serif;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 30px rgba(0,0,0,0.15) !important;
}

.alert {
  border-radius: 15px;
  border: none;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.alert-success {
  background: linear-gradient(135deg, #4ecdc4 0%, #44a8a0 100%);
  color: white;
  border-left: 5px solid #3ba89e;
}

.alert-danger {
  background: linear-gradient(135deg, #ff6b9d 0%, #ff558a 100%);
  color: white;
  border-left: 5px solid #ff4080;
}

.btn-sm {
  border-radius: 10px;
  font-weight: 700;
  padding: 8px 12px;
  font-size: 0.85rem;
  transition: all 0.3s ease;
}

.btn-danger {
  background: linear-gradient(135deg, #ff6b9d 0%, #ff558a 100%);
  border: none;
}

.btn-danger:hover {
  background: linear-gradient(135deg, #ff558a 0%, #ff4080 100%);
  transform: translateY(-2px);
}
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg mb-4">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="painelUsuario.php">🐾 Painel do Usuário</a>
    <div class="d-flex gap-2">
      <a href="cadastroAnimal.php" class="btn btn-light">
        <span style="font-size: 1.2rem;">🐕</span> Cadastrar Animal
      </a>
      <a href="logout.php" class="btn btn-warning">Sair</a>
    </div>
  </div>
</nav>
<div class="container">
  <div class="card p-4 mb-4">
    <h3>Olá, <?= $_SESSION['nome']; ?> 👋</h3>
    <p class="text-muted">Você está logado como <b>Usuário</b>.</p>
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
      echo "<div class='alert alert-danger alert-dismissible fade show' role='alert' style='border-radius: 15px; border-left: 5px solid #ff6b9d;'>
              <strong>{$_SESSION['erro']}</strong>
              <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            </div>";
      unset($_SESSION['erro']);
  }
  ?>

  <div class="card p-4">
    <h4 style="color: var(--pet-dark); font-weight: 700; margin-bottom: 20px;">
      🐾 Meus Animais Cadastrados
    </h4>
    
    <div class="text-center mb-4">
      <p class="text-muted">Cadastre animais disponíveis para adoção e ajude a encontrar um lar para eles!</p>
      <a href="cadastroAnimal.php" class="btn btn-warning btn-lg mt-2">
        <span style="font-size: 1.3rem;">🐕</span> Cadastrar Novo Animal
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
    
    if($result->num_rows > 0){
        echo "<div class='row g-4'>";
        while($animal = $result->fetch_assoc()){
            $foto = $animal['foto_animal'] ? 'uploads/' . $animal['foto_animal'] : 'https://via.placeholder.com/300x200?text=Sem+Foto';
            $status_class = $animal['status_adocao'] == 'Adotado' ? 'bg-secondary' : 'bg-success';
            
            echo "
            <div class='col-md-6 col-lg-4'>
              <div class='card h-100' style='border-radius: 20px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.1); transition: all 0.3s ease;'>
                <img src='{$foto}' class='card-img-top' alt='{$animal['nome_animal']}' style='height: 200px; object-fit: cover;'>
                <span class='badge {$status_class} position-absolute top-0 end-0 m-2' style='font-size: 0.85rem;'>{$animal['status_adocao']}</span>
                <div class='card-body'>
                  <h5 class='card-title' style='color: var(--pet-secondary); font-weight: 800;'>{$animal['nome_animal']} 🐾</h5>
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
          <h5 style='color: var(--pet-dark); font-weight: 700;'>😺 Nenhum animal cadastrado ainda!</h5>
          <p class='mb-0'>Comece agora a ajudar pets a encontrarem um novo lar!</p>
        </div>";
    }
    $stmt->close();
    ?>
  </div>

  <!-- Seção de Animais Disponíveis para Adoção (de outros usuários) -->
  <div class="card p-4 mt-4">
    <h4 style="color: var(--pet-dark); font-weight: 700; margin-bottom: 20px;">
      🏠 Animais Disponíveis para Adoção
    </h4>
    
    <p class="text-muted text-center mb-4">Veja todos os pets cadastrados por outros usuários que estão procurando um lar! ❤️</p>

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
    
    if($result_outros->num_rows > 0){
        echo "<div class='row g-4'>";
        while($animal = $result_outros->fetch_assoc()){
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
                  <div class='mt-3 p-2' style='background: linear-gradient(135deg, rgba(78, 205, 196, 0.1) 0%, rgba(68, 168, 160, 0.1) 100%); border-radius: 10px;'>
                    <small><strong>📞 Cadastrado por:</strong> {$animal['nome_usuario']}</small>
                  </div>
                  <div class='d-grid mt-3'>
                    <button class='btn btn-primary' style='background: linear-gradient(135deg, #ff6b9d 0%, #ff8fab 100%); border: none; font-weight: 700; border-radius: 12px; box-shadow: 0 4px 15px rgba(255, 107, 157, 0.3);'>
                      💕 Tenho Interesse!
                    </button>
                  </div>
                </div>
              </div>
            </div>";
        }
        echo "</div>";
    } else {
        echo "
        <div class='alert text-center' style='background: linear-gradient(135deg, #a78bfa 0%, #9370db 100%); color: white; border: none; border-radius: 15px; padding: 30px;'>
          <h5 style='color: white; font-weight: 700;'>🔍 Nenhum animal disponível no momento</h5>
          <p class='mb-0'>Seja o primeiro a cadastrar um pet para adoção!</p>
        </div>";
    }
    $stmt_outros->close();
    ?>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
