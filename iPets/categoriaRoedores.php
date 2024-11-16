<?php
session_start();
include_once('config.php');

$grand_total = 0;

if (isset($_SESSION['user_data'])) {
    $user_id = $_SESSION['user_data']['id'];

    $sql = "SELECT SUM(product_price * quantity) AS total FROM cart 
            JOIN products ON cart.product_id = products.product_id 
            WHERE cart.user_id = $user_id";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $grand_total = $row['total'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = intval($_POST['product_id']);
    $store_id = intval($_POST['store_id']);
    $user_id = $_SESSION['user_data']['id'];

    $check_cart = "SELECT * FROM cart WHERE user_id = $user_id AND store_id = $store_id AND product_id = $product_id";
    $result = $connection->query($check_cart);

    if ($result->num_rows > 0) {
        $update_cart = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = $user_id AND store_id = $store_id AND product_id = $product_id";
        $connection->query($update_cart);
    } else {
        $insert_cart = "INSERT INTO cart (user_id, store_id, product_id, quantity) VALUES ($user_id, $store_id, $product_id, 1)";
        $connection->query($insert_cart);
    }
}

$query = "SELECT * FROM products WHERE product_category = 5";
$result = $connection->query($query);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/stylesCategoria.css">
    <link rel="stylesheet" href="./CSS/stylesPadrão.css">
    <link rel="icon" href="./IMG/favicon.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <title>Roedores</title>
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

    <header class="header-container">
        <a href="./categoriaCaes.php">
            <h2>Cães</h2>
        </a>
        <a href="./categoriaGatos.php">
            <h2>Gatos</h2>
        </a>
        <a href="./categoriaAves.php">
            <h2>Aves</h2>
        </a>
        <a class="selected" href="./categoriaRoedores.php">
            <h2>Roedores</h2>
        </a>
        <a href="./categoriaPeixes.php">
            <h2>Peixes</h2>
        </a>
    </header>
    <hr>

    <main>
        <h1>Melhores Ofertas</h1>

        <div class="prods-container">
            <?php
            if ($result->num_rows > 0) {
                while ($produto = $result->fetch_assoc()) {
                    echo '
                <form action="" method="POST" class="prod">
                    <div class="prod-img-container">
                        <img src="./IMG/anuncio1Categoria.png">
                    </div>
                    <div class="prod-info">
                        <div class="prod-info-base">
                            <h3>' . htmlspecialchars($produto['product_name']) . '</h3>
                            <p>R$ ' . number_format($produto['product_price'], 2, ',', '.') . '</p>
                            <input type="hidden" name="product_id" value="' . $produto['product_id'] . '">
                            <input type="hidden" name="store_id" value="' . $produto['store_id'] . '">
                            <button type="submit" name="add_to_cart" class="add-to-cart" onclick="return confirm(\'Tem certeza que deseja comprar este produto?\');">Adicionar ao carrinho</button>
                        </div>
                        <hr>
                        <div class="prod-info-loja-info">
                            <div class="prod-info-img-container">
                                <img src="./IMG/pet-shop-store-icon.png" alt="Ícone da loja">
                            </div>
                            <div class="prod-info-loja-info-entrega">
                                <p>40-50 min</p>
                                <p>•</p>
                                <p>Grátis</p>
                            </div>
                        </div>
                    </div>
                </form>
                ';
                }
            } else {
                echo '<p>Não há produtos disponíveis nesta categoria.</p>';
            }
            ?>
        </div>
        <br>
        <hr>
        <br>
        <h2>Confira algumas lojas!</h2>

        <div class="lojas-content">
            <div class="lojas-container">

                <?php
                $sql = "SELECT * FROM store ORDER BY RAND() LIMIT 3";
                $result = $connection->query($sql);

                while ($store_data = mysqli_fetch_assoc($result)) {
                    echo "
                        <div class='lojas'>
                            <a style='text-decoration: none; color: #000;' class='lojas-a' href='./paginaLoja.php?store_id=" . $store_data['store_id'] . "'>
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
    </main>

    <div class="anuncios-fim">
        <div class="anuncio-fim">
            <img src="IMG/anuncio1CategoriaFim.png">
        </div>
        <div class="anuncio-fim">
            <img src="IMG/anuncio2CategoriaFim.png">
        </div>
        <div class="anuncio-fim">
            <img src="IMG/anuncio3CategoriaFim.png">
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
</body>

</html>