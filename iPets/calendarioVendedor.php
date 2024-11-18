<?php
session_start();

include 'config.php';

if (!isset($_SESSION['store_data'])) {
    header("Location: loginvendedor.php");
    exit();
}

$store_data = $_SESSION['store_data'];
$store_id = $store_data['id'];

$data = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

$query = "SELECT DATE_FORMAT(a.date_time, '%H:%i') AS horario, s.services_name 
          FROM agendamentos a
          JOIN services s ON a.services_id = s.services_id
          WHERE DATE(a.date_time) = ? AND a.store_id = ?";
$stmt = $connection->prepare($query);
if ($stmt === false) {
    die('Erro na preparação da consulta: ' . $connection->error);
}
$stmt->bind_param('ss', $data, $store_id);
$stmt->execute();
$result = $stmt->get_result();

$horariosOcupados = [];
while ($row = $result->fetch_assoc()) {
    $horariosOcupados[] = [
        'horario' => $row['horario'],
        'services_name' => $row['services_name']
    ];
}

$horariosPadrao = ['10:00', '14:00', '18:00'];

$horariosDisponiveis = [];
foreach ($horariosPadrao as $hora) {
    $ocupado = false;
    $nomeServico = '';

    foreach ($horariosOcupados as $ocupadoHorario) {
        if ($ocupadoHorario['horario'] === $hora) {
            $ocupado = true;
            $nomeServico = $ocupadoHorario['services_name'];
            break;
        }
    }

    if ($ocupado) {
        $horariosDisponiveis[] = "$hora – Ocupado ($nomeServico)";
    } else {
        $horariosDisponiveis[] = "$hora – Horário vazio";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['date'])) {
    echo json_encode($horariosDisponiveis);
    exit;
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/stylesPadrãoVendedor.css">
    <link rel="stylesheet" href="./CSS/stylesVendedorCalendário.css">
    <link rel="icon" href="./IMG/favicon.png" type="image/png"> 
    <script src="./JS/scriptVendedorCalendário.js" defer></script>
    <title>Sua agenda</title>
</head>
<body>
    <header class="header">
        <p>Olá, <?php echo htmlspecialchars($store_data['nome']); ?></p>
        <img src="./IMG/verificadoIcon.png" alt="Ícone verificado">
    </header>

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
        <a class="nav-item" href="calendariovendedor.php">
            <img src="./IMG/icon-vendedor-agenda.png" class="nav-item-img">
            <p class="nav-item-tit">Agenda</p>
        </a>
        <br><br>
        <a style="color: red; padding: 20px;" href="logoutvendedor.php">SAIR</a>
    </nav>

    <hr>

    <main>
        <div id="calendar">
            <div id="calendar-container">
                <div id="calendar"></div>
            </div>
            <div class="legenda">
                <div><div class="elemento-leg atual"></div> Dia Atual</div>
                <div><div class="elemento-leg selec"></div> Dia Selecionado</div>
            </div>
        </div>

        <div class="horarios-container">
            <div class="h3-container">
                <h3 id="data-selecionada">Selecione um dia para ver suas informações</h3>
            </div>
            <ul id="horarios-lista">
                <div class="img-container">
                    <img src="./IMG/calendario-img.png" alt="Imagem calendário">
                </div>
            </ul>
        </div>
    </main>
</body>
</html>
