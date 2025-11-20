<?php
session_start();
require 'config.php';

// Verifica se está logado
if (!isset($_SESSION['logado'])) {
    header("Location: login.php");
    exit;
}

// Pega os dados do formulário
$nome = $_POST['nome'];
$tipo = $_POST['tipo'];
$raca = $_POST['raca'];
$idade = $_POST['idade'];
$sexo = $_POST['sexo'];
$descricao = $_POST['descricao'];
$usuario_id = $_SESSION['id_usuario'];

// Processa o upload da foto (se houver)
$foto_nome = null;
if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0){
    $foto_nome = $_FILES['foto']['name'];
    move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads/' . $foto_nome);
}

// Insere o animal no banco (método simples como salvarUsuario.php)
$sql = "INSERT INTO animais (nome_animal, tipo_animal, raca_animal, idade_animal, sexo_animal, descricao_animal, foto_animal, usuario_id) 
        VALUES('$nome', '$tipo', '$raca', '$idade', '$sexo', '$descricao', '$foto_nome', '$usuario_id')";

if($conn->query($sql) === TRUE){
    $_SESSION['sucesso'] = "✅ Animal cadastrado com sucesso! Ele já está disponível para adoção! 🐾";
    header("Location: painelUsuario.php");
} else {
    $_SESSION['erro'] = "❌ Erro ao cadastrar: " . $conn->error;
    header("Location: cadastroAnimal.php");
}
?>
