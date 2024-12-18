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

$sql = "SELECT p.product_name, p.product_price, c.quantity 
        FROM cart c 
        JOIN products p ON c.product_id = p.product_id 
        WHERE c.user_id = $user_id";
$result = $connection->query($sql);

$cart_products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cart_products[] = $row;
    }
}

$shipping_fee = 11.90;
$total = array_reduce($cart_products, function ($sum, $product) {
    return $sum + $product['product_price'] * $product['quantity'];
}, 0);

$grand_total = $total + $shipping_fee;
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/stylesCarrinho2.css">
    <link rel="stylesheet" href="./CSS/stylesPadrão.css">
    <link rel="icon" href="./IMG/favicon.png" type="image/png">
    <script src="./JS/scriptCarrinho2.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <title>Carrinho</title>
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
                <p>Olá, <?php echo htmlspecialchars(explode(' ', $_SESSION['user_data']['nome'])[0]); ?>!</p>
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
        <h2 style="font-weight: 600;">Carrinho</h2>

        <p class="tit">Entregar no endereço</p>
        <div class="ende">
            <img src="./IMG/icon-localizacaoCarrinho.png" alt="">
            <div class="info-ende">
                <h4>Rua da Alegria, 202</h4>
                <p>Jardim do Hospício</p>
            </div>
            <div class="ende-a">
                <a href="">Trocar</a>
            </div>
        </div>

        <br>

        <p class="tit">Pagamento</p>
        <div class="tabs-container">
            <div class="tab" onclick="showTab('app');  updatePaymentMethod('Cartão de crédito')">
                <span id="tab-app" class="tab-title active">Pagar no App</span>
            </div>
            <div class="tab" onclick="showTab('entrega')">
                <span id="tab-entrega" class="tab-title">Pagar na Entrega</span>
            </div>
        </div>

        <form id="pag-form">
            <div id="app-content" class="content-container">

                <div class="pag-method-title">
                    <img src="./IMG/icon-cartao.png" id="img-pag-method-tit" alt="Ícone Cartão">
                    <span>Cartão de crédito</span>
                </div>

                <hr>
                <input type="text" id="card-number" required placeholder="Número do cartão*" maxlength="19"
                    inputmode="numeric" pattern="\d*" class="input-pag">

                <input type="text" id="card-name" required placeholder="Nome impresso no cartão*" class="input-pag">

                <div class="half-width-container">
                    <div class="half-width">
                        <input type="text" id="expiry-date" required placeholder="MM/AA*" maxlength="5"
                            inputmode="numeric" pattern="\d{2}/\d{2}" class="input-pag">
                        <p>Data de validade</p>
                    </div>

                    <div class="half-width">
                        <input type="text" id="cvv" required placeholder="CVV*" maxlength="3" pattern="\d*"
                            class="input-pag">
                    </div>
                </div>
            </div>
        </form>

        <div id="entrega-content" class="content-container" style="display: none;">
            <div class="pag">
                <div class="pag-element" id="pix" data-payment="pix" onclick="updatePaymentMethod('Pix')">
                    <img src="./IMG/icone-pix.png" alt="Logo do Pix">
                    <p>Pix</p>
                </div>
                <div class="pag-element" id="cred" data-payment="cred"
                    onclick="updatePaymentMethod('Cartão de Crédito')">
                    <img src="./IMG/icon-cartao.png" alt="Ícone representando um cartão">
                    <p>Cartão de Crédito</p>
                </div>
                <div class="pag-element" id="deb" data-payment="deb" onclick="updatePaymentMethod('Cartão de Débito')">
                    <img src="./IMG/icon-cartao.png" alt="Ícone representando um cartão">
                    <p>Cartão de Débito</p>
                </div>
                <div class="pag-element" id="din" data-payment="din" onclick="updatePaymentMethod('Dinheiro')">
                    <img src="./IMG/icon-dinheiro.png" alt="Ícone representando uma nota de dinheiro">
                    <p>Dinheiro</p>
                </div>
            </div>
        </div>

        <br>

        <div class="button">
            <a class="next-button" href="#popup">Finalizar</a>
        </div>

        <br>
    </main>

    <div id="popup" class="overlay">
        <div class="popup-container">
            <div class="txt-popup">
                <h2>Revisar Pedido</h2>
                <h3>Itens</h3>
                <br>
                <div class="pop-itens">
                    <?php foreach ($cart_products as $product): ?>
                        <div class="pop-itens-prod">
                            <p><?php echo htmlspecialchars($product['product_name']); ?></p>
                            <p style="text-align: right;">R$
                                <?php echo number_format($product['product_price'] * $product['quantity'], 2, ',', '.'); ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <hr>
                <h3>Entrega</h3>
                <br>
                <div class="pop-ent">
                    <div class="pop-ent-item">
                        <p>Rápida</p>
                        <p>Hoje, 120 - 150 mins</p>
                    </div>
                    <div class="pop-ent-item" style="text-align: right;">
                        <p>Rua da Alegria, 202</p>
                        <p>Jardim do Hospício</p>
                    </div>
                </div>
                <hr>
                <h3>Pagamento</h3>
                <br>
                <div class="pop-pag">
                    <div class="pop-pag-item">
                        <p id="selected-payment-method">Cartão de crédito</p>
                    </div>
                    <div class="pop-pag-item" style="text-align: right;">
                        <p>R$ <?php echo number_format($grand_total, 2, ',', '.'); ?></p>
                    </div>
                </div>
            </div>
            <div class="buttons-popup">
                <a class="back-button-popup" onclick="history.back()">Voltar</a>
                <a class="next-button-popup" href="./aguardo.php">Confirmar</a>
            </div>
        </div>
    </div>


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

    <script>
        function updatePaymentMethod(method) {
            const paymentMethodElement = document.getElementById('selected-payment-method');
            if (paymentMethodElement) {
                paymentMethodElement.textContent = method;
            }
        }
    </script>

</body>

</html>