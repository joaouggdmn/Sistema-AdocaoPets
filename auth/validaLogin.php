<?php
session_start();
require '../config.php';

$email = $_POST['email_usuario'];
$senha = md5($_POST['senha']);

$sql = "SELECT * FROM usuarios WHERE email_usuario='$email' AND senha_usuario='$senha'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $_SESSION['logado'] = true;
    $_SESSION['id_usuario'] = $user['id_usuario'];
    $_SESSION['nome_usuario'] = $user['nome_usuario'];
    $_SESSION['email_usuario'] = $user['email_usuario'];
    $_SESSION['nivel_usuario'] = $user['nivel_usuario'];

    if ($user['nivel_usuario'] == 'admin') {
        header("Location: ../admin/painelAdmin.php");
    } else {
        header("Location: ../user/painelUsuario.php");
    }
    exit;
} else {
    $_SESSION['erro'] = "❌ Usuário ou senha incorretos!";
    header("Location: ../index.php#login-section");
    exit;
}
?>
