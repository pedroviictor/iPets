<?php

session_start();

include('config.php');

if (!isset($_SESSION['user_data']['id'])) {
    echo json_encode(['error' => 'Usuário não autenticado.']);
    exit();
}

$user_data = $_SESSION['user_data'];
$user_id = $user_data['id'];

if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = (int) $_POST['product_id'];
    $quantity = (int) $_POST['quantity'];

    $sql = "UPDATE cart SET quantity = ? WHERE product_id = ? AND user_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('iii', $quantity, $product_id, $user_id);

    if ($stmt->execute()) {
        $total = 0;
        $shipping_fee = 11.90;
        $sql = "SELECT p.product_price, c.quantity FROM cart c JOIN products p ON c.product_id = p.product_id WHERE c.user_id = $user_id";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $total += $row['product_price'] * $row['quantity'];
            }
        }

        $grand_total = $total + $shipping_fee;
        echo json_encode(['total' => number_format($grand_total, 2, ',', '.')]);
    } else {
        echo json_encode(['error' => 'Erro ao atualizar a quantidade']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Dados incompletos.']);
}
?>
