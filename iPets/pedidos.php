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

if (isset($_SESSION['user_data'])) {
    $user_id = $_SESSION['user_data']['id'];

    $sql = "SELECT * FROM cart WHERE user_id = $user_id";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./IMG/favicon.png" type="image/png">
    <link rel="stylesheet" href="./CSS/stylesPedidos.css">
    <link rel="stylesheet" href="./CSS/stylesPadrão.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <title>Meus pedidos</title>
</head>

<body>

    <nav class="navbar">

        <a href="./index.php">
            <img src="./IMG/ipets-logo.png" class="navbar-logo">
        </a>

        <div class="navbar-pesq">
            <div class="navbar-pesq-input-container">
                <input type="text" placeholder="Loja ou item para seu pet, busque aqui" class="navbar-pesq-input">
                <img src="./IMG/pesquisa-icon.png">
            </div>
        </div>
        <?php if (isset($_SESSION['user_data'])): ?>
            <a href="./perfilusuario.php" class="navbar-perfil">
                <div class="navbar-perfil-img">
                    <img src="./IMG/perfil-icon.png">
                </div>
                <p>Olá, <?php echo htmlspecialchars($_SESSION['user_data']['nome']); ?>!</p>
            </a>
            <a class="navbar-carrinho" href="./carrinho1.php">
                <div>
                    <img src="./IMG/carrinho-icon.png">
                </div>
                <p>R$ <?php echo number_format($grand_total, 2, ',', '.'); ?></p>
            </a>
        <?php else: ?>
            <a href="cadselect.php" class="navbar-perfil">
                <div class="navbar-perfil-img">
                    <img src="./IMG/perfil-icon.png">
                </div>
                <p>Entre ou cadastre-se</p>
            </a>
            <a class="navbar-carrinho" href="./carrinho1.php">
                <div>
                    <img src="./IMG/carrinho-icon.png">
                </div>
                <p>R$ 0,00</p>
            </a>
        <?php endif; ?>
        <a class="navbar-veterinario" href="./veterinario.php">
            <img src="./IMG/vet-icon.png">
        </a>
        <a class="navbar-localiza">
            <img src="./IMG/localizacao-icon.png">
        </a>

    </nav>

    <main>

        <h1>Meus Pedidos</h1>
        <hr>

        <div class="emAnd">

            <h2>Em aguardo</h2>

            <div class="emAnd-prod-group">

                <div class="emAnd-prod">
                    <div class="prod-loja">
                        <ul>
                            <li><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRsSnU96G0Du76updyWR-tJhm_f8B80YsboNw&s"
                                    alt="logo da loja"></li>
                            <li>
                                <p>Petz Produtos e Serviços</p>
                            </li>
                            <li class="store-link"><a href="">></a></li>
                        </ul>
                    </div>
                    <hr>
                    <div class="prod-stts-simple">
                        <ul>
                            <li class="status">
                                <h5>Pedido em andamento</h5>
                            </li>
                            <li>
                                <h5 class="items-number">2</h5>
                                <h5>Ração Premium cães adultos 1,5kg</h5>
                            </li>
                            <li>
                                <h5 class="items-number">1</h5>
                                <h5>Bolinha de plástico para cães</h5>
                            </li>
                        </ul>
                    </div>
                    <hr>
                    <div class="emAnd-prod-stts-container">
                        <a class="emAnd-prod-stts" href="">Acompanhar status</a>
                    </div>
                </div>

                

                
            </div>
        </div>

        <br>
        <br>

        <div class="hist">
            <h2>Histórico</h2>

            <div class="hist-prod-group">

                <div class="hist-prod">
                    <div class="prod-loja">
                        <ul>
                            <li><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRsSnU96G0Du76updyWR-tJhm_f8B80YsboNw&s"
                                    alt="logo da loja"></li>
                            <li>
                                <p>Petz Produtos e Serviços</p>
                            </li>
                            <li class="store-link"><a href="">></a></li>
                        </ul>
                    </div>
                    <hr>
                    <div class="prod-stts-simple">
                        <ul>
                            <li class="status">
                                <h5>Pedido concluído</h5>
                            </li>
                            <li>
                                <h5 class="items-number">2</h5>
                                <h5>Ração Premium cães adultos 1,5kg</h5>
                            </li>
                            <li>
                                <h5 class="items-number">1</h5>
                                <h5>Tapete higiênico DogCare 30 unidades</h5>
                            </li>
                            <li>
                                <h5 class="items-number">1</h5>
                                <h5>Bolinha de plástico para cães</h5>
                            </li>
                        </ul>
                    </div>
                    <hr>
                    <div class="aval-container">
                        <h5 class="aval-label">Avaliação</h5>
                        <div class="estr-container">
                            <h5 class="estr">★</h5>
                            <h5 class="estr">★</h5>
                            <h5 class="estr">★</h5>
                            <h5 class="estr">★</h5>
                            <h5 class="estr">★</h5>
                        </div>
                    </div>
                    <hr>
                    <div class="hist-prod-stts-container">
                        <a class="hist-prod-stts" href="">Ajuda</a>
                        <a class="hist-prod-stts" href="">Pedir novamente</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="footer-element">
            <h5>iPets</h5>
            <p>Quem somos</p>
            <p>Perguntas frequentes</p>
            <p>Fale conosco</p>
            <p>Entregadores</p>
        </div>
        <div class="footer-element">
            <h5>Descubra</h5>
            <p>Seja um parceiro</p>
            <p>Alimentador Automático</p>
            <p>Clube de recompensas</p>
        </div>
        <div class="footer-element">
            <h5>Contatos</h5>
            <p>ipetscompany@gmail.com</p>
            <div class="footer-element-contatos">
                <a href=""><img src="./IMG/instagram-icon.png"></a>
                <a href=""><img src="./IMG/twitter-icon.png"></a>
                <p>@iPetsCompany</p>
            </div>
        </div>
    </footer>
</body>

</html>