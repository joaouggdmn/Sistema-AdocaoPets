<?php
require 'config.php';

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "INSERT INTO usuarios (email_usuario, senha_usuario) VALUES('$email', '$senha')";
if($conn -> query ($sql) === TRUE){
  header("Location: index.php");

} else{
    echo "Erro: " . $conn->error;

}

?>