<?php

session_start();

include_once('config.php');


$grand_total = 0;

if (isset($_SESSION['user_data'])) {
    $user_id = $_SESSION['user_data']['id'];

    $sql = "SELECT total FROM cart WHERE user_id = $user_id LIMIT 1";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $grand_total = $row['total'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/styleselect.css">
    <link rel="icon" href="./IMG/favicon.png" type="image/png">
    <title>Seleção de Perfil | iPets</title>
</head>

<body>

    <body style="background-color:#00154B">
        <div>
            <h1>Bem-vindo!</h1>
            <p> Qual tipo de conta gostaria de entrar?</p>
            <br> <br>

            <div class="img">

                <a href="loginusuario.php">
                    <img src="img/cliente 1.png">
                </a>

                <a href="loginvendedor.php">
                    <img src="img/loja.png">
                </a>

            </div>
            <br><br>
            <a href="cadselect.php">Não possui uma conta? Clique aqui</a>
    </body>

</html>