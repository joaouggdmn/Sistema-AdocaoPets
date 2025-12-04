<?php
session_start();
require '../config.php';

// Verifica se está logado
if (!isset($_SESSION['logado'])) {
    header("Location: ../index.php#login-section");
    exit;
}

// Verifica se o ID foi passado
if(!isset($_GET['id']) || empty($_GET['id'])){
    $_SESSION['erro'] = "❌ Animal não encontrado!";
    $redirect = ($_SESSION['nivel_usuario'] == 'admin') ? '../admin/painelAdmin.php' : '../user/painelUsuario.php';
    header("Location: $redirect");
    exit;
}

$id_animal = $_GET['id'];
$id_usuario = $_SESSION['id_usuario'];
$nivel_usuario = $_SESSION['nivel_usuario'];

// Admin pode excluir qualquer animal, usuário normal só os seus
if($nivel_usuario == 'admin'){
    $sql_verifica = "SELECT * FROM animais WHERE id_animal = $id_animal";
} else {
    $sql_verifica = "SELECT * FROM animais WHERE id_animal = $id_animal AND usuario_id = $id_usuario";
}

$result = $conn->query($sql_verifica);

if($result->num_rows == 0){
    $_SESSION['erro'] = "❌ Você não tem permissão para excluir este animal!";
    $redirect = ($nivel_usuario == 'admin') ? '../admin/painelAdmin.php' : '../user/painelUsuario.php';
    header("Location: $redirect");
    exit;
}

$animal = $result->fetch_assoc();

// Exclui a foto se existir
if($animal['foto_animal'] && file_exists('../assets/uploads/' . $animal['foto_animal'])){
    unlink('../assets/uploads/' . $animal['foto_animal']);
}

// Exclui o animal do banco
$sql_excluir = "DELETE FROM animais WHERE id_animal = $id_animal";

if($conn->query($sql_excluir) === TRUE){
    $_SESSION['sucesso'] = "✅ Animal excluído com sucesso!";
} else {
    $_SESSION['erro'] = "❌ Erro ao excluir: " . $conn->error;
}

$redirect = ($_SESSION['nivel_usuario'] == 'admin') ? '../admin/painelAdmin.php' : '../user/painelUsuario.php';
header("Location: $redirect");
?>
