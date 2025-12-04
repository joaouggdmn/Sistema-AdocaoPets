<?php
session_start();
require '../config.php';

$id_animal = $_GET['id'];
$id_adotante = $_SESSION['id_usuario'];

// Busca informações do animal e do doador
$sql_busca = "SELECT nome_animal, usuario_id FROM animais WHERE id_animal = ?";
$stmt_busca = $conn->prepare($sql_busca);
$stmt_busca->bind_param("i", $id_animal);
$stmt_busca->execute();
$result = $stmt_busca->get_result();
$animal = $result->fetch_assoc();
$nome_animal = $animal['nome_animal'];
$id_doador = $animal['usuario_id'];
$stmt_busca->close();

// Verifica se o usuário já tem uma solicitação pendente para este animal
$sql_verifica = "SELECT id_adocao FROM adocao WHERE animal_id = ? AND adotante_id = ? AND status_solicitacao = 'pendente'";
$stmt_verifica = $conn->prepare($sql_verifica);
$stmt_verifica->bind_param("ii", $id_animal, $id_adotante);
$stmt_verifica->execute();
$result_verifica = $stmt_verifica->get_result();

if($result_verifica->num_rows > 0){
    $_SESSION['erro'] = "⏳ Você já tem uma solicitação pendente para {$nome_animal}. Aguarde a resposta do doador!";
    header("Location: painelUsuario.php");
    exit;
}
$stmt_verifica->close();

// Cria uma solicitação de adoção com status pendente
$sql_solicitacao = "INSERT INTO adocao (animal_id, adotante_id, doador_id, data_solicitacao, status_solicitacao) VALUES (?, ?, ?, NOW(), 'pendente')";
$stmt_solicitacao = $conn->prepare($sql_solicitacao);
$stmt_solicitacao->bind_param("iii", $id_animal, $id_adotante, $id_doador);

if($stmt_solicitacao->execute()){
    $_SESSION['sucesso'] = "✅ Solicitação enviada! O doador de {$nome_animal} receberá sua solicitação e irá avaliá-la em breve! 🐾";
    header("Location: painelUsuario.php#minhas-solicitacoes");
} else {
    $_SESSION['erro'] = "❌ Erro ao enviar solicitação. Tente novamente!";
    header("Location: painelUsuario.php");
}

$stmt_solicitacao->close();
$conn->close();
?>
