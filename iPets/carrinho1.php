<?php
session_start();
include('config.php');

if (!isset($_SESSION['user_data']['id'])) {
    header("Location: loginusuario.php");
    exit();
}

$user_data = $_SESSION['user_data'];
$user_id = $user_data['id'];

$shipping_fee = 11.90;

$grand_total = 0;
$total = 0;

$sql = "SELECT p.product_price, c.quantity FROM cart c
        JOIN products p ON c.product_id = p.product_id
        WHERE c.user_id = $user_id";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $total += $row['product_price'] * $row['quantity'];
    }
} else {
    $total = 0;
}

$grand_total = $total + $shipping_fee;

$update_total_sql = "UPDATE cart SET total = ? WHERE user_id = ?";
$update_stmt = $connection->prepare($update_total_sql);
$update_stmt->bind_param('di', $grand_total, $user_id);
$update_stmt->execute();

if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = (int) $_POST['product_id'];
    $quantity = (int) $_POST['quantity'];

    if ($quantity == 0) {
        $sql_remove = "DELETE FROM cart WHERE product_id = ? AND user_id = ?";
        $stmt_remove = $connection->prepare($sql_remove);
        $stmt_remove->bind_param('ii', $product_id, $user_id);
        
        if ($stmt_remove->execute()) {
            $stmt_remove->close();
        } else {
            echo json_encode(['error' => 'Erro ao remover o produto']);
            exit;
        }
    } else {
        $sql_update = "UPDATE cart SET quantity = ? WHERE product_id = ? AND user_id = ?";
        $stmt_update = $connection->prepare($sql_update);
        $stmt_update->bind_param('iii', $quantity, $product_id, $user_id);
        
        if (!$stmt_update->execute()) {
            echo json_encode(['error' => 'Erro ao atualizar a quantidade']);
            exit;
        }
        $stmt_update->close();
    }

    $total = 0;
    $sql = "SELECT p.product_price, c.quantity FROM cart c
            JOIN products p ON c.product_id = p.product_id
            WHERE c.user_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $total += $row['product_price'] * $row['quantity'];
    }

    $grand_total = $total + $shipping_fee;

    $update_total_sql = "UPDATE cart SET total = ? WHERE user_id = ?";
    $update_stmt = $connection->prepare($update_total_sql);
    $update_stmt->bind_param('di', $grand_total, $user_id);
    $update_stmt->execute();

    echo json_encode(['total' => number_format($grand_total, 2, ',', '.')]);

    $stmt->close();
    $update_stmt->close();
}
   

$sql = "SELECT p.product_name, p.product_price, c.quantity, p.product_id FROM cart c
        JOIN products p ON c.product_id = p.product_id
        WHERE c.user_id = $user_id ORDER BY p.product_name ASC";
$result = $connection->query($sql);

if (!$result) {
    die("Erro na consulta: " . $connection->error);
}

if ($result->num_rows > 0) {
    $cart_products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $cart_products[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/stylesCarrinho1.css">
    <link rel="stylesheet" href="./CSS/stylesPadrão.css">
    <link rel="icon" href="./IMG/favicon.png" type="image/png">
    <script src="./JS/scriptCarrinho1.js"></script>

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
                <p>Olá, <?php echo htmlspecialchars($_SESSION['user_data']['nome']); ?>!</p>
            </a>
        <?php else: ?>
            <a href="cadselect.php" class="navbar-perfil">
                <div class="navbar-perfil-img">
                    <img src="./IMG/perfil-icon.png">
                </div>
                <p>Entre ou cadastre-se</p>
            </a>
        <?php endif; ?>
        <a class="navbar-veterinario" href="./veterinario.php">
            <img src="./IMG/vet-icon.png">
        </a>
        <a class="navbar-localiza">
            <img src="./IMG/localizacao-icon.png">
        </a>
        <a class="navbar-carrinho" href="./carrinho1.php">
            <div>
                <img src="./IMG/carrinho-icon.png">
            </div>
            <p>R$ <?php echo number_format($grand_total, 2, ',', '.'); ?></p>
        </a>
    </nav>

    <main>

        <h2>Seu carrinho</h2>

        <div class="prods-compra">

            <?php if (!empty($cart_products)): ?>
                <?php foreach ($cart_products as $product): ?>
                    <div class="prod" data-product-id="<?php echo $product['product_id']; ?>">
                        <img src="./IMG/anuncio2Categoria.png">

                        <div class="prod-info">
                            <p><?php echo htmlspecialchars($product['product_name']); ?></p>
                            <p>R$ <?php echo number_format($product['product_price'], 2, ',', '.'); ?></p>
                        </div>

                        <div class="prod-quant">
                            <button class="menos" data-action="decrease">&#45;</button>
                            <p class="quant" id="quant-<?php echo $product['product_id']; ?>">
                                <?php echo $product['quantity']; ?>
                            </p>
                            <button class="mais" data-action="increase">&#43;</button>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Seu carrinho está vazio. Adicione produtos ao carrinho.</p>
            <?php endif; ?>

            <div class="a-container">
                <a href="./lojas.php">Continuar comprando</a>
            </div>
        </div>

        <h3>Peça também</h3>

        <div class="prods-compra-adic">
            <?php
            $sql = "SELECT * FROM products ORDER BY RAND() LIMIT 2";
            $result = $connection->query($sql);

            if ($result->num_rows > 0) {
                while ($products_data = $result->fetch_assoc()) {
                    echo "
                <a style='text-decoration: none; color: #000' href='./paginaLoja.php?store_id=" . number_format($products_data['store_id']) . "'>
                    <div class='prod-adic'>
                        <img src='./IMG/anuncio4Categoria.png'>
                        <p>" . number_format($products_data['product_price'], 2, ',', '.') . "</p>
                        <p>" . htmlspecialchars($products_data['product_name']) . "</p>
                    </div>
                </a>
                ";
                }
            }
            ?>
        </div>

        <br>

        <div class="val">

            <div class="vals-container">
                <h3>Resumo dos valores</h3>

                <div class="vals-item">
                    <div>
                        <p>Subtotal</p>
                    </div>
                    <div>
                        <p>R$ <?php echo number_format($total, 2, ',', '.'); ?></p>
                    </div>
                </div>

                <div class="vals-item">
                    <div>
                        <p>Taxa de entrega</p>
                    </div>
                    <div>
                        <p>R$ 11,90</p>
                    </div>
                </div>

                <div class="vals-item">
                    <div>
                        <p>Total</p>
                    </div>
                    <div>
                        <p>R$ <?php echo number_format($grand_total, 2, ',', '.'); ?></p>
                    </div>
                </div>
            </div>

        </div>

        <br>

        <div class="button">
            <a class="next-button" href="./carrinho2.php">Continuar</a>
        </div>

        <br>
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
                <a href="#"><img src="./IMG/instagram-icon.png"></a>
                <a href="#"><img src="./IMG/twitter-icon.png"></a>
                <p>@iPetsCompany</p>
            </div>
        </div>
    </footer>

</body>

</html>