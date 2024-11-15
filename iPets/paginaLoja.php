<?php
    include 'config.php';

    if (isset($_GET['store_id'])) {
        $store_id = intval($_GET['store_id']);

        $sql = "SELECT * FROM store WHERE store_id = $store_id";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            $store_data = $result->fetch_assoc();

        } else {
            echo "Loja não encontrada.";
        }
    } else {
        echo "Loja não encontrada.";
    }
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/stylesLoja.css">
    <link rel="stylesheet" href="./CSS/stylesPadrão.css">
    <script src="./JS/scriptLoja.js"></script>
    <link rel="icon" href="./IMG/favicon.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
        <title>iPets | <?php echo $store_data['store_name']; ?></title>
        </head>

<body>

    <nav class="navbar">

        <a href="./index.html">
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

    <button onclick="window.history.back();" class="button-back">&#60;</button>

    <main>

        <div class="loja-header">
            <div class="loja-header-info-basic">
                <div class="loja-nome-container">
                <h2><?php echo $store_data['store_name']; ?></h2>
                <img class="verificado" src="./IMG/verificadoIcon.png">
                </div>

                <br>

                <div class="loja-header-info">
                    <p class="especificidade">Cães e Gatos</p>
                    <p>•</p>
                    <p class="distancia">1,2 Km</p>
                </div>
                <div class="loja-header-horario">
                    <h3 class="loja-horario-aberto hour">Abre às <?php echo $store_data['store_open']; ?></h3>
                    <h3>•</h3>
                    <h3 class="loja-horario-servico hour">Fecha às <?php echo $store_data['store_close']; ?></h3>
                </div>
            </div>
            <div class="loja-header-img">
                <img class="loja-imagem" src="./IMG/pet-shop-store-icon.png">
            </div>
        </div>

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
                        <?php
                            $sql = "SELECT * FROM products WHERE store_id = $store_id ORDER BY product_name ASC";
                            $result = $connection->query($sql);

                            if ($result->num_rows > 0) {
                                while ($product_data = mysqli_fetch_assoc($result)) {
                                    echo "
                                        <div class='produto'>
                                            <a href='./calendario.html'>
                                                <div class='produto-info'>
                                                    <h5 class='nome-produto'>" . $product_data['product_name'] . "</h5>
                                                    <p class='descricao-produto'>" . $product_data['product_description'] . "</p>
                                                    <h6 class='preco-produto'>R$ " . number_format($product_data['product_price'], 2, ',', '.') . "</h6>
                                                </div>
                                                <div class='produto-img-container'>
                                                    <img class='produto-img' src='./IMG/servicoIcon.png'>
                                                </div>
                                            </a>
                                        </div>";
                                }
                            } else {
                                echo "<p>Sem produtos disponíveis nesta loja.</p>";
                            }
                        ?>
                    </div>
                </div>
            </div>


            <div class="content-container" id="servicos-content" style="display: none;">
                <div class="produtos-container">
                    <div class="produtos-divisao">
                        <?php
                            $sql = "SELECT * FROM services WHERE store_id = $store_id ORDER BY services_name ASC";
                            $result = $connection->query($sql);

                            if ($result->num_rows > 0) {
                                while ($services_data = mysqli_fetch_assoc($result)) {
                                    echo "
                                        <div class='produto'>
                                            <a href='./calendario.php?services_id=" . $services_data['services_id'] . "'>
                                                <div class='produto-info'>
                                                    <h5 class='nome-produto'>" . $services_data['services_name'] . "</h5>
                                                    <p class='descricao-produto'>" . $services_data['services_description'] . "</p>
                                                    <h6 class='preco-produto'>R$ " . number_format($services_data['services_price'], 2, ',', '.') . "</h6>
                                                </div>
                                                <div class='produto-img-container'>
                                                    <img class='produto-img' src='./IMG/servicoIcon.png'>
                                                </div>
                                            </a>
                                        </div>";
                                }
                            } else {
                                echo "<p>Sem serviços disponíveis nesta loja.</p>";
                            }
                        ?>
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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script>

        $('.hour').mask("00:00h");

    </script>
</body>

</html>