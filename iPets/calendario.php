<?php
    include 'config.php';

    if (isset($_GET['services_id'])) {
        $services_id = intval($_GET['services_id']);

        $sql = "SELECT * FROM services WHERE services_id = $services_id";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            $services_data = $result->fetch_assoc();

        } else {
            echo "Serviço não encontrado.";
        }
    } else {
        echo "Serviço não encontrado.";
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
  <script src="./JS/scriptAgendamento.js" defer></script>
  <title>Agendamento</title>
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
    <h2>Agendar</h2>
    <p class="descriçao">Selecione até 3 datas de sua preferência.</p>


    <div id="calendar-container">
      <div id="calendar"></div>
    </div>


    <div class="legenda">
      <div>
        <div class="elemento-leg selec"></div> Dias Selecionados
      </div>
      <div>
        <div class="elemento-leg atual"></div> Dia Atual
      </div>
      <div>
        <div class="elemento-leg disp"></div> Dia Disponível na Agenda
      </div>
      <div>
        <div class="elemento-leg ocup"></div> Dia sem Disponibilidade na Agenda
      </div>
    </div>

    <br>
    <br>

    <div class="buttons">
      <a class="back-button" onclick="history.back()">Voltar</a>
      <a class="next-button" href="./horarios.html">Continuar</a>
    </div>

    <br>
    <br>
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
        <a href=""><img src="./IMG/instagram-icon.png"></a>
        <a href=""><img src="./IMG/twitter-icon.png"></a>
        <p>@iPetsCompany</p>
      </div>
    </div>
  </footer>
</body>

</html>