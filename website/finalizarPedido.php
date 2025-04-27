<?php
include 'Administrador/Funciones/conecta.php';

$conexion = conecta();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_pedido'])) {
    $id_pedido = $_POST['id_pedido'];

    // Verificar que el total no sea NULL o 0 antes de finalizar
    $query_verificar_total = "SELECT total FROM pedidos WHERE id = '$id_pedido'";
    $resultado_total = $conexion->query($query_verificar_total);
    $pedido = $resultado_total->fetch_assoc();

    if ($pedido['total'] == NULL || $pedido['total'] == 0) {
        echo json_encode(['success' => false, 'message' => 'El total del pedido no está calculado correctamente.']);
        exit();
    }

    // Cambiar el estado del pedido a 'Finalizado'
    $query_finalizar = "UPDATE pedidos SET status = '1' WHERE id = '$id_pedido'";

    if ($conexion->query($query_finalizar)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al finalizar el pedido.']);
    }
}
?>
