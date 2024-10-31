<?php
session_start();
include_once("config.php");

if (isset($_POST['email']) && isset($_POST['senha'])) {
    if (strlen($_POST['email']) == 0) {
        echo "<script>alert('Preencha seu e-mail.');</script>";
    } else if (strlen($_POST['senha']) == 0) {
        echo "<script>alert('Preencha sua senha.');</script>";
    } else {
        $user_email = $_POST['email'];
        $user_senha = $_POST['senha'];

        $cmd = $connection->prepare("SELECT * FROM user WHERE user_email = ? AND user_senha = ?");
        
        if ($cmd === false) {
            die("Erro na preparação da consulta: " . $connection->error);
        }

        $cmd->bind_param("ss", $user_email, $user_senha);
        $cmd->execute();
        $result = $cmd->get_result();

        if ($result->num_rows > 0) {
            $user_data = $result->fetch_assoc();

            $_SESSION['user_data'] = [
                'nome' => $user_data['user_name'],
                'email' => $user_data['user_email'],
                'telefone' => $user_data['user_tel'],
                'cpf' => $user_data['user_cpf']
            ];
            header("Location: perfilusuario.php");
            exit();
        } else {
            echo "<script>alert('E-mail ou senha incorretos.');</script>";
        }
        
        $cmd->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/stylelog.css">
    <title>Login | iPets</title>
</head>

<body style="background: url('img/fundo.png') no-repeat center center fixed; background-size: cover;">
    <div>
        <h1>Bem-vindo de volta!</h1>
        <form method="POST">
            <input type="text" name="email" id="email" placeholder="Digite seu email" required>
            <br><br>
            <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
            <br><br>
            <button type="submit">Entrar</button>
            <br><br>
            <a href="select.php">Não possui conta? Crie aqui</a>
        </form>
    </div>
</body>

</html>
