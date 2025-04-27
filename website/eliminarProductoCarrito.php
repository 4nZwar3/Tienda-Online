<?php
session_name("sesion_cliente");
session_start();
include 'Administrador/Funciones/conecta.php';

$conexion = conecta();

if (!$conexion) {
    echo json_encode(['success' => false, 'message' => 'Error en la conexión a la base de datos.']);
    exit;
}

// Verificar si el producto fue enviado por POST
if (isset($_POST['id_producto'])) {
    $id_producto = intval($_POST['id_producto']);

    // Eliminar el producto de la tabla `pedidos_productos`
    $query_eliminar = "DELETE FROM pedidos_productos WHERE id = ?";
    $stmt = $conexion->prepare($query_eliminar);
    $stmt->bind_param('i', $id_producto);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Producto eliminado del carrito.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar el producto.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'ID del producto no proporcionado.']);
}

$conexion->close();
