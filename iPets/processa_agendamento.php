<?php
session_start();
include_once('config.php');

if (!isset($_SESSION['user_data'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_data']['id'];

    $services_id = isset($_POST['services_id']) ? $_POST['services_id'] : (isset($_GET['services_id']) ? $_GET['services_id'] : null);

    if (!$services_id) {
        echo "Faltando informações do serviço.";
        exit;
    }

    // Consulta para pegar as informações do serviço
    $sql = "SELECT store_id, services_price, services_name FROM services WHERE services_id = ?";
    $stmt = $connection->prepare($sql);

    if ($stmt === false) {
        echo "Erro ao preparar a consulta: " . $connection->error;
        exit;
    }

    $stmt->bind_param("i", $services_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Agora incluímos o `services_name` no `bind_result`
        $stmt->bind_result($store_id, $service_price, $services_name); // Corrigido aqui
        $stmt->fetch();
    } else {
        echo "Serviço não encontrado.";
        exit;
    }

    $a_status = 1;

    $selected_date = isset($_POST['selected_date']) ? $_POST['selected_date'] : null;
    $selected_time = isset($_POST['selected_time']) ? $_POST['selected_time'] : null;

    var_dump($selected_date);
    var_dump($selected_time);

    if ($user_id && $services_id && $services_name && $store_id && $selected_date && $selected_time) {
        $date_parts = explode('/', $selected_date);
        if (count($date_parts) == 3) {
            $formatted_date = "{$date_parts[2]}-{$date_parts[1]}-{$date_parts[0]}";
        } else {
            echo "Formato de data inválido.";
            exit;
        }

        $date_time_str = "$formatted_date $selected_time";
        
        $date_time = DateTime::createFromFormat('Y-m-d H:i', $date_time_str);
        
        var_dump($date_time);

        if (!$date_time) {
            echo "Formato de data e hora inválido. Por favor, tente novamente.";
            exit;
        }

        $formatted_date_time = $date_time->format('Y-m-d H:i:s');

        // Verificar se o horário já está ocupado
        $sql_check = "SELECT id FROM agendamentos WHERE date_time = ?";
        $stmt_check = $connection->prepare($sql_check);
        $stmt_check->bind_param("s", $formatted_date_time);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            echo "<script>
                    alert('Esse horário já está ocupado. Por favor, escolha outro.');
                    window.location.href = 'horarios.php?date=" . urlencode($selected_date) . "&services_id=" . urlencode($services_id) . "';
                  </script>";
            exit;
        }

        $total = $service_price;

        // Inserir o agendamento
        $sql_insert = "INSERT INTO agendamentos (user_id, services_id, services_name, store_id, date_time, total, a_status) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = $connection->prepare($sql_insert);

        if ($stmt_insert === false) {
            echo "Erro ao preparar a consulta de inserção: " . $connection->error;
            exit;
        }

        $stmt_insert->bind_param("iisissi", $user_id, $services_id, $services_name, $store_id, $formatted_date_time, $total, $a_status);

        if ($stmt_insert->execute()) {
            header("Location: aguardo.php");
            exit;
        } else {
            echo "Erro ao agendar o serviço. Tente novamente.";
        }
    } else {
        echo "Faltam informações para processar o agendamento. Verifique todos os campos.";
    }
}
?>
