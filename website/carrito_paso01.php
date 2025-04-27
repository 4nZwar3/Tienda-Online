<?php
session_name("sesion_cliente");
session_start();
include 'Administrador/Funciones/conecta.php';

$conexion = conecta();

if (!$conexion) {
    die("Error en la conexión a la base de datos");
}

$id_cliente = $_SESSION['nombre'];  // Obtener el nombre del cliente desde la sesión

// Verificar si el cliente tiene un pedido abierto
$query_pedido_abierto = "SELECT id FROM pedidos WHERE cliente_id = '$id_cliente' AND status = 'abierto' LIMIT 1";
$resultado_pedido = $conexion->query($query_pedido_abierto);

if ($resultado_pedido && $resultado_pedido->num_rows > 0) {
    $pedido = $resultado_pedido->fetch_assoc();
    $id_pedido = $pedido['id'];

    // Obtener los productos del carrito
    $query_productos_carrito = "SELECT pp.id, p.nombre, pp.cantidad, pp.subtotal FROM pedidos_productos pp JOIN productos p ON pp.producto_id = p.id WHERE pp.pedido_id = '$id_pedido'";
    $resultado_productos = $conexion->query($query_productos_carrito);

    if ($resultado_productos && $resultado_productos->num_rows > 0) {
        while ($producto = $resultado_productos->fetch_assoc()) {
            echo "<div>";
            echo "Producto: " . $producto['nombre'] . " | ";
            echo "Cantidad: <input type='number' value='" . $producto['cantidad'] . "' onchange='actualizarCantidad(" . $producto['id'] . ", this.value)'> | ";
            echo "Subtotal: " . $producto['subtotal'];
            echo " <button onclick='eliminarProducto(" . $producto['id'] . ")'>Eliminar</button>";
            echo "</div>";
        }
    } else {
        echo "No hay productos en el carrito.";
    }
} else {
    echo "No tienes un pedido abierto.";
}
?>
