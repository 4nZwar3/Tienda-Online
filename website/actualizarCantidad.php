<?php
session_name("sesion_cliente");
session_start();
include 'Administrador/Funciones/conecta.php';

$conexion = conecta();

if (!$conexion) {
    echo json_encode(['success' => false, 'message' => 'Error en la conexión a la base de datos.']);
    exit;
}

// Verificar si se enviaron los datos necesarios por POST
if (isset($_POST['id_producto']) && isset($_POST['cantidad'])) {
    $id_producto = intval($_POST['id_producto']);
    $cantidad = intval($_POST['cantidad']);

    if ($cantidad <= 0) {
        echo json_encode(['success' => false, 'message' => 'La cantidad debe ser mayor a 0.']);
        exit;
    }

    // Actualizar la cantidad y el subtotal en la tabla `pedidos_productos`
    $query_actualizar = "UPDATE pedidos_productos SET cantidad = ?, subtotal = cantidad * (SELECT costo FROM productos WHERE id = producto_id) WHERE id = ?";
    $stmt = $conexion->prepare($query_actualizar);
    $stmt->bind_param('ii', $cantidad, $id_producto);

    if ($stmt->execute()) {
        // Consultar el nuevo subtotal
        $query_subtotal = "SELECT subtotal FROM pedidos_productos WHERE id = ?";
        $stmt_subtotal = $conexion->prepare($query_subtotal);
        $stmt_subtotal->bind_param('i', $id_producto);
        $stmt_subtotal->execute();
        $stmt_subtotal->bind_result($subtotal);
        $stmt_subtotal->fetch();

        echo json_encode(['success' => true, 'subtotal' => $subtotal]);
        $stmt_subtotal->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar el producto.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos.']);
}

$conexion->close();
