<?php

session_start();

include_once("config.php");

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
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/stylesHome.css">
    <link rel="stylesheet" href="./CSS/stylesPadrão.css">
    <link rel="icon" href="./IMG/favicon.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <script src="./JS/scriptHome.js" defer></script>
    <title>iPets</title>
</head>

<body>
    <header class="nav" style="background-image: url(./IMG/nav-back.png);">

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
        <div class="nav-content">
            <h2>Tudo o que o seu pet precisa, na palma da sua mão</h2>
            <p>A maior rede de delivery para itens pets trazendo as melhores opções da sua região.</p>
        </div>
    </header>

    <main>
        <h1>Categorias</h1>
        <br>
        <br>

        <div class="categoria-buttons">
            <div class="categoria-button">
                <a href="./categoriaCaes.php">
                    <div class="categoria-button-img-back"></div>
                    <img src="./IMG/caes-button-img.png">
                    <h3>Cães</h3>
                </a>
            </div>
            <div class="categoria-button">
                <a href="./categoriaGatos.php">
                    <div class="categoria-button-img-back"></div>
                    <img src="./IMG/gatos-button-img.png">
                    <h3>Gatos</h3>
                </a>
            </div>
            <div class="categoria-button">
                <a href="./categoriaAves.php">
                    <div class="categoria-button-img-back"></div>
                    <img src="./IMG/aves-button-img.png">
                    <h3>Aves</h3>
                </a>
            </div>
            <div class="categoria-button">
                <a href="./categoriaPeixes.php">
                    <div class="categoria-button-img-back"></div>
                    <img src="./IMG/peixes-button-img.png">
                    <h3>Peixes</h3>
                </a>
            </div>
            <div class="categoria-button">
                <a href="./categoriaRoedores.php">
                    <div class="categoria-button-img-back"></div>
                    <img src="./IMG/roedores-button-img.png">
                    <h3>Roedores</h3>
                </a>
            </div>
        </div>

        <br>

        <div class="cards-home">

            <div class="card-home">
                <img src="./IMG/card-home-1.png">
            </div>

            <div class="card-home">
                <a href="./alimentador.php">
                    <img src="./IMG/card-home-2.png">
                </a>
            </div>
        </div>

        <div class="lojas-home-container">
            <div class="lojas-home-tit">
                <h1>Você pode gostar</h1>
                <a href="./lojas.php">Ver mais</a>
            </div>

            <div class="lojas-container">

                <!-- só 3 lojas aleatórias são exibidas -->

                <?php
                $sql = "SELECT * FROM store ORDER BY RAND() LIMIT 3";
                $result = $connection->query($sql);

                while ($store_data = mysqli_fetch_assoc($result)) {
                    echo "
                        <div class='lojas'>
                            <a href='./paginaLoja.php?store_id=" . $store_data['store_id'] . "'>
                                <div class='lojas-info-total'>
                                    <input type='hidden' name='product_id' value='" . $store_data['store_id'] . "'>
                                    <img src='./IMG/pet-shop-store-icon.png'>
                                    <div class='lojas-info'>
                                        <h4>" . $store_data['store_name'] . "</h4>
                                        <p>Cães e Gatos - 1,2 km</p>
                                        <p>Aberto até 19:00 - Serviços até 18:00</p>
                                    </div>
                                </div>
                            </a>
                        </div>";
                }
                ?>
            </div>
        </div>

        <div class="carrossel">
            <button class="carrossel-button" id="ante">&#60;</button>
            <div class="carrossel-elementos-container">
                <div class="carrossel-elemento">
                    <img src="./IMG/cupom-3.png">
                </div>
                <div class="carrossel-elemento on">
                    <img src="./IMG/cupom-1.png">
                </div>
                <div class="carrossel-elemento">
                    <img src="./IMG/cupom-2.png">
                </div>
            </div>
            <button class="carrossel-button" id="prox">&#62;</button>
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