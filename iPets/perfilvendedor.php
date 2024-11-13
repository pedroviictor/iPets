<?php

session_start();

include 'config.php';

if (!isset($_SESSION['store_data'])) {
    header("Location: loginvendedor.php");
    exit();
}

$sql = "SELECT * FROM products ORDER BY product_name ASC";
$result = $connection->query($sql);

$store_data = $_SESSION['store_data'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $store_id = $_SESSION['store_data']['id'];

    if (isset($_POST['delete_type'])) {

        $delete_type = $_POST['delete_type'];
        $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;
        $service_id = isset($_POST['service_id']) ? $_POST['service_id'] : null;

        if ($delete_type == 'products' && $product_id !== null) {

            $delete_sql = $connection->prepare("DELETE FROM products WHERE product_id = ? AND store_id = ?");
            $delete_sql->bind_param("ii", $product_id, $store_id);
            $delete_sql->execute();

            header("Location: perfilvendedor.php?success=delete_product");
            exit();

        } elseif ($delete_type == 'services' && $service_id !== null) {

            $delete_sql = $connection->prepare("DELETE FROM services WHERE services_id = ? AND store_id = ?");
            $delete_sql->bind_param("ii", $service_id, $store_id);
            $delete_sql->execute();

            header("Location: perfilvendedor.php?success=delete_service");
            exit();
        }
    }

    if (isset($_POST['form_type'])) {

        $form_type = $_POST['form_type'];

        if ($form_type == 'service') {

            $services_name = isset($_POST['services_name']) ? $_POST['services_name'] : '';
            $services_description = isset($_POST['services_description']) ? $_POST['services_description'] : '';
            $services_price = isset($_POST['services_price']) ? $_POST['services_price'] : '';

            if (!empty($services_name) && !empty($services_description) && !empty($services_price)) {

                $cmd = $connection->prepare("INSERT INTO services (store_id, services_name, services_description, services_price) VALUES (?, ?, ?, ?)");

                $cmd->bind_param("isss", $store_id, $services_name, $services_description, $services_price);

                if ($cmd->execute()) {

                    header("Location: perfilvendedor.php?success=service");
                    exit();

                } else {

                    echo "<script>alert('Erro ao adicionar o serviço.');</script>";
                }

            } else {

                echo "<script>alert('Preencha todos os campos do serviço.');</script>";

            }
        }

        if ($form_type == 'product') {

            $product_name = isset($_POST['product_name']) ? $_POST['product_name'] : '';
            $product_description = isset($_POST['product_description']) ? $_POST['product_description'] : '';
            $product_price = isset($_POST['product_price']) ? $_POST['product_price'] : '';
            $stock_quantity = isset($_POST['stock_quantity']) ? $_POST['stock_quantity'] : '';

            if (!empty($product_name) && !empty($product_description) && !empty($product_price) && !empty($stock_quantity)) {

                $cmd = $connection->prepare("INSERT INTO products (store_id, product_name, product_description, product_price, stock_quantity) VALUES (?, ?, ?, ?, ?)");

                $cmd->bind_param("isssi", $store_id, $product_name, $product_description, $product_price, $stock_quantity);

                if ($cmd->execute()) {

                    header("Location: perfilvendedor.php?success=product");

                    exit();

                } else {

                    echo "<script>alert('Erro ao adicionar o produto.');</script>";

                }

            } else {

                echo "<script>alert('Preencha todos os campos do produto.');</script>";

            }
        }
    }
}

if (isset($_GET['success'])) {

    if ($_GET['success'] == 'service') {

        echo "<script>alert('Serviço adicionado com sucesso.');</script>";

    } elseif ($_GET['success'] == 'product') {

        echo "<script>alert('Produto adicionado com sucesso.');</script>";

    } elseif ($_GET['success'] == 'delete_product') {

        echo "<script>alert('Produto deletado com sucesso.');</script>";

    } elseif ($_GET['success'] == 'delete_service') {

        echo "<script>alert('Serviço deletado com sucesso.');</script>";

    }
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <title>Perfil</title>
</head>

<body>

    <nav class="navbar" style="position: fixed;">
        <a class="nav-item" href="#">
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
                <button style="border: none; background-color: transparent; color: #D86000; cursor: pointer;">Editar
                    informações</button>
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
                        <p>Pedidos • 08:00 - 19:00</p>
                    </div>

                    <div class="info">
                        <p>Serviços • 09:00 - 18:00</p>
                    </div>
                </div>

                <div class="loja-foto">
                    <img src="./IMG/pet-shop-store-icon.png">
                </div>
            </div>
        </section>

        <hr>

        <div class="tabs-container">
            <div class="tab active" onclick="showContent('produtos')" id="produtos-span">
                <span class="tab-title">Produtos</span>
            </div>
            <div class="tab" onclick="showContent('servicos')" id="servicos-span">
                <span class="tab-title">Serviços</span>
            </div>
        </div>

        <div class="main-content">
            <div class="content-container" id="produtos-content">
                <div class="produtos-container">
                    <div class="produtos-divisao">
                        <br><br>
                        <button
                            style="border: none; background-color: transparent; color: #D86000; cursor: pointer;">Adicionar
                            produtos</button>
                        <div class="popup">
                            <form method="POST" class="popup-container">
                                <button type="button" class="popup-btn popup-btn--close">X</button>
                                <input type="hidden" name="form_type" value="product">
                                <input type="text" name="product_name" placeholder="* Nome do produto." required />
                                <input type="text" name="product_description" placeholder="* Descrição do produto."
                                    required />
                                <input id="preco" type="text" name="product_price" step="0.01" min="0" max="999999.99"
                                    placeholder="* Preço do produto" required />
                                <input type="text" name="stock_quantity" placeholder="* Quantidade de produtos."
                                    required />
                                <button type="submit" class="popup-btn">Adicionar</button>
                            </form>
                        </div>

                        <div class="divisao-head">
                            <h4 class="divisao-titulo">Produtos</h4>
                        </div>

                        <?php

                        $sql = "SELECT * FROM products ORDER BY product_name ASC";
                        $result = $connection->query($sql);

                        while ($products_data = mysqli_fetch_assoc($result)) {
                            echo "                        <div class='produto'>
                            <div class='produto-info'>
                                <h5 class='nome-produto'>" . $products_data['product_name'] . "</h5>
                                <p class='descricao-produto'>" . $products_data['product_description'] . "</p>                                <p class='descricao-produto'>Quantidade em estoque: " . $products_data['stock_quantity'] . "</p>                                <h6 class='preco-produto'>R$ " . $products_data['product_price'] . "</h6>
                            </div>
                            <div class='produto-img-container'>
                                <img class='produto-img' src='./IMG/servicoIcon.png'>
                            </div>
                            <form method='POST' style='display:inline;'>
                                <input type='hidden' name='delete_type' value='products'>
                                <input type='hidden' name='product_id' value='" . $products_data['product_id'] . "'>
                                <button id='delete-btn' type='submit' onclick=\"return confirm('Tem certeza que deseja excluir este produto?')\">Excluir</button>
                            </form>
                        </div>";
                        }
                        ?>

                    </div>
                </div>
            </div>

            <div class="content-container" id="servicos-content" style="display: none;">
                <div class="produtos-container">
                    <div class="produtos-divisao">
                        <br><br>
                        <button
                            style="border: none; background-color: transparent; color: #D86000; cursor: pointer;">Adicionar
                            serviços</button>
                        <div class="popup">
                            <form method="POST" action="" class="popup-container">
                                <button type="button" class="popup-btn popup-btn--close">X</button>
                                <input type="hidden" name="form_type" value="service">
                                <input type="text" name="services_name" placeholder="* Nome do serviço." required />
                                <input type="text" name="services_description" placeholder="* Descrição do serviço."
                                    required />
                                <input id="preco" type="text" name="services_price" step="0.01" min="0" max="999999.99"
                                    placeholder="* Preço do serviço" required />
                                <button type="submit" class="popup-btn">Adicionar</button>
                            </form>
                        </div>
                        <div class="divisao-head">
                            <h4 class="divisao-titulo">Serviços</h4>
                        </div>

                        <?php

                        $sql = "SELECT * FROM services ORDER BY services_name ASC";
                        $result = $connection->query($sql);

                        while ($services_data = mysqli_fetch_assoc($result)) {
                            echo "                        <div class='produto'>
                            <div class='produto-info'>
                                <h5 class='nome-produto'>" . $services_data['services_name'] . "</h5>
                                <p class='descricao-produto'>" . $services_data['services_description'] . "</p>
                                <h6 class='preco-produto'>R$ " . $services_data['services_price'] . "</h6>
                            </div>
                            <div class='produto-img-container'>
                            <img class='produto-img' src='./IMG/servicoIcon.png'>
                            </div>
                                <form method='POST' style='display:inline;'>
                                    <input type='hidden' name='delete_type' value='services'>
                                    <input type='hidden' name='service_id' value='" . $services_data['services_id'] . "'>
                                    <button id='delete-btn' type='submit' onclick=\"return confirm('Tem certeza que deseja excluir este serviço?')\">Excluir</button>
                                </form>
                            </div>";
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script>
        document.querySelectorAll("button")[1].addEventListener("click", function () {
            document.body.classList.toggle("popup-true");
        });

        document.querySelectorAll("button")[2].addEventListener("click", function () {
            document.body.classList.toggle("popup-true");
        });

        document.querySelectorAll("button")[4].addEventListener("click", function () {
            document.body.classList.toggle("popup-true");
        });

        document.querySelectorAll("button")[5].addEventListener("click", function () {
            document.body.classList.toggle("popup-true");
        });

        $('#preco').mask("#.##0,00", { reverse: true });
    </script>


</body>

</html>