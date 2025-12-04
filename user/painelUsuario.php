<?php
session_start();
require '../config.php';

if (!isset($_SESSION['logado']) || $_SESSION['nivel_usuario'] != 'usuario') {
  header("Location: ../index.php#login-section");
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
  <link href="../css/usuario.css" rel="stylesheet">
</head>

<body style="padding-left: 90px;">
  <!-- Sidebar fixa à esquerda -->
  <div class="sidebar-left">
    <div class="logo-container">
      <img src="../assets/img/logorealista2.png" alt="logo">
    </div>


   
    <a href="#animais_cadastrados" class="nav-btn gold" style="margin-top: auto; ">
      <img src="../assets/img/gato.png" alt="gato">
      <span class="tooltip-text">Cadastrar Animal</span>
    </a>
     <a href="#animais-adocao" class="nav-btn green">
      <img src="../assets/img/casa.png" alt="casa">
      <span class="tooltip-text">Animais para Adoção</span>
    </a>
    <a href="#minhas-solicitacoes" class="nav-btn green">
      <img src="../assets/img/coracaoverde.png" alt="coração verde">
      <span class="tooltip-text">Minhas Solicitações</span>
    </a>
    
    <a href="#solicitacoes-recebidas" class="nav-btn gold">
      <span>📬</span>
      <span class="tooltip-text">Solicitações Recebidas</span>
    </a>

    <div class="divider"></div>

    <a href="editarUsuarioUSER.php" class="nav-btn gold">
      <span>✏️</span>
      <span class="tooltip-text">Editar Perfil</span>
    </a>

    <a href="../auth/logout.php" class="nav-btn gold" style="margin-bottom: auto;" onclick="return confirm('🚪 Você realmente deseja sair do sistema?')">
      <span>🚪</span>
      <span class="tooltip-text">Sair</span>
    </a>
  </div>

  <div class="container">
    <!-- Título-->
    <div class="text-center" style="margin-top: 30px; margin-bottom: 30px; padding: 15px;">
      <h1 class="titulo-animado" style="font-family: 'Fredoka', sans-serif; font-weight: 800; color: #d48224ff; font-size: 2.2rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.1);">
        Bem-vindo (a), <span style="color: #496b4cff;"><?= $_SESSION['nome_usuario']; ?></span>! <br> Seu novo melhor amigo tem quatro patas
        e está te esperando.
      </h1>
      <p class="subtitulo-animado" style="font-size: 1.2rem; color: #2d3748; font-weight: 600; margin-top: 15px; line-height: 1.6;">
        Adote. Ame. Acolha.<br>
      </p>
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

    <div id="animais_cadastrados" class="card p-4" style="margin-top: 40px;">
      <h4 style="color: var(--pet-dark); font-weight: 700; margin-bottom: 20px;">
        <img src="../assets/img/gato.png" alt="gato"> Meus Animais
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
          $foto = $animal['foto_animal'] ? '../assets/uploads/' . $animal['foto_animal'] : 'https://via.placeholder.com/300x200?text=Sem+Foto';
          $status_class = $animal['status_animal'] == 'Adotado' ? 'bg-secondary' : 'bg-success';

          echo "
            <div class='col-md-6 col-lg-4'>
              <div class='card h-100' style='border-radius: 20px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.1); transition: all 0.3s ease;'>
                <img src='{$foto}' class='card-img-top' alt='{$animal['nome_animal']}' style='height: 200px; object-fit: cover;'>
                <span class='badge {$status_class} position-absolute top-0 end-0 m-2' style='font-size: 0.85rem;'>{$animal['status_animal']}</span>
                <div class='card-body'>
                  <h5 class='card-title' style='color: #d69040ff; font-weight: 800;'>{$animal['nome_animal']} 🐾</h5>
                  <p class='card-text mb-2'>
                    <strong>{$animal['tipo_animal']}</strong> • {$animal['raca_animal']}<br>
                    <small class='text-muted'>
                      {$animal['sexo_animal']} • {$animal['idade_animal']}
                    </small>
                  </p>
                  <p class='card-text' style='font-size: 0.9rem;'>{$animal['descricao_animal']}</p>";
          
          // Só mostra botões de editar/excluir se o animal NÃO estiver adotado
          if($animal['status_animal'] != 'Adotado'){
            echo "
                  <div class='d-flex gap-2 mt-3'>
                    <a href='editarAnimal.php?id={$animal['id_animal']}' class='btn btn-warning btn-sm flex-fill'>✏️ Editar</a>
                    <a href='../actions/excluirAnimal.php?id={$animal['id_animal']}' class='btn btn-danger btn-sm flex-fill' onclick='return confirm(\"Tem certeza que deseja excluir este animal?\")'>🗑️ Excluir</a>
                  </div>";
          } else {
            echo "
                  <div class='alert alert-info mb-0 mt-3' style='padding: 10px; font-size: 0.85rem; text-align: center;'>
                    <strong>🎉 Seu pet foi adotado!</strong>
                  </div>";
          }
          
          echo "
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

    <!-- Seção de Solicitações Recebidas (para quem cadastrou o pet) -->
    <div id="solicitacoes-recebidas" class="card p-4 mt-4" style="scroll-margin-top: 20px;">
      <h4 style="color: var(--pet-dark); font-weight: 700; margin-bottom: 20px;">
        📬 Solicitações Recebidas
      </h4>

      <p class="text-muted text-center mb-4">Solicitações de adoção dos seus pets!</p>
      <hr class="my-4">

      <?php
      // Busca solicitações recebidas dos pets do usuário
      $sql_recebidas = "SELECT a.*, an.nome_animal, an.tipo_animal, an.foto_animal, u.nome_usuario as nome_interessado 
                        FROM adocao a 
                        INNER JOIN animais an ON a.animal_id = an.id_animal 
                        INNER JOIN usuarios u ON a.adotante_id = u.id_usuario 
                        WHERE a.doador_id = ? 
                        ORDER BY 
                          CASE 
                            WHEN a.status_solicitacao = 'pendente' THEN 1 
                            WHEN a.status_solicitacao = 'aprovada' THEN 2 
                            ELSE 3 
                          END,
                          a.data_solicitacao DESC";
      $stmt_recebidas = $conn->prepare($sql_recebidas);
      $stmt_recebidas->bind_param("i", $id_usuario_sessao);
      $stmt_recebidas->execute();
      $result_recebidas = $stmt_recebidas->get_result();

      if ($result_recebidas->num_rows > 0) {
        echo "<div class='row g-4'>";
        while ($solicitacao = $result_recebidas->fetch_assoc()) {
          $foto = $solicitacao['foto_animal'] ? '../assets/uploads/' . $solicitacao['foto_animal'] : 'https://via.placeholder.com/300x200?text=Sem+Foto';
          
          // Define badge e cor baseado no status
          if($solicitacao['status_solicitacao'] == 'pendente'){
            $badge_class = 'bg-warning';
            $badge_text = '⏳ Pendente';
            $card_border = 'border-warning';
            $mostrar_botoes = true;
          } elseif($solicitacao['status_solicitacao'] == 'aprovada'){
            $badge_class = 'bg-success';
            $badge_text = '✅ Aprovada';
            $card_border = 'border-success';
            $mostrar_botoes = false;
          } else {
            $badge_class = 'bg-danger';
            $badge_text = '❌ Recusada';
            $card_border = 'border-danger';
            $mostrar_botoes = false;
          }
          
          $data_formatada = date('d/m/Y H:i', strtotime($solicitacao['data_solicitacao']));

          echo "
            <div class='col-md-6 col-lg-4'>
              <div class='card h-100 {$card_border}' style='border-radius: 15px; overflow: hidden; border-width: 3px;'>
                <img src='{$foto}' class='card-img-top' alt='{$solicitacao['nome_animal']}' style='height: 180px; object-fit: cover;'>
                <div class='card-body'>
                  <div class='d-flex justify-content-between align-items-center mb-2'>
                    <h5 class='card-title mb-0' style='color: #d69040ff; font-weight: 800;'>{$solicitacao['nome_animal']}</h5>
                    <span class='badge {$badge_class}'>{$badge_text}</span>
                  </div>
                  <p class='card-text mb-2'>
                    <strong>{$solicitacao['tipo_animal']}</strong><br>
                    <small class='text-muted'>
                      <strong>👤 Interessado:</strong> {$solicitacao['nome_interessado']}<br>
                      <strong>📅 Solicitado em:</strong> {$data_formatada}
                    </small>
                  </p>";
          
          if($mostrar_botoes){
            echo "
                  <div class='d-flex gap-2 mt-3'>
                    <a href='../admin/aprovarAdocao.php?id={$solicitacao['id_adocao']}&acao=aprovar' 
                       class='btn btn-success btn-sm flex-fill' 
                       onclick='return confirm(\"✅ Aprovar adoção de {$solicitacao['nome_animal']} para {$solicitacao['nome_interessado']}?\")'>
                      ✅ Aprovar
                    </a>
                    <a href='../admin/aprovarAdocao.php?id={$solicitacao['id_adocao']}&acao=recusar' 
                       class='btn btn-danger btn-sm flex-fill' 
                       onclick='return confirm(\"❌ Recusar esta solicitação?\")'>
                      ❌ Recusar
                    </a>
                  </div>";
          } elseif($solicitacao['status_solicitacao'] == 'aprovada'){
            $data_aprovacao = date('d/m/Y', strtotime($solicitacao['data_adocao']));
            echo "<div class='alert alert-success mb-0 mt-2' style='padding: 10px; font-size: 0.85rem;'>
                    <strong>🎉 Adoção aprovada!</strong><br>Em {$data_aprovacao}
                  </div>";
          } elseif($solicitacao['status_solicitacao'] == 'recusada'){
            $data_recusa = date('d/m/Y', strtotime($solicitacao['data_resposta']));
            echo "<div class='alert alert-secondary mb-0 mt-2' style='padding: 10px; font-size: 0.85rem;'>
                    <strong>Recusada em {$data_recusa}</strong>
                  </div>";
          }
          
          echo "
                </div>
              </div>
            </div>";
        }
        echo "</div>";
      } else {
        echo "
        <div class='alert text-center' style='background: linear-gradient(135deg, #6D9F71 0%, #5a8a5e 100%); color: white; border: none; border-radius: 15px; padding: 30px;'>
          <h5 style='color: white; font-weight: 700;'>📬 Você ainda não recebeu nenhuma solicitação!</h5>
          <p class='mb-0'>Quando alguém se interessar pelos seus pets, as solicitações aparecerão aqui!</p>
        </div>";
      }
      $stmt_recebidas->close();
      ?>
    </div>
  
    <!-- Seção de Animais Disponíveis para Adoção (de outros usuários) -->
    <div id="animais-adocao" class="card p-4 mt-4" style="scroll-margin-top: 100px;">
      <h4 style="color: var(--pet-dark); font-weight: 700; margin-bottom: 20px;">
        <img src="../assets/img/casa.png" alt="casa"> Animais Disponíveis para Adoção
      </h4>

      <p class="text-muted text-center mb-4">Veja todos os pets cadastrados por outros usuários que estão procurando um lar!</p>
      <hr class="my-4">

      <!-- Lista de animais cadastrados por OUTROS usuários -->
      <?php
      // Busca animais de outros usuários que estão disponíveis para adoção
      $sql_outros = "SELECT a.*, u.nome_usuario 
                   FROM animais a 
                   INNER JOIN usuarios u ON a.usuario_id = u.id_usuario 
                   WHERE a.usuario_id != ? AND a.status_animal = 'Disponível'
                   ORDER BY a.id_animal DESC";
      $stmt_outros = $conn->prepare($sql_outros);
      $stmt_outros->bind_param("i", $id_usuario_sessao);
      $stmt_outros->execute();
      $result_outros = $stmt_outros->get_result();

      if ($result_outros->num_rows > 0) {
        echo "<div class='row g-4'>";
        while ($animal = $result_outros->fetch_assoc()) {
          $foto = $animal['foto_animal'] ? '../assets/uploads/' . $animal['foto_animal'] : 'https://via.placeholder.com/300x200?text=Sem+Foto';

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

    <!-- Seção de Minhas Solicitações -->
    <div id="minhas-solicitacoes" class="card p-4 mt-4" style="scroll-margin-top: 20px;">
      <h4 style="color: var(--pet-dark); font-weight: 700; margin-bottom: 20px;">
        <img src="../assets/img/coracaoverde.png" alt="coração verde"> Minhas Solicitações de Adoção
      </h4>

      <p class="text-muted text-center mb-4">Acompanhe o status das suas solicitações de adoção!</p>
      <hr class="my-4">

      <?php
      // Busca solicitações do usuário
      $sql_solicitacoes = "SELECT a.*, an.nome_animal, an.tipo_animal, an.foto_animal, u.nome_usuario as nome_doador 
                           FROM adocao a 
                           INNER JOIN animais an ON a.animal_id = an.id_animal 
                           INNER JOIN usuarios u ON a.doador_id = u.id_usuario 
                           WHERE a.adotante_id = ? 
                           ORDER BY a.data_solicitacao DESC";
      $stmt_solicitacoes = $conn->prepare($sql_solicitacoes);
      $stmt_solicitacoes->bind_param("i", $id_usuario_sessao);
      $stmt_solicitacoes->execute();
      $result_solicitacoes = $stmt_solicitacoes->get_result();

      if ($result_solicitacoes->num_rows > 0) {
        echo "<div class='row g-4'>";
        while ($solicitacao = $result_solicitacoes->fetch_assoc()) {
          $foto = $solicitacao['foto_animal'] ? '../assets/uploads/' . $solicitacao['foto_animal'] : 'https://via.placeholder.com/300x200?text=Sem+Foto';
          
          // Define badge e cor baseado no status
          if($solicitacao['status_solicitacao'] == 'pendente'){
            $badge_class = 'bg-warning';
            $badge_text = '⏳ Aguardando Resposta';
            $card_border = 'border-warning';
          } elseif($solicitacao['status_solicitacao'] == 'aprovada'){
            $badge_class = 'bg-success';
            $badge_text = '✅ Aprovada';
            $card_border = 'border-success';
          } else {
            $badge_class = 'bg-danger';
            $badge_text = '❌ Recusada';
            $card_border = 'border-danger';
          }
          
          $data_formatada = date('d/m/Y H:i', strtotime($solicitacao['data_solicitacao']));

          echo "
            <div class='col-md-6 col-lg-4'>
              <div class='card h-100 {$card_border}' style='border-radius: 15px; overflow: hidden; border-width: 3px;'>
                <img src='{$foto}' class='card-img-top' alt='{$solicitacao['nome_animal']}' style='height: 180px; object-fit: cover;'>
                <div class='card-body'>
                  <div class='d-flex justify-content-between align-items-center mb-2'>
                    <h5 class='card-title mb-0' style='color: #d69040ff; font-weight: 800;'>{$solicitacao['nome_animal']}</h5>
                    <span class='badge {$badge_class}'>{$badge_text}</span>
                  </div>
                  <p class='card-text mb-2'>
                    <strong>{$solicitacao['tipo_animal']}</strong><br>
                    <small class='text-muted'>
                      <strong>Doador:</strong> {$solicitacao['nome_doador']}<br>
                      <strong>Solicitado em:</strong> {$data_formatada}
                    </small>
                  </p>";
          
          if($solicitacao['status_solicitacao'] == 'aprovada'){
            $data_aprovacao = date('d/m/Y', strtotime($solicitacao['data_adocao']));
            echo "<div class='alert alert-success mb-0 mt-2' style='padding: 10px; font-size: 0.85rem;'>
                    <strong>🎉 Parabéns!</strong><br>Aprovado em {$data_aprovacao}
                  </div>";
          } elseif($solicitacao['status_solicitacao'] == 'recusada'){
            echo "<div class='alert alert-danger mb-0 mt-2' style='padding: 10px; font-size: 0.85rem;'>
                    <strong>Não foi desta vez.</strong><br>Tente outros pets!
                  </div>";
          }
          
          echo "
                </div>
              </div>
            </div>";
        }
        echo "</div>";
      } else {
        echo "
        <div class='alert text-center' style='background: linear-gradient(135deg, #d69040ff 0%, #c47f35 100%); color: white; border: none; border-radius: 15px; padding: 30px;'>
          <h5 style='color: white; font-weight: 700;'>📋 Você ainda não fez nenhuma solicitação de adoção!</h5>
          <p class='mb-0'>Navegue pelos pets disponíveis e solicite a adoção do seu favorito!</p>
        </div>";
      }
      $stmt_solicitacoes->close();
      ?>
    </div>
  </div>

  <!-- Footer Profissional -->
  <footer style="background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%); color: white; margin-top: 60px; padding: 50px 0 20px 0; border-top: 4px solid #d69040ff;">
    <div class="container">
      <div class="row g-4">
        <!-- Coluna 1: Sobre -->
        <div class="col-md-4">
          <h5 style="font-family: 'Fredoka', sans-serif; font-weight: 700; color: #d69040ff; margin-bottom: 20px;">
            <img src="../assets/img/patamenor.png" alt="pata menor">  AUcolher
          </h5>
          <p style="line-height: 1.8; color: rgba(255,255,255,0.85); font-size: 0.95rem;">
            Conectando corações a patinhas desde 2025. <br> Nossa missão é proporcionar um lar cheio de amor para cada animal que precisa de uma segunda chance.</p>
        </div>

        <!-- Coluna 2: Links Rápidos -->
        <div class="col-md-4 mb-4">
          <h5 style="font-family: 'Fredoka', sans-serif; font-weight: 700; color: #d69040ff; margin-bottom: 20px; font-size: 1.3rem;">
            Links Rápidos
          </h5>
          <ul style="list-style: none; padding: 0; line-height: 2.2;">
            <li><a href="#login-section" style="color: #cbd5e0; text-decoration: none; transition: all 0.3s; display: inline-block;">→ Meus Animais</a></li>
            <li><a href="cadastroUsuario.php" style="color: #cbd5e0; text-decoration: none; transition: all 0.3s; display: inline-block;">→ Solicitações Recebidas</a></li>
            <li><a href="#" style="color: #cbd5e0; text-decoration: none; transition: all 0.3s; display: inline-block;">→ Animais Disponíveis</a></li>
            <li><a href="#" style="color: #cbd5e0; text-decoration: none; transition: all 0.3s; display: inline-block;">→ Minhas Solicitações</a></li>
          </ul>
        </div>

        <!-- Coluna 3: Contato & Inspiração -->
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

      <!-- Linha separadora -->
      <hr style="border-color: rgba(255,255,255,0.2); margin: 40px 0 20px 0;">

      <!-- Copyright -->
      <div class="text-center">
        <p style="margin: 0; color: rgba(255,255,255,0.7); font-size: 0.9rem;">
          © 2025 <strong style="color: #d69040ff;">AUcolher</strong>. Todos os direitos reservados. Feito com 💛 para os pets.
        </p>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
