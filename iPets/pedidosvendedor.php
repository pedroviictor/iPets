<?php
session_start();
include 'config.php';

if (!isset($_SESSION['store_data'])) {
    header("Location: loginvendedor.php");
    exit();
}

if (isset($_POST['cart_id_accept'])) {
    $cart_id = $_POST['cart_id_accept'];

    $sql = "UPDATE cart SET a_status = 2 WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $cart_id);

    if ($stmt->execute()) {
        header("Location: pedidosvendedor.php");
        exit();
    } else {
        echo "Erro ao aceitar o pedido.";
    }

    $stmt->close();
}

if (isset($_POST['cart_id_reject'])) {
    $cart_id = $_POST['cart_id_reject'];

    $sql = "DELETE FROM cart WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $cart_id);

    if ($stmt->execute()) {
        header("Location: pedidosvendedor.php");
        exit();
    } else {
        echo "Erro ao recusar o pedido.";
    }

    $stmt->close();
}

$store_data = $_SESSION['store_data'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/stylesPadrãoVendedor.css">
    <link rel="stylesheet" href="./CSS/stylesVendedorPerfil.css">
    <link rel="stylesheet" href="./CSS/stylesPedidos.css">
    <script src="./JS/scriptVendedorPerfil.js"></script>
    <link rel="icon" href="./IMG/favicon.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <title>Seus pedidos</title>
</head>

<body>

    <nav class="navbar" style="position: fixed;">
        <a class="nav-item" href="perfilvendedor.php">
            <img src="./IMG/icon-vendedor-home.png" class="nav-item-img">
            <p class="nav-item-tit">Início</p>
        </a>

        <a class="nav-item" href="historicovendedor.php">
            <img src="./IMG/icon-vendedor-historico.png" class="nav-item-img">
            <p class="nav-item-tit">Histórico</p>
        </a>

        <a class="nav-item" href="pedidosvendedor.php">
            <img src="./IMG/icon-vendedor-pedidos.png" class="nav-item-img">
            <p class="nav-item-tit">Pedidos</p>
        </a>

        <a class="nav-item" href="calendarioVendedor.php">
            <img src="./IMG/icon-vendedor-agenda.png" class="nav-item-img">
            <p class="nav-item-tit">Agenda</p>
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
        <br>
        <div class="hist">
            <h2>Pedidos</h2>
            <div class="hist-prod-group">
                <?php
                if (isset($_SESSION['store_data'])) {
                    $store_id = $_SESSION['store_data']['id'];

                    $sql = "SELECT 
                        cart.id, 
                        cart.store_id,
                        cart.product_id, 
                        cart.quantity, 
                        cart.a_status, 
                        products.product_name
                    FROM cart
                    JOIN products ON cart.product_id = products.product_id
                    WHERE cart.store_id = ? AND cart.a_status = 1";

                    $stmt = $connection->prepare($sql);
                    $stmt->bind_param("i", $store_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($product_data = $result->fetch_assoc()) {
                        $product_name = htmlspecialchars($product_data['product_name']);
                        $quantity = (int) $product_data['quantity'];
                        $cart_id = $product_data['id'];

                        echo '
                        <div class="hist-prod">
                            <div class="prod-loja">
                                <ul>
                                    <li>
                                        <img src="./IMG/pet-shop-store-icon.png" alt="logo da loja">
                                    </li>
                                    <li>
                                        <p>Petshop</p>
                                    </li>
                                    <li class="store-link"><a href=""></a></li>
                                </ul>
                            </div>
                            <div class="prod-stts-simple">
                                <ul>
                                    <li class="status">
                                        <h5>Pedido concluído</h5>
                                    </li>
                                    <li>
                                        <h5>Produto: ' . $product_name . '</h5>
                                    </li>
                                    <li>
                                        <h5>Quantidade: ' . $quantity . '</h5>
                                    </li>
                                    <li>
                                        <form class="form-acdl" action="pedidosvendedor.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="cart_id_accept" value="' . $cart_id . '">
                                            <button style="background-color: green;" type="submit" class="accept-btn">Aceitar</button>
                                        </form>
                                        <form class="form-acdl" action="pedidosvendedor.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="cart_id_reject" value="' . $cart_id . '">
                                            <button style="background-color: red;" type="submit" class="reject-btn">Recusar</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>';
                    }

                    $stmt->close();
                }
                ?>
            </div>
        </div>

        <br>
        <hr>
        <br>

        <div class="hist">
            <h2>Confirmados</h2>
            <div class="hist-prod-group">
                <?php
                if (isset($_SESSION['store_data'])) {
                    $store_id = $_SESSION['store_data']['id'];

                    $sql = "SELECT 
                        cart.id, 
                        cart.store_id,
                        cart.product_id, 
                        cart.quantity, 
                        cart.a_status, 
                        products.product_name
                    FROM cart
                    JOIN products ON cart.product_id = products.product_id
                    WHERE cart.store_id = ? AND cart.a_status = 2";

                    $stmt = $connection->prepare($sql);
                    $stmt->bind_param("i", $store_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($product_data = $result->fetch_assoc()) {
                        $product_name = htmlspecialchars($product_data['product_name']);
                        $quantity = (int) $product_data['quantity'];

                        echo '
                        <div class="hist-prod">
                            <div class="prod-loja">
                                <ul>
                                    <li>
                                        <img src="./IMG/pet-shop-store-icon.png" alt="logo da loja">
                                    </li>
                                    <li>
                                        <p>Petshop</p>
                                    </li>
                                    <li class="store-link"><a href=""></a></li>
                                </ul>
                            </div>
                            <div class="prod-stts-simple">
                                <ul>
                                    <li class="status">
                                        <h5>Pedido concluído</h5>
                                    </li>
                                    <li>
                                        <h5>Produto: ' . $product_name . '</h5>
                                    </li>
                                    <li>
                                        <h5>Quantidade: ' . $quantity . '</h5>
                                    </li>
                                </ul>
                            </div>
                        </div>';
                    }

                    $stmt->close();
                }
                ?>
            </div>
        </div>

    </main>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $('.hour').mask("00:00h");
    </script>
</body>
</html>
