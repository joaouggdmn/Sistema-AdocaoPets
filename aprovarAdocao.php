<?php
session_start();
require 'config.php';

$id_adocao = $_GET['id'];
$acao = $_GET['acao']; // 'aprovar' ou 'recusar'
$id_usuario = $_SESSION['id_usuario'];

// Verifica se a solicitação existe e se o usuário é o doador
$sql_verifica = "SELECT a.*, an.nome_animal FROM adocao a 
                 INNER JOIN animais an ON a.animal_id = an.id_animal 
                 WHERE a.id_adocao = ? AND a.doador_id = ? AND a.status_adocao = 'pendente'";
$stmt_verifica = $conn->prepare($sql_verifica);
$stmt_verifica->bind_param("ii", $id_adocao, $id_usuario);
$stmt_verifica->execute();
$result = $stmt_verifica->get_result();

if($result->num_rows == 0){
    $_SESSION['erro'] = "❌ Solicitação não encontrada ou você não tem permissão!";
    header("Location: painelUsuario.php");
    exit;
}

$solicitacao = $result->fetch_assoc();
$nome_animal = $solicitacao['nome_animal'];
$id_animal = $solicitacao['id_animal'];
$id_adotante = $solicitacao['id_adotante'];
$stmt_verifica->close();

if($acao == 'aprovar'){
    // Atualiza status da solicitação para aprovada
    $sql_aprovar = "UPDATE adocao SET status_adocao = 'aprovada', data_resposta = NOW(), data_adocao = NOW() WHERE id_adocao = ?";
    $stmt_aprovar = $conn->prepare($sql_aprovar);
    $stmt_aprovar->bind_param("i", $id_adocao);
    $stmt_aprovar->execute();
    $stmt_aprovar->close();
    
    // Atualiza o animal para status Adotado
    $sql_animal = "UPDATE animais SET status_adocao = 'Adotado' WHERE id_animal = ?";
    $stmt_animal = $conn->prepare($sql_animal);
    $stmt_animal->bind_param("i", $id_animal);
    $stmt_animal->execute();
    $stmt_animal->close();
    
    // Recusa todas as outras solicitações pendentes para este animal
    $sql_recusar_outros = "UPDATE adocao SET status_adocao = 'recusada', data_resposta = NOW() 
                           WHERE animal_id = ? AND id_adocao != ? AND status_adocao = 'pendente'";
    $stmt_recusar = $conn->prepare($sql_recusar_outros);
    $stmt_recusar->bind_param("ii", $id_animal, $id_adocao);
    $stmt_recusar->execute();
    $stmt_recusar->close();
    
    $_SESSION['sucesso'] = "✅ Solicitação aprovada! {$nome_animal} foi adotado com sucesso! 🎉";
    
} elseif($acao == 'recusar'){
    // Atualiza status da solicitação para recusada
    $sql_recusar = "UPDATE adocao SET status_adocao = 'recusada', data_resposta = NOW() WHERE id_adocao = ?";
    $stmt_recusar = $conn->prepare($sql_recusar);
    $stmt_recusar->bind_param("i", $id_adocao);
    $stmt_recusar->execute();
    $stmt_recusar->close();
    
    $_SESSION['sucesso'] = "✅ Solicitação recusada.";
} else {
    $_SESSION['erro'] = "❌ Ação inválida!";
}

header("Location: painelUsuario.php#solicitacoes-recebidas");
exit;
?>
