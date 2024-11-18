<?php
session_start();
include_once('config.php');

if (isset($_POST['cart_id']) && isset($_SESSION['user_data'])) {
    $cart_id = $_POST['cart_id'];
    $user_id = $_SESSION['user_data']['id'];

    $sql = "SELECT * FROM cart WHERE id = ? AND user_id = ? AND a_status = 2";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ii", $cart_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $update_sql = "UPDATE cart SET a_status = 3 WHERE id = ?";
        $update_stmt = $connection->prepare($update_sql);
        $update_stmt->bind_param("i", $cart_id);
        if ($update_stmt->execute()) {
            header("Location: pedidos.php");
            exit();
        } else {
            echo "Erro ao atualizar o status do pedido.";
        }
    } else {
        echo "Pedido não encontrado ou não pertence ao usuário.";
    }
}
?>
