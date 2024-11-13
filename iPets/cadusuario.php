<?php

include_once('config.php');

// validar CPF
function validar_cpf($cpf) {

    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    if (strlen($cpf) != 11) {
        return false;
    }

    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    $soma = 0;
    for ($i = 0; $i < 9; $i++) {
        $soma += $cpf[$i] * (10 - $i);
    }
    $resto = $soma % 11;
    $digito1 = ($resto < 2) ? 0 : 11 - $resto;

    $soma = 0;
    for ($i = 0; $i < 10; $i++) {
        $soma += $cpf[$i] * (11 - $i);
    }
    $resto = $soma % 11;
    $digito2 = ($resto < 2) ? 0 : 11 - $resto;

    return ($cpf[9] == $digito1 && $cpf[10] == $digito2);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_name = isset($_POST['nome']) ? $_POST['nome'] : '';
    $user_email = isset($_POST['email']) ? $_POST['email'] : '';
    $user_tel = isset($_POST['telefone']) ? $_POST['telefone'] : '';
    $user_cpf = isset($_POST['cpf']) ? $_POST['cpf'] : '';
    $user_senha = isset($_POST['senha']) ? $_POST['senha'] : '';

    $user_cpf = preg_replace('/[^0-9]/', '', $user_cpf);
    $user_tel = preg_replace('/\D/', '', $user_tel);

    if (!empty($user_name) && !empty($user_email) && !empty($user_tel) &&
        !empty($user_cpf) && !empty($user_senha)) {

        if (!validar_cpf($user_cpf)) {
            echo "<script>
                    alert('CPF inválido!');
                    window.history.back();
                  </script>";
            exit;
        }
        
        $cmd = $connection->prepare("INSERT INTO user (user_name, user_email, user_tel, user_cpf, user_senha) VALUES (?, ?, ?, ?, ?)");
        $cmd->bind_param("sssss", $user_name, $user_email, $user_tel, $user_cpf, $user_senha);

        if ($cmd->execute()) {
            echo "<script>
                    alert('Cadastrado com sucesso!');
                    window.location.href = 'loginusuario.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Erro ao cadastrar: " . $cmd->error . "');
                    window.history.back();
                  </script>";
        }

        $cmd->close();
    } else {
        echo "<script>
                alert('Preencha todos os campos.');
                window.history.back();
              </script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/stylecadus.css">
    <title>Cadastro | iPets</title>
</head>
<body style="background-color:#00154B">
    <div class="box">
        <form action="cadusuario.php" method="POST">
            <h1>Cadastre-se aqui!</h1>
            <br>
            <div class="inputBox">
                <input type="text" name="nome" id="nome" class="inputUser" required>
                <label for="nome" class="labelInput">Nome completo</label>
            </div>
            <br><br>
            <div class="inputBox">
                <input type="text" name="email" id="email" class="inputUser" required>
                <label for="email" class="labelInput">Email</label>
            </div>
            <br><br>
            <div class="inputBox">
                <input type="tel" name="telefone" id="telefone" class="inputUser" required>
                <label for="telefone" class="labelInput">Telefone</label>
            </div>
            <br><br>
            <div class="inputBox">
                <input type="text" name="cpf" id="cpf" class="inputUser" required>
                <label for="cpf" class="labelInput">CPF</label>
            </div>
            <br><br>
            <div class="inputBox">
                <input type="password" name="senha" id="senha" class="inputUser" required>
                <label for="senha" class="labelInput">Senha</label>
            </div>
            <br><br>
            <input type="submit" name="submit" id="submit">
        </form>
    </div>

    <!-- jquery para aplicar máscara do cpf e telefone -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script>
        $('#cpf').mask('000.000.000-00');
        $('#telefone').mask('(00) 0 0000-0000');
    </script>

</body>
</html>
