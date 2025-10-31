<?php
require 'config.php';

$nome= $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "INSERT INTO usuarios (nome_usuario, email_usuario, senha_usuario) VALUES('$nome', '$email', '$senha')";
if($conn -> query ($sql) === TRUE){
  header("Location: index.php");

} else{
    echo "Erro: " . $conn->error;

}

?>