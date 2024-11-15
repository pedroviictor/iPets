<?php

session_start();

include_once("config.php");

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/stylesLojas.css">
    <link rel="stylesheet" href="./CSS/stylesPadrão.css">
    <link rel="icon" href="./IMG/favicon.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <title>Lojas</title>
</head>

<body>

    <header>
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
            <a href="./cadselect.php" class="navbar-perfil">
                <div class="navbar-perfil-img">
                    <img src="./IMG/perfil-icon.png">
                </div>
                <p>Entre ou cadastre-se</p>
            </a>
            <a class="navbar-veterinario" href="./veterinario.html">
                <img src="./IMG/vet-icon.png">
            </a>
            <a class="navbar-localiza">
                <img src="./IMG/localizacao-icon.png">
            </a>
            <a class="navbar-carrinho" href="./carrinho1.html">
                <div>
                    <img src="./IMG/carrinho-icon.png">
                </div>
                <p>R$ 0,00</p>
            </a>
        </nav>

        <div class="anuncios-topo">
            <div class="anuncios-topo-element">
                <img src="./IMG/anuncio1Lojas.png">
            </div>
            <div class="anuncios-topo-element">
                <img src="./IMG/anuncio2Lojas.png">
            </div>
            <div class="anuncios-topo-element">
                <img src="./IMG/anuncio3Lojas.png">
            </div>
            <div class="anuncios-topo-element">
                <img src="./IMG/anuncio4Lojas.png">
            </div>
            <div class="anuncios-topo-element">
                <img src="./IMG/anuncio5Lojas.png">
            </div>
        </div>
    </header>

    <main>

        <hr style="border: 0.5px solid #00154b;">

        <div class="lojas-content">
            <div class="lojas-container">

                <?php
                $sql = "SELECT * FROM store ORDER BY RAND() LIMIT 9";
                $result = $connection->query($sql);

                while ($store_data = mysqli_fetch_assoc($result)) {
                    echo "
                        <div class='lojas'>
                            <a class='lojas-a' href='./paginaLoja.php?store_id=" . $store_data['store_id'] . "'>
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

        <div class="anuncios-meio">
                <div class="anuncio-meio">
                <img src="./IMG/anuncio1LojasMeio.png">
            </div>
            <div class="anuncio-meio">
                <img src="./IMG/anuncio2LojasMeio.png">
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