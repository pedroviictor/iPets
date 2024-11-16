<?php
session_start();

include_once('config.php');

$grand_total = 0;

if (isset($_SESSION['user_data'])) {
    $user_id = $_SESSION['user_data']['id'];

    $sql = "SELECT total FROM cart WHERE user_id = ? LIMIT 1";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $grand_total = $row['total'];
    }
    $stmt->close();
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
        <h1>Meus Pedidos</h1>
        <hr>
        <div class="emAnd">
            <h2>Em aguardo</h2>
            <div class="emAnd-prod-group">
                <?php
                if (isset($_SESSION['user_data'])) {
                    $user_id = $_SESSION['user_data']['id'];

                    $sql = "SELECT id, DATE(date_time) AS date, TIME(date_time) AS time, services_name 
                            FROM agendamentos 
                            WHERE user_id = ? AND a_status = 1";

                    $stmt = $connection->prepare($sql);

                    if ($stmt === false) {
                        die('Erro na preparação da consulta: ' . $connection->error);
                    }

                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($agenda_data = $result->fetch_assoc()) {
                        $date = htmlspecialchars($agenda_data['date']);
                        $time = htmlspecialchars($agenda_data['time']);
                        $services_name = htmlspecialchars($agenda_data['services_name']);

                        echo '
                        <div class="emAnd-prod">
                            <div class="prod-loja">
                                <ul>
                                    <li><img src="./IMG/pet-shop-store-icon.png" alt="logo da loja"></li>
                                    <li><p>Petshop</p></li>
                                    <li class="store-link"><a href=""></a></li>
                                </ul>
                            </div>
                            <hr>
                            <div class="prod-stts-simple">
                                <ul>
                                    <li class="status"><h5>Pedido em andamento</h5></li>
                                    <li><h5>' . $services_name . '</h5></li>
                                    <li><h5>Agendado para <span class="date">' . $date . '</span></h5></li>
                                    <li><h5>às <span class="hour">' . $time . '</span></h5></li>
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

        <div class="hist">
            <h2>Histórico</h2>
            <div class="hist-prod-group">
                <?php
                if (isset($_SESSION['user_data'])) {
                    $user_id = $_SESSION['user_data']['id'];

                    $sql = "SELECT id, DATE(date_time) AS date, TIME(date_time) AS time, services_name 
                    FROM agendamentos 
                    WHERE user_id = ? AND a_status = 2";

                    $stmt = $connection->prepare($sql);

                    if ($stmt === false) {
                        die('Erro na preparação da consulta: ' . $connection->error);
                    }

                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($agenda_data = $result->fetch_assoc()) {
                        $date = htmlspecialchars($agenda_data['date']);
                        $time = htmlspecialchars($agenda_data['time']);
                        $services_name = htmlspecialchars($agenda_data['services_name']);

                        echo '
                <div class="hist-prod">
                    <div class="prod-loja">
                        <ul>
                            <li>
                                <img src="./IMG/pet-shop-store-icon.png"
                                    alt="logo da loja">
                            </li>
                            <li>
                                <p>Petshop</p>
                            </li>
                            <li class="store-link"><a href=""></a></li>
                        </ul>
                    </div>
                    <hr>
                    <div class="prod-stts-simple">
                        <ul>
                            <li class="status">
                                <h5>Pedido concluído</h5>
                            </li>
                            <li>
                                <h5>Serviço: ' . $services_name . '</h5>
                            </li>
                            <li>
                                <h5>Data: ' . $date . '</h5>
                            </li>
                            <li>
                                <h5>Hora: ' . $time . '</h5>
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
                </div>';
                    }

                    $stmt->close();
                }
                ?>


                <?php
                if (isset($_SESSION['user_data'])) {
                    $user_id = $_SESSION['user_data']['id'];

                    $sql = "SELECT 
                cart.id, 
                cart.store_id,
                cart.product_id, 
                cart.quantity, 
                cart.a_status, 
                products.product_name
            FROM cart
            JOIN products ON cart.product_id = products.product_id
            WHERE cart.user_id = ? AND cart.a_status = 2";

                    $stmt = $connection->prepare($sql);

                    if ($stmt === false) {
                        die('Erro na preparação da consulta: ' . $connection->error);
                    }

                    $stmt->bind_param("i", $user_id);
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
                                <img src="./IMG/pet-shop-store-icon.png"
                                    alt="logo da loja">
                            </li>
                            <li>
                                <p>Petshop</p>
                            </li>
                            <li class="store-link"><a href=""></a></li>
                        </ul>
                    </div>
                    <hr>
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
                </div>';
                    }

                    $stmt->close();
                }
                ?>
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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $('.hour').mask("00:00h");
        $('.date').mask("0000/00/00", { reverse: true });
    </script>
</body>

</html>