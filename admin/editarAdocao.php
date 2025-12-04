<?php
session_start();
require '../config.php';

// Verifica se é admin
if (!isset($_SESSION['logado']) || $_SESSION['nivel_usuario'] != 'admin') {
  header("Location: ../index.php");
  exit;
}

// Verifica se o ID foi passado
if (!isset($_GET['id'])) {
  $_SESSION['erro'] = "ID da adoção não informado!";
  header("Location: painelAdmin.php#adocoes");
  exit;
}

$id_adocao = $_GET['id'];

// Busca os dados da adoção
$sql = "SELECT a.*, 
               an.nome_animal, an.tipo_animal,
               doador.nome_usuario as nome_doador,
               adotante.nome_usuario as nome_adotante
        FROM adocao a
        INNER JOIN animais an ON a.animal_id = an.id_animal
        INNER JOIN usuarios doador ON a.doador_id = doador.id_usuario
        INNER JOIN usuarios adotante ON a.adotante_id = adotante.id_usuario
        WHERE a.id_adocao = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_adocao);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
  $_SESSION['erro'] = "Adoção não encontrada!";
  header("Location: painelAdmin.php#adocoes");
  exit;
}

$adocao = $result->fetch_assoc();
$stmt->close();

// Processa o formulário de edição
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $novo_status = $_POST['status_solicitacao'];
  $data_resposta = !empty($_POST['data_resposta']) ? $_POST['data_resposta'] : NULL;
  $data_adocao = !empty($_POST['data_adocao']) ? $_POST['data_adocao'] : NULL;

  // Atualiza a adoção
  $sql_update = "UPDATE adocao SET 
                 status_solicitacao = ?,
                 data_resposta = ?,
                 data_adocao = ?
                 WHERE id_adocao = ?";
  $stmt_update = $conn->prepare($sql_update);
  $stmt_update->bind_param("sssi", $novo_status, $data_resposta, $data_adocao, $id_adocao);

  if ($stmt_update->execute()) {
    // Se mudou para aprovada, atualiza o status do animal
    if ($novo_status == 'aprovada') {
      $sql_animal = "UPDATE animais SET status_animal = 'Adotado' WHERE id_animal = ?";
      $stmt_animal = $conn->prepare($sql_animal);
      $stmt_animal->bind_param("i", $adocao['animal_id']);
      $stmt_animal->execute();
      $stmt_animal->close();

      // Rejeita outras solicitações pendentes para o mesmo animal
      $sql_rejeitar = "UPDATE adocao SET status_solicitacao = 'recusada', data_resposta = NOW() 
                       WHERE animal_id = ? AND id_adocao != ? AND status_solicitacao = 'pendente'";
      $stmt_rejeitar = $conn->prepare($sql_rejeitar);
      $stmt_rejeitar->bind_param("ii", $adocao['animal_id'], $id_adocao);
      $stmt_rejeitar->execute();
      $stmt_rejeitar->close();
    }
    // Se mudou de aprovada para outro status, volta o animal para disponível
    elseif ($adocao['status_solicitacao'] == 'aprovada' && $novo_status != 'aprovada') {
      $sql_animal = "UPDATE animais SET status_animal = 'Disponível' WHERE id_animal = ?";
      $stmt_animal = $conn->prepare($sql_animal);
      $stmt_animal->bind_param("i", $adocao['animal_id']);
      $stmt_animal->execute();
      $stmt_animal->close();
    }

    $_SESSION['sucesso'] = "Adoção atualizada com sucesso!";
  } else {
    $_SESSION['erro'] = "Erro ao atualizar adoção: " . $conn->error;
  }

  $stmt_update->close();
  header("Location: painelAdmin.php#adocoes");
  exit;
}
?>
<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar Adoção - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800&family=Fredoka:wght@400;600&display=swap" rel="stylesheet">
  <link href="../css/admin.css" rel="stylesheet">
  <style>
    body {
      padding: 40px 0;
    }

    .container {
      max-width: 800px;
    }

    h3 {
      color: #FF6B6B;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="card p-4">
      <h3 class="text-center mb-4">✏️ Editar Adoção</h3>

      <div class="info-box">
        <h5 style="color: #FF6B6B; font-weight: 700; margin-bottom: 10px;">📋 Informações da Adoção</h5>
        <p class="mb-1"><strong>🐾 Animal:</strong> <?= $adocao['nome_animal'] ?> (<?= $adocao['tipo_animal'] ?>)</p>
        <p class="mb-1"><strong>🏠 Doador:</strong> <?= $adocao['nome_doador'] ?></p>
        <p class="mb-1"><strong>💕 Adotante:</strong> <?= $adocao['nome_adotante'] ?></p>
        <p class="mb-0"><strong>📅 Solicitado em:</strong> <?= date('d/m/Y H:i', strtotime($adocao['data_solicitacao'])) ?></p>
      </div>

      <form method="POST">
        <div class="mb-3">
          <label for="status_solicitacao" class="form-label">Status da Solicitação</label>
          <select class="form-select" id="status_solicitacao" name="status_solicitacao" required>
            <option value="pendente" <?= $adocao['status_solicitacao'] == 'pendente' ? 'selected' : '' ?>>⏳ Pendente</option>
            <option value="aprovada" <?= $adocao['status_solicitacao'] == 'aprovada' ? 'selected' : '' ?>>✅ Aprovada</option>
            <option value="recusada" <?= $adocao['status_solicitacao'] == 'recusada' ? 'selected' : '' ?>>❌ Recusada</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="data_resposta" class="form-label">Data da Resposta (Aprovação/Recusa)</label>
          <input type="datetime-local" class="form-control" id="data_resposta" name="data_resposta" 
                 value="<?= $adocao['data_resposta'] ? date('Y-m-d\TH:i', strtotime($adocao['data_resposta'])) : '' ?>">
          <small class="text-muted">Deixe em branco se ainda não houve resposta</small>
        </div>

        <div class="mb-4">
          <label for="data_adocao" class="form-label">Data da Adoção Efetivada</label>
          <input type="datetime-local" class="form-control" id="data_adocao" name="data_adocao" 
                 value="<?= $adocao['data_adocao'] ? date('Y-m-d\TH:i', strtotime($adocao['data_adocao'])) : '' ?>">
          <small class="text-muted">Preencha apenas se a adoção foi aprovada</small>
        </div>

        <div class="d-flex gap-3 justify-content-center">
          <button type="submit" class="btn btn-primary">💾 Salvar Alterações</button>
          <a href="painelAdmin.php#adocoes" class="btn btn-secondary">❌ Cancelar</a>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
