<?php
session_start();
require '../config.php';

$id_adocao = $_GET['id'];
$acao = $_GET['acao']; // 'aprovar' ou 'recusar'
$id_usuario = $_SESSION['id_usuario'];

// Verifica se a solicitação existe e se o usuário é o doador
$sql_verifica = "SELECT a.animal_id, a.adotante_id, an.nome_animal FROM adocao a 
                 INNER JOIN animais an ON a.animal_id = an.id_animal 
                 WHERE a.id_adocao = ? AND a.doador_id = ? AND a.status_solicitacao = 'pendente'";
$stmt_verifica = $conn->prepare($sql_verifica);
$stmt_verifica->bind_param("ii", $id_adocao, $id_usuario);
$stmt_verifica->execute();
$result = $stmt_verifica->get_result();

if($result->num_rows == 0){
    $_SESSION['erro'] = "❌ Solicitação não encontrada ou você não tem permissão!";
    header("Location: ../user/painelUsuario.php");
    exit;
}

$solicitacao = $result->fetch_assoc();
$nome_animal = $solicitacao['nome_animal'];
$id_animal = $solicitacao['animal_id'];
$id_adotante = $solicitacao['adotante_id'];
$stmt_verifica->close();

if($acao == 'aprovar'){

    // PRIMEIRO: Verifica se o animal já foi adotado
    $sql_check = "SELECT status_animal FROM animais WHERE id_animal = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $id_animal);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $animal_status = $result_check->fetch_assoc();
    $stmt_check->close();
    
    if($animal_status['status_animal'] == 'Adotado'){
        $_SESSION['erro'] = "❌ Este animal já foi adotado por outra pessoa!";
        header("Location: ../user/painelUsuario.php#solicitacoes-recebidas");
        exit;
    }
    
    // Atualiza status da solicitação para aprovada
    $sql_aprovar = "UPDATE adocao SET status_solicitacao = 'aprovada', data_resposta = NOW(), data_adocao = NOW() WHERE id_adocao = ?";
    $stmt_aprovar = $conn->prepare($sql_aprovar);
    $stmt_aprovar->bind_param("i", $id_adocao);
    
    if(!$stmt_aprovar->execute()){
        $_SESSION['erro'] = "❌ Erro ao aprovar solicitação: " . $stmt_aprovar->error;
        header("Location: ../user/painelUsuario.php#solicitacoes-recebidas");
        exit;
    }
    $stmt_aprovar->close();
    
    // Atualiza o animal para status Adotado
    $sql_animal = "UPDATE animais SET status_animal = 'Adotado' WHERE id_animal = ?";
    $stmt_animal = $conn->prepare($sql_animal);
    $stmt_animal->bind_param("i", $id_animal);
    
    if(!$stmt_animal->execute()){
        $_SESSION['erro'] = "❌ Erro ao atualizar animal: " . $stmt_animal->error;
        header("Location: ../user/painelUsuario.php#solicitacoes-recebidas");
        exit;
    }
    $stmt_animal->close();
    
    // Recusa todas as outras solicitações pendentes para este animal
    $sql_recusar_outros = "UPDATE adocao SET status_solicitacao = 'recusada', data_resposta = NOW() 
                           WHERE animal_id = ? AND id_adocao != ? AND status_solicitacao = 'pendente'";
    $stmt_recusar = $conn->prepare($sql_recusar_outros);
    $stmt_recusar->bind_param("ii", $id_animal, $id_adocao);
    $stmt_recusar->execute();
    $stmt_recusar->close();
    
    $_SESSION['sucesso'] = "✅ Solicitação aprovada! {$nome_animal} foi adotado com sucesso!";
    
} elseif($acao == 'recusar'){
    // Atualiza status da solicitação para recusada
    $sql_recusar = "UPDATE adocao SET status_solicitacao = 'recusada', data_resposta = NOW() WHERE id_adocao = ?";
    $stmt_recusar = $conn->prepare($sql_recusar);
    $stmt_recusar->bind_param("i", $id_adocao);
    $stmt_recusar->execute();
    $stmt_recusar->close();
    
    $_SESSION['sucesso'] = "✅ Solicitação recusada.";
} else {
    $_SESSION['erro'] = "❌ Ação inválida!";
}

header("Location: ../user/painelUsuario.php#solicitacoes-recebidas");
exit;
?>
