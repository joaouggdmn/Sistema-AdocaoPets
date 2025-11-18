<?php
session_start();
require 'config.php';

// Verifica se está logado
if (!isset($_SESSION['logado'])) {
    header("Location: login.php");
    exit;
}

// Captura os dados do formulário
$nome = $_POST['nome'];
$tipo = $_POST['tipo'];
$raca = $_POST['raca'];
$idade = $_POST['idade'];
$sexo = $_POST['sexo'];
$descricao = $_POST['descricao'];
// Pega o id_usuario da sessão (tabela usuarios) para inserir como usuario_id na tabela animais
$usuario_id = $_SESSION['id_usuario'];

// Processa o upload da foto (se houver)
$foto_nome = null;
if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0){
    $foto_tmp = $_FILES['foto']['tmp_name'];
    $foto_nome_original = $_FILES['foto']['name'];
    $foto_extensao = strtolower(pathinfo($foto_nome_original, PATHINFO_EXTENSION));
    
    // Valida extensão
    $extensoes_permitidas = array('jpg', 'jpeg', 'png', 'gif');
    if(in_array($foto_extensao, $extensoes_permitidas)){
        // Valida tamanho (5MB)
        if($_FILES['foto']['size'] <= 5242880){
            // Gera nome único para a foto
            $foto_nome = uniqid() . '_' . time() . '.' . $foto_extensao;
            $foto_destino = 'uploads/' . $foto_nome;
            
            // Cria a pasta uploads se não existir
            if(!file_exists('uploads')){
                mkdir('uploads', 0777, true);
            }
            
            // Move o arquivo
            if(!move_uploaded_file($foto_tmp, $foto_destino)){
                $_SESSION['erro'] = "❌ Erro ao fazer upload da foto!";
                header("Location: cadastroAnimal.php");
                exit;
            }
        } else {
            $_SESSION['erro'] = "❌ A foto deve ter no máximo 5MB!";
            header("Location: cadastroAnimal.php");
            exit;
        }
    } else {
        $_SESSION['erro'] = "❌ Formato de imagem inválido! Use JPG, PNG ou GIF.";
        header("Location: cadastroAnimal.php");
        exit;
    }
}

// Insere o animal no banco usando prepared statement
$stmt = $conn->prepare("INSERT INTO animais (nome_animal, tipo_animal, raca_animal, idade_animal, sexo_animal, descricao_animal, foto_animal, usuario_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssi", $nome, $tipo, $raca, $idade, $sexo, $descricao, $foto_nome, $usuario_id);

if($stmt->execute()){
    $_SESSION['sucesso'] = "✅ Animal cadastrado com sucesso! Ele já está disponível para adoção! 🐾";
    header("Location: painelUsuario.php");
} else {
    $_SESSION['erro'] = "❌ Erro ao cadastrar animal: " . $conn->error;
    header("Location: cadastroAnimal.php");
}

$stmt->close();
$conn->close();
?>
