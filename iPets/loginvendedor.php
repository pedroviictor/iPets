<?php
session_start();
include_once("config.php");

if (isset($_POST['email']) && isset($_POST['senha'])) {
    if (strlen($_POST['email']) == 0) {
        echo "<script>alert('Preencha seu e-mail.');</script>";
    } else if (strlen($_POST['senha']) == 0) {
        echo "<script>alert('Preencha sua senha.');</script>";
    } else {
        $store_email = $_POST['email'];
        $store_senha = $_POST['senha'];

        $cmd = $connection->prepare("SELECT * FROM store WHERE store_email = ? AND store_senha = ?");

        if ($cmd === false) {
            die("Erro na preparação da consulta: " . $connection->error);
        }

        $cmd->bind_param("ss", $store_email, $store_senha);
        $cmd->execute();
        $result = $cmd->get_result();

        if ($result->num_rows > 0) {
            $store_data = $result->fetch_assoc();

            $_SESSION['store_data'] = [
                'id' => $store_data['store_id'],
                'nome' => $store_data['store_name'],
                'email' => $store_data['store_email'],
                'telefone' => $store_data['store_tel'],
                'cnpj' => $store_data['store_cnpj'],
                'cidade' => $store_data['store_cidade'],
                'estado' => $store_data['store_estado'],
                'endereco' => $store_data['store_end'],
            ];
            header("Location: perfilvendedor.php");
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

<body style="background-color:#00154B">
    <div>
        <h1>Bem-vindo de volta!</h1>
        <form method="POST">
            <input type="text" name="email" id="email" placeholder="Digite seu email" required>
            <br><br>
            <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
            <br><br>
            <button type="submit">Entrar</button>
            <br><br>
            <a href="cadselect.php">Não possui conta? Crie aqui</a>
        </form>
    </div>
</body>

</html>