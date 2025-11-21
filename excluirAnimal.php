<?php
session_start();
require 'config.php';

// Verifica se está logado
if (!isset($_SESSION['logado'])) {
    header("Location: login.php");
    exit;
}

// Verifica se o ID foi passado
if(!isset($_GET['id']) || empty($_GET['id'])){
    $_SESSION['erro'] = "❌ Animal não encontrado!";
    header("Location: painelUsuario.php");
    exit;
}

$id_animal = $_GET['id'];
$id_usuario = $_SESSION['id_usuario'];

// Verifica se o animal pertence ao usuário logado
$sql_verifica = "SELECT * FROM animais WHERE id_animal = $id_animal AND usuario_id = $id_usuario";
$result = $conn->query($sql_verifica);

if($result->num_rows == 0){
    $_SESSION['erro'] = "❌ Você não tem permissão para excluir este animal!";
    header("Location: painelUsuario.php");
    exit;
}

$animal = $result->fetch_assoc();

// Exclui a foto se existir
if($animal['foto_animal'] && file_exists('uploads/' . $animal['foto_animal'])){
    unlink('uploads/' . $animal['foto_animal']);
}

// Exclui o animal do banco
$sql_excluir = "DELETE FROM animais WHERE id_animal = $id_animal";

if($conn->query($sql_excluir) === TRUE){
    $_SESSION['sucesso'] = "✅ Animal excluído com sucesso!";
} else {
    $_SESSION['erro'] = "❌ Erro ao excluir: " . $conn->error;
}

header("Location: painelUsuario.php");
?>
