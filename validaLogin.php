<?php
session_start();
require 'config.php';

$email = $_POST['email'];
$senha = md5($_POST['senha']);

$sql = "SELECT * FROM usuarios WHERE email_usuario='$email' AND senha_usuario='$senha'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $_SESSION['logado'] = true;
    $_SESSION['id_usuario'] = $user['id_usuario'];
    $_SESSION['nome'] = $user['nome_usuario'];
    $_SESSION['email'] = $user['email_usuario'];
    $_SESSION['nivel_usuario'] = $user['nivel_usuario'];

    if ($user['nivel_usuario'] == 'admin') {
        header("Location: painelAdmin.php");
    } else {
        header("Location: painelUsuario.php");
    }
    exit;
} else {
    $_SESSION['erro'] = "❌ Usuário ou senha incorretos!";
    header("Location: index.php#login-section");
    exit;
}
?>
