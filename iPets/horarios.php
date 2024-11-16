<?php
session_start();
include_once('config.php');

$services_id = isset($_GET['services_id']) ? $_GET['services_id'] : null;
$selected_date = isset($_GET['date']) ? $_GET['date'] : null;

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

$occupied_times = [];
if ($selected_date) {
    $sql = "SELECT date_time FROM agendamentos WHERE DATE(date_time) = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $selected_date);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        while ($row = $stmt->fetch()) {
            $occupied_times[] = date("H:i", strtotime($row['date_time']));
        }
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
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
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
        <h2>Horários</h2>
        <p class="descriçao">Selecione o horário que deseja agendar.</p>

        <br>

        <div class="horarios-dia">
            <?php
            if ($selected_date && DateTime::createFromFormat('Y-m-d', $selected_date)) {
                $formatted_date = DateTime::createFromFormat('Y-m-d', $selected_date)->format('d/m/Y');
            } else {
                $formatted_date = date('d/m/Y');
            }
            ?>

            <h3 class="txt date" id="dia"><?php echo htmlspecialchars($formatted_date); ?></h3>
            <p class="txt">3 horários disponíveis</p>
            <hr noshade="noshade" size="1">
            <div class="horarios">
                <ul>
                    <?php 
                    $available_times = ['10:00', '14:00', '18:00'];
                    foreach ($available_times as $time) {
                        if (in_array($time, $occupied_times)) {
                            echo "<li><button disabled> $time </button></li>";  // Desabilitar se ocupado
                        } else {
                            echo "<li><button> $time </button></li>";  // Habilitar se disponível
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>

        <br>

        <div class="button">
            <a class="back-button" onclick="history.back()">Cancelar</a>
        </div>

        <form id="horario-form" action="processa_agendamento.php" method="POST">
            <input type="hidden" name="services_id" value="<?php echo $services_id; ?>">
            <input type="hidden" name="selected_date" id="selected_date" value="<?php echo $selected_date; ?>">
            <input type="hidden" name="selected_time" id="selected_time">
        </form>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const buttons = document.querySelectorAll('.horarios button');

            buttons.forEach(button => {
                button.addEventListener('click', function () {
                    const selectedTime = this.innerText;
                    const selectedDate = document.getElementById('dia').innerText;

                    document.getElementById('selected_date').value = selectedDate;
                    document.getElementById('selected_time').value = selectedTime;

                    document.getElementById('horario-form').submit();
                });
            });
        });

    </script>

</body>

</html>
