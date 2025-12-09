<?php
session_start();
require '../config.php';

if (!isset($_SESSION['logado']) || $_SESSION['nivel_usuario'] != 'admin') {
  header("Location: ../index.php#login-section");
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
  <link href="../css/admin.css" rel="stylesheet">
</head>

<body style="padding-left: 90px;">
  <!-- Sidebar fixa à esquerda -->
  <div class="sidebar-left">
    <div class="logo-container">
      <img src="../assets/img/logorealista2.png" alt="">
    </div>

    <a href="#usuarios" class="nav-btn gold" style="margin-top: 70px;">
      <span>👥</span>
      <span class="tooltip-text">Gerenciar Usuários</span>
    </a>

    <a href="#animais-adocao" class="nav-btn gold">
      <span>🐾</span>
      <span class="tooltip-text">Gerenciar Animais</span>
    </a>

    <a href="#adocoes" class="nav-btn gold">
      <span>💚</span>
      <span class="tooltip-text">Gerenciar Adoções</span>
    </a>

    <div class="divider"></div>

    <a href="cadastroUsuarioADMIN.php" class="nav-btn gold">
      <span>➕</span>
      <span class="tooltip-text">Cadastrar Usuário</span>
    </a>

    <div class="divider"></div>

    <a href="../auth/logout.php" class="nav-btn red" onclick="return confirm('🚪 Tem certeza que deseja sair do painel administrativo?')">
      <span>🚪</span>
      <span class="tooltip-text">Sair</span>
    </a>
  </div>

  <div class="container admin-container">
    <!-- Card de Boas-vindas do Admin -->
    <div class="card p-5 mb-4 welcome-card">
      <div class="decoration-circle-1"></div>
      <div class="decoration-circle-2"></div>
      <div class="content">
        <div class="welcome-header">
          <div class="icon-container">
            <img src="../assets/img/adm.png" alt="">
          </div>

          <!-- Texto de boas-vindas -->
          <div style="flex: 1;">
            <h2 class="welcome-title">
              Bem-vindo de volta, <span class="username"><?= $_SESSION['nome_usuario']; ?></span>!
            </h2>
            <div class="badges">
              <span class="badge-access">
                Administrador do Sistema
              </span>
            </div>
          </div>
        </div>

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
            <div class="action-text">Gerenciar Adoções</div>
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
      <h4 class="mb-4 section-title">👥 Gerenciar Usuários</h4>
      <table class="table table-striped table-bordered align-middle mb-0">
        <thead>
          <tr>
            <th scope="col" style="color:#c47f35; background-color:#f9f6f1;">ID</th>
            <th scope="col" style="color:#c47f35; background-color:#f9f6f1;">Nome</th>
            <th scope="col" style="color:#c47f35; background-color:#f9f6f1;">Email</th>
            <th scope="col" style="color:#c47f35; background-color:#f9f6f1;">Ações</th>
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

    <div id="animais-adocao" class="card p-4 mt-4 animais-section" style="margin-bottom: 40px;">
      <h4 class="section-title">
        🐾 Gerenciar Animais
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
          $foto = $animal['foto_animal'] ? '../assets/uploads/' . $animal['foto_animal'] : 'https://via.placeholder.com/300x200?text=Sem+Foto';
          $status_class = $animal['status_animal'] == 'Adotado' ? 'bg-secondary' : 'bg-success';

          echo "
            <div class='col-md-6 col-lg-4'>
              <div class='card h-100 animal-card'>
                <img src='{$foto}' class='card-img-top' alt='{$animal['nome_animal']}'>
                <span class='badge {$status_class} position-absolute top-0 end-0 m-2' style='font-size: 0.85rem;'>{$animal['status_animal']}</span>
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
                    <a href='../user/editarAnimal.php?id={$animal['id_animal']}' class='btn btn-warning btn-sm flex-fill'>✏️ Editar</a>
                    <a href='../actions/excluirAnimal.php?id={$animal['id_animal']}' class='btn btn-danger btn-sm flex-fill' onclick='return confirm('Tem certeza que deseja excluir {$animal['nome_animal']}?')'>🗑️ Excluir</a>
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

    <!-- Seção de Gerenciamento de Adoções -->
    <div id="adocoes" class="card p-4 mt-4 section-card">
      <h4 class="section-title">
        💚 Gerenciar Adoções
      </h4>
      <p class="text-muted text-center mb-4">Acompanhe e gerencie todas as solicitações de adoção do sistema</p>
      <hr class="my-4">

      <?php
      // Busca todas as adoções do sistema com informações completas
      $sql_adocoes = "SELECT 
                        a.id_adocao,
                        a.status_solicitacao,
                        a.data_solicitacao,
                        a.data_resposta,
                        a.data_adocao,
                        an.nome_animal,
                        an.tipo_animal,
                        an.foto_animal,
                        doador.nome_usuario as nome_doador,
                        adotante.nome_usuario as nome_adotante
                      FROM adocao a
                      INNER JOIN animais an ON a.animal_id = an.id_animal
                      INNER JOIN usuarios doador ON a.doador_id = doador.id_usuario
                      INNER JOIN usuarios adotante ON a.adotante_id = adotante.id_usuario
                      ORDER BY 
                        CASE 
                          WHEN a.status_solicitacao = 'pendente' THEN 1
                          WHEN a.status_solicitacao = 'aprovada' THEN 2
                          ELSE 3
                        END,
                        a.data_solicitacao DESC";
      $result_adocoes = $conn->query($sql_adocoes);

      if ($result_adocoes->num_rows > 0) {
        echo "<div class='row g-4'>";
        while ($adocao = $result_adocoes->fetch_assoc()) {
          $foto = $adocao['foto_animal'] ? '../assets/uploads/' . $adocao['foto_animal'] : 'https://via.placeholder.com/300x200?text=Sem+Foto';

          // Define badge e estilo baseado no status
          if ($adocao['status_solicitacao'] == 'pendente') {
            $badge_class = 'bg-warning text-dark';
            $badge_text = '⏳ Pendente';
            $card_border = 'border-warning';
          } elseif ($adocao['status_solicitacao'] == 'aprovada') {
            $badge_class = 'bg-success';
            $badge_text = '✅ Aprovada';
            $card_border = 'border-success';
          } else {
            $badge_class = 'bg-danger';
            $badge_text = '❌ Recusada';
            $card_border = 'border-danger';
          }

          $data_solicitacao = date('d/m/Y H:i', strtotime($adocao['data_solicitacao']));

          echo "<div class='col-md-6 col-lg-4'>";
          echo "  <div class='card h-100 {$card_border}' style='border-radius: 15px; overflow: hidden; border-width: 3px;'>";
          echo "    <img src='{$foto}' class='card-img-top' alt='{$adocao['nome_animal']}' style='height: 180px; object-fit: cover;'>";
          echo "    <div class='card-body'>";
          echo "      <div class='d-flex justify-content-between align-items-center mb-3'>";
          echo "        <h5 class='card-title mb-0' style='color: #d69040ff; font-weight: 800;'>{$adocao['nome_animal']}</h5>";
          echo "        <span class='badge {$badge_class}'>{$badge_text}</span>";
          echo "      </div>";
          echo "      <p class='card-text mb-2'>";
          echo "        <strong>{$adocao['tipo_animal']}</strong><br>";
          echo "        <small class='text-muted' style='line-height: 1.8;'>";
          echo "          <strong>🏠 Doador:</strong> {$adocao['nome_doador']}<br>";
          echo "          <strong>💕 Adotante:</strong> {$adocao['nome_adotante']}<br>";
          echo "          <strong>📅 Solicitado:</strong> {$data_solicitacao}<br>";

          if ($adocao['status_solicitacao'] == 'aprovada' && $adocao['data_adocao']) {
            $data_aprovacao = date('d/m/Y', strtotime($adocao['data_adocao']));
            echo "          <strong>✅ Aprovado:</strong> {$data_aprovacao}<br>";
          } elseif ($adocao['status_solicitacao'] == 'recusada' && $adocao['data_resposta']) {
            $data_recusa = date('d/m/Y', strtotime($adocao['data_resposta']));
            echo "          <strong>❌ Recusado:</strong> {$data_recusa}<br>";
          }

          echo "        </small>";
          echo "      </p>";

          // Badge de ID da adoção
          echo "      <div class='mt-2 mb-3'>";
          echo "        <span class='badge bg-secondary' style='font-size: 0.75rem;'>ID: {$adocao['id_adocao']}</span>";
          echo "      </div>";

          echo "      <div class='d-flex gap-2 mt-3'>";
          echo "        <a href='editarAdocao.php?id={$adocao['id_adocao']}' class='btn btn-warning btn-sm flex-fill'>✏️ Editar</a>";
          echo "        <a href='excluirAdocao.php?id={$adocao['id_adocao']}' class='btn btn-danger btn-sm flex-fill' onclick='return confirm(\"Tem certeza que deseja excluir esta adoção?\")'>🗑️ Excluir</a>";
          echo "      </div>";
          echo "    </div>";
          echo "  </div>";
          echo "</div>";
        }
        echo "</div>";
      } else {
        echo "<div class='alert text-center alert-info-custom'>";
        echo "  <h5>🔍 Nenhuma adoção registrada no sistema</h5>";
        echo "  <p class='mb-0'>As adoções aparecerão aqui quando os usuários solicitarem!</p>";
        echo "</div>";
      }
      ?>
    </div>
  </div>

  <footer style="background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%); padding: 50px 0 30px 0; margin-top: 60px; color: #e2e8f0; box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.15); border-top: 3px solid #FF6B6B;">
    <div class="container">
      <div class="row">
        <!-- Coluna 1: Painel Admin -->
        <div class="col-md-4 mb-4">
          <h5 style="font-family: 'Fredoka', sans-serif; font-weight: 700; color: #FF6B6B; margin-bottom: 20px; font-size: 1.3rem;">
            <img src="../assets/img/adm.png" alt=""> Painel Administrativo
          </h5>
          <p style="color: #cbd5e0; line-height: 1.8; font-size: 0.95rem;">
            Gerenciamento completo do sistema AUcolher. Monitore usuários, animais e adoções de forma centralizada.
          </p>
        </div>

        <!-- Coluna 2: Acesso Rápido -->
        <div class="col-md-4 mb-4">
          <h5 style="font-family: 'Fredoka', sans-serif; font-weight: 700; color: #FF6B6B; margin-bottom: 20px; font-size: 1.3rem;">
            Acesso Rápido
          </h5>
          <ul style="list-style: none; padding: 0; line-height: 2.2;">
            <li><a href="#usuarios" style="color: #cbd5e0; text-decoration: none; transition: all 0.3s; display: inline-block;">→ Gerenciar Usuários</a></li>
            <li><a href="#animais-adocao" style="color: #cbd5e0; text-decoration: none; transition: all 0.3s; display: inline-block;">→ Gerenciar Animais</a></li>
            <li><a href="cadastroUsuarioADMIN.php" style="color: #cbd5e0; text-decoration: none; transition: all 0.3s; display: inline-block;">→ Cadastrar Usuário</a></li>
          </ul>
        </div>

        <!-- Coluna 3: Informações do Sistema -->
        <div class="col-md-4 mb-4">
          <h5 style="font-family: 'Fredoka', sans-serif; font-weight: 700; color: #FF6B6B; margin-bottom: 20px; font-size: 1.3rem;">
            Sistema
          </h5>
          <p style="color: #cbd5e0; line-height: 2; font-size: 0.95rem;">
            🔐 <strong>Nível de acesso:</strong> Administrador<br>
            👤 <strong>Logado como:</strong> <?= $_SESSION['nome_usuario']; ?><br>
            📅 <strong>Versão:</strong> 1.0.0 (2025)
          </p>
        </div>
      </div>

      <hr style="border-color: rgba(255, 107, 107, 0.3); margin: 30px 0 20px 0;">

      <div class="text-center">
        <p style="color: #a0aec0; font-size: 0.9rem; margin: 0; font-family: 'Nunito', sans-serif;">
          © 2025 <strong style="color: #FF6B6B;">Projeto AUcolher</strong> • Painel Administrativo
        </p>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>