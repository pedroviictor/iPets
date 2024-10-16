<?php
include_once('config.php');

// validar CNPJ
function validar_cnpj($cnpj) {

    $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

    if (strlen($cnpj) != 14) {
        return false;
    }

    if (preg_match('/(\d)\1{13}/', $cnpj)) {
        return false;
    }

    // primeiro dígito verificador
    $soma = 0;
    $multiplicador = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

    for ($i = 0; $i < 12; $i++) {
        $soma += $cnpj[$i] * $multiplicador[$i];
    }

    $resto = $soma % 11;
    $digito1 = ($resto < 2) ? 0 : 11 - $resto;

    // segundo dígito verificador
    $soma = 0;
    $multiplicador = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

    for ($i = 0; $i < 13; $i++) {
        $soma += $cnpj[$i] * $multiplicador[$i];
    }

    $resto = $soma % 11;
    $digito2 = ($resto < 2) ? 0 : 11 - $resto;

    return ($cnpj[12] == $digito1 && $cnpj[13] == $digito2);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $store_name = isset($_POST['nome']) ? $_POST['nome'] : '';
    $store_email = isset($_POST['email']) ? $_POST['email'] : '';
    $store_tel = isset($_POST['telefone']) ? $_POST['telefone'] : '';
    $store_cnpj = isset($_POST['cnpj']) ? $_POST['cnpj'] : '';
    $store_cidade = isset($_POST['cidade']) ? $_POST['cidade'] : '';
    $store_estado = isset($_POST['estado']) ? $_POST['estado'] : '';
    $store_end = isset($_POST['endereco']) ? $_POST['endereco'] : '';
    $store_senha = isset($_POST['senha']) ? $_POST['senha'] : '';

    // apagar caracteres especiais do cnpj e telefone
    $store_cnpj = preg_replace('/[^0-9]/', '', $store_cnpj);
    $store_tel = preg_replace('/\D/', '', $store_tel);


    if (
        !empty($store_name) && !empty($store_email) && !empty($store_tel) &&
        !empty($store_cnpj) && !empty($store_cidade) && !empty($store_estado) &&
        !empty($store_end) && !empty($store_senha)
    ) {

        if (!validar_cnpj($store_cnpj)) {
            echo "<script>
                    alert('CNPJ inválido!');
                    window.history.back();
                  </script>";
            exit;
        }

        $cmd = $connection->prepare("INSERT INTO store (store_name, store_email, store_tel, store_cnpj, store_cidade, store_estado, store_end, store_senha) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $cmd->bind_param("ssssssss", $store_name, $store_email, $store_tel, $store_cnpj, $store_cidade, $store_estado, $store_end, $store_senha);

        if ($cmd->execute()) {
            echo "<script>
                    alert('Cadastrado com sucesso!');
                    window.location.href = 'login.php';
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
    <link rel="stylesheet" href="./CSS/stylecadvend.css">
    <script src="./JS/scripCadvendedor.js"></script>
    <title>Cadastro | iPets</title>
</head>

<body style="background: url('img/fundo.png') no-repeat center center fixed; background-size: cover;">
    <div class="box">
        <form action="cadvendedor.php" method="POST" onsubmit="return validarCNPJ(document.getElementById('cnpj').value)">
            <h1>Cadastre sua loja aqui!</h1>

            <div class="inputBox">
                <input type="text" name="nome" id="nome" class="inputUser" required>
                <label for="nome" class="labelInput">Nome da Loja</label>
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
                <input type="text" name="cnpj" id="cnpj" class="inputUser" required oninput="verificarCNPJ()">
                <label for="cnpj" class="labelInput">CNPJ</label>
            </div>
            <br><br>
            <div class="inputBox">
                <input type="text" name="cidade" id="cidade" class="inputUser" required>
                <label for="cidade" class="labelInput">Cidade</label>
            </div>
            <br><br>
            <div class="inputBox">
                <input type="text" name="estado" id="estado" class="inputUser" required>
                <label for="estado" class="labelInput">Estado</label>
            </div>
            <br><br>
            <div class="inputBox">
                <input type="text" name="endereco" id="endereco" class="inputUser" required>
                <label for="endereco" class="labelInput">Endereço</label>
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


    <!-- jquery pra aplicar a máscara no cnpj e telefone -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script>
        $('#cnpj').mask('00.000.000/0000-00');
        $('#telefone').mask('(00) 00000-0000');
    </script>

</body>

</html>