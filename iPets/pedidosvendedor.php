<?php

session_start();

include 'config.php';

if (!isset($_SESSION['store_data'])) {
    header("Location: loginvendedor.php");
    exit();
}

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/stylesPadrãoVendedor.css">
    <link rel="stylesheet" href="./CSS/stylesVendedorPerfil.css">
    <script src="./JS/scriptVendedorPerfil.js"></script>
    <link rel="icon" href="./IMG/favicon.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <title>Perfil</title>
</head>

<body>

    <nav class="navbar" style="position: fixed;">
        <a class="nav-item" href="perfilvendedor.php">
            <img src="./IMG/icon-vendedor-home.png" class="nav-item-img">
            <p class="nav-item-tit">Início</p>
        </a>

        <a class="nav-item" href="#">
            <img src="./IMG/icon-vendedor-historico.png" class="nav-item-img">
            <p class="nav-item-tit">Histórico</p>
        </a>

        <a class="nav-item" href="#">
            <img src="./IMG/icon-vendedor-pedidos.png" class="nav-item-img">
            <p class="nav-item-tit">Pedidos</p>
        </a>

        <a class="nav-item" href="#">
            <img src="./IMG/icon-vendedor-agenda.png" class="nav-item-img">
            <p class="nav-item-tit">Agenda</p>
        </a>

        <a class="nav-item" href="#">
            <img src="./IMG/icon-vendedor-config.png" class="nav-item-img">
            <p class="nav-item-tit">Configurações</p>
        </a>

        <br><br>

        <a style="color: red; padding: 20px;" href="logoutvendedor.php">SAIR</a>
    </nav>

    <header class="header">
        <p>Olá, <?php echo htmlspecialchars($store_data['nome']); ?></p>
        <img src="./IMG/verificadoIcon.png">
    </header>
    <hr>

    <main>
        <section class="infos-loja-main-container">

            <div class="infos-loja-container">

                <div class="info-loja">
                    <h3>Segmento</h3>
                    <div class="info">
                        <p>Cães • Gatos</p>
                    </div>
                    <div class="info">
                        <p>Produtos • Serviços</p>
                    </div>
                </div>

                <div class="info-loja">
                    <h3>Horário</h3>
                    <div class="info">
                        <p class="hour">Das <?php echo htmlspecialchars($store_data['open']); ?> </p>
                        <p class="hour">às <?php echo htmlspecialchars($store_data['close']); ?> </p>
                    </div>

                </div>

                
                <div style="margin-left: 300px;" class="loja-foto">
                    <img src="./IMG/pet-shop-store-icon.png">
                </div>
            </div>
        </section>

        <hr>
