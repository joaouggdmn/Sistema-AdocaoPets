<?php
session_start();
require 'config.php';

$id_animal = $_GET['id'];

$sql_atualiza = "UPDATE animais SET status_adocao = 'Adotado' WHERE id_animal = ?";
$stmt_atualiza = $conn->prepare($sql_atualiza);
$stmt_atualiza->bind_param("i", $id_animal);

if($stmt_atualiza->execute()){
    $_SESSION['sucesso'] = "🎉 Parabéns! Você adotou {$animal['nome_animal']}! Que esse novo amiguinho traga muita alegria! 🐾❤️";
    header("Location: painelUsuario.php");
} else {
    $_SESSION['erro'] = "❌ Erro ao processar a adoção. Tente novamente!";
    header("Location: painelUsuario.php");
}

$stmt_atualiza->close();
$conn->close();
?>
