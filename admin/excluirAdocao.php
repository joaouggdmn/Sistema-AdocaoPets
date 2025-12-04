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

// Busca informações da adoção antes de excluir
$sql_info = "SELECT animal_id, status_solicitacao FROM adocao WHERE id_adocao = ?";
$stmt_info = $conn->prepare($sql_info);
$stmt_info->bind_param("i", $id_adocao);
$stmt_info->execute();
$result_info = $stmt_info->get_result();

if ($result_info->num_rows == 0) {
  $_SESSION['erro'] = "Adoção não encontrada!";
  header("Location: painelAdmin.php#adocoes");
  exit;
}

$adocao_info = $result_info->fetch_assoc();
$stmt_info->close();

// Procede com a exclusão
$sql = "DELETE FROM adocao WHERE id_adocao = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_adocao);

if ($stmt->execute()) {
  // Se a adoção excluída estava aprovada, volta o animal para disponível
  if ($adocao_info['status_solicitacao'] == 'aprovada') {
    $sql_animal = "UPDATE animais SET status_animal = 'Disponível' WHERE id_animal = ?";
    $stmt_animal = $conn->prepare($sql_animal);
    $stmt_animal->bind_param("i", $adocao_info['animal_id']);
    $stmt_animal->execute();
    $stmt_animal->close();
  }

  $_SESSION['sucesso'] = "✅ Adoção excluída com sucesso!";
} else {
  $_SESSION['erro'] = "❌ Erro ao excluir adoção: " . $conn->error;
}

$stmt->close();
$conn->close();

header("Location: painelAdmin.php#adocoes");
exit;
?>
