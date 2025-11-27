<?php
session_start();
require 'config.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['logado']) || !isset($_SESSION['id_usuario'])) {
    $_SESSION['erro'] = "❌ Você precisa estar logado para adotar um animal!";
    header("Location: index.php");
    exit;
}

$id_animal = $_GET['id'];
$id_usuario = $_SESSION['id_usuario'];

// Primeiro busca o nome do animal
$sql_busca = "SELECT nome_animal FROM animais WHERE id_animal = ?";
$stmt_busca = $conn->prepare($sql_busca);
$stmt_busca->bind_param("i", $id_animal);
$stmt_busca->execute();
$result = $stmt_busca->get_result();
$animal = $result->fetch_assoc();
$nome_animal = $animal['nome_animal'];
$stmt_busca->close();

// Atualiza o animal com status Adotado e registra quem adotou
$sql_atualiza = "UPDATE animais SET status_adocao = 'Adotado', adotante_id = ? WHERE id_animal = ?";
$stmt_atualiza = $conn->prepare($sql_atualiza);
$stmt_atualiza->bind_param("ii", $id_usuario, $id_animal);

if($stmt_atualiza->execute()){
    $_SESSION['sucesso'] = "🎉 Parabéns! Você adotou {$nome_animal}! Que esse novo amiguinho traga muita alegria! 🐾❤️";
    header("Location: painelUsuario.php#meus-adotados");
} else {
    $_SESSION['erro'] = "❌ Erro ao processar a adoção. Tente novamente!";
    header("Location: painelUsuario.php");
}

$stmt_atualiza->close();
$conn->close();
?>
