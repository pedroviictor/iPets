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

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/stylesAlimentador.css">
    <link rel="stylesheet" href="./CSS/stylesPadrão.css">
    <link rel="icon" href="./IMG/favicon.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <title>Alimentador</title>
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
        <div class="alimentador-banner" style=" background-image: url(./IMG/SVG/Vetor\ _bolha-alimentador.svg);">

            <h2 class="banner-tit">Alimentador Automático</h2>

            <div class="banner-content">
                <img src="./IMG/coelho.png">
                <div class="banner-content-txt">
                    <p>&nbsp &nbsp O alimentador iPets é um produto próprio da nossa loja, e nessa página você consegue
                        ter o controle do seu dispositivo.</p>
                    <p>&nbsp &nbsp Aqui nessa página, você pode consegue visualizar os horários salvos e adicionar novos
                        horários para a ração ser liberada ao seu pet.</p>
                </div>
            </div>
        </div>

        <hr>
        <div class="horarios">
            <div class="horarios-tit">
                <h3>Horários</h3>
                <a href="">&#43;</a>
            </div>
            <hr>

            <div class="horario-regis">
                <div class="horario-info">
                    <h3 class="horario">06:30</h3>
                    <p class="horario-nome">Refeição da manhã</p>
                </div>

                <div class="horario-buttons">
                    <div id="button-onoff" class="switch__container">
                        <input id="switch-shadow" class="switch switch--shadow" type="checkbox">
                        <label for="switch-shadow"></label>
                    </div>
                    <br>
                    <a href="">Editar</a>
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