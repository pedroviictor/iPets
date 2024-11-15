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
    <link rel="stylesheet" href="./CSS/stylesCalendarioHorarios.css">
    <link rel="stylesheet" href="./CSS/stylesPadrão.css">
    <link rel="icon" href="./IMG/favicon.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <title>Agendamento</title>
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
        <h2>Horários</h2>
        <p class="descriçao">Selecione o horário que deseja agendar.</p>

        <br>

        <!-- Modelo que usaríamos para criar todos os contêiners com os dias e horas disponíveis para agendamento -->
        <div class="horarios-dia">
            <h3 class="txt" id="dia">30 JUL. 2024</h3>
            <p class="txt" class="desc">3 Horários encontrados</p>
            <hr noshade="noshade" size="1">
            <div class="horarios">
                <ul>
                    <li><a href="#popup">10:00</a></li>
                    <li><a href="#popup">14:00</a></li>
                    <li><a href="#popup">18:00</a></li>
                </ul>
            </div>
        </div>
        <!-- Fim do modelo -->

        <br>

        <div class="button">
            <a class="back-button" onclick="history.back()">Cancelar</a>
        </div>

        <div id="popup" class="overlay">
            <div class="popup-container">
                <div class="txt-popup">
                    <h3>Confirmar Agendamento de:</h3>
                    <div class="popup-content">
                        <div class="img-popup">
                            <img src="https://static.wixstatic.com/media/5e76bd_d1ad86125edc4a4598525226bf03b369~mv2.jpg/v1/crop/x_778,y_25,w_593,h_748/fill/w_460,h_580,al_c,q_80,usm_0.66_1.00_0.01,enc_auto/Bath-Dog.jpg"
                                alt="Cachorro da raça Yorkshire terrier com uma touca de banho cor de rosa">
                        </div>
                        <div>
                            <p>Banho canino simples P</p>
                            <!-- ↑ Aqui mostraria, coletando por algum método (provavelmente usando JS para, quando selecionar um serviço, guardar o nome dele); Como exemplo, usamos Banho canino simples P -->
                            <p>30 de Julho de 2024</p>
                            <!-- ↑ Aqui mostraria, pegando com base nas escolhas do usuário realizadas (coletaríamos após ele selecionar a hora, fazendo uma filtragem dos dias anteriormente selecionados, deixando apenas aquele no qual deseja realizar o agendamento; Creio ser possível realizar isso com JS), o dia selecionado para agendar; Como exemplo, usamos dia 30 de Julho de 2024 -->
                            <!-- ↑ No JS da página do calendário, tem um lugar onde são armazenados os dias selecionados, ali usaríamos para tanto realizar essa filtragem quanto para mostrar os dias com as horas possíveis para agendamento, na parte de cima da página -->
                            <p>10:00</p>
                            <!-- ↑ Aqui mostraria o horário selecionado agora (também usando JS, apenas coletando a hora na qual foi selecionada) -->
                        </div>
                    </div>
                </div>
                <div class="buttons-popup">
                    <a class="back-button-popup" onclick="history.back()">Voltar</a>
                    <a class="next-button-popup" href="./aguardo.php">Confirmar</a>
                </div>
            </div>
        </div>
    </main>

    <br>

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