<?php
session_start();

if (!isset($_SESSION['user_data'])) {
    header("Location: loginusuario.php");
    exit();
}

$user_data = $_SESSION['user_data'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/stylesPadrão.css">
    <link rel="stylesheet" href="./CSS/stylesPerfil.css">
    <script src="./JS/scriptLoja.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <title>Perfil</title>
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

    <main>


        <div class="perfil-infos">
            <div class="perfil-foto">
                <img src="./IMG/perfil-foto.png">
            </div>

            <div class="perfil-info">
                <h3>Nome:</h3>
                <p><?php echo htmlspecialchars($user_data['nome']); ?></p>
            </div>
            <hr class="sublinhado">

            <div class="perfil-info">
                <h3>E-mail:</h3>
                <p><?php echo htmlspecialchars($user_data['email']); ?></p>
            </div>
            <hr class="sublinhado">

            <div class="perfil-info">
                <h3>Telefone:</h3>
                <p id="telefone"><?php echo htmlspecialchars($user_data['telefone']); ?></p>
            </div>
            <hr class="sublinhado">

            <div class="perfil-info">
                <h3>CPF:</h3>
                <p id="cpf"><?php echo htmlspecialchars($user_data['cpf']); ?></p>
            </div>
            <hr class="sublinhado">

    <br>

            <div class="perfil-info">
                <a href="./logoutusuario.php" class="logout">Sair</a>
            </div>
        </div>

        <div class="botoes">

            <a href="#">
                <div class="botao">
                    <h2 class="pedidos">Acompanhe seus pedidos</h2>
                </div>
            </a>

            <a href="#">
                <div class="botao">
                    <h2 class="central">Entre em contato com nossa central de atendimento</h2>
                </div>
            </a>
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
        $('#cpf').mask('000.000.000-00');
        $('#telefone').mask('(00) 00000-0000');
    </script>
</body>

</html>