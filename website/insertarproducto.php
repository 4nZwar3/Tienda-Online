<?php
session_name("sesion_cliente");
session_start();
include 'Administrador/Funciones/conecta.php';

$conexion = conecta();

if (!$conexion) {
    die("Error en la conexión a la base de datos");
}

// Verificar que el cliente esté logueado
if (!isset($_SESSION['nombre'])) {
    echo "El cliente no está logueado.";
    exit();
}

$id_producto = $_POST['id_producto'] ?? null;
$cantidad = $_POST['cantidad'] ?? null;
$nombre_cliente = $_SESSION['nombre'];  

// Verificar que los datos estén presentes
if (!$id_producto || !$cantidad) {
    echo "Faltan datos necesarios.";
    exit();
}

// Obtener el ID del cliente
$query_cliente_id = "SELECT id FROM clientes WHERE nombre = '$nombre_cliente' LIMIT 1";
$resultado_cliente = $conexion->query($query_cliente_id);

if ($resultado_cliente && $resultado_cliente->num_rows > 0) {
    $cliente = $resultado_cliente->fetch_assoc();
    $id_cliente = $cliente['id'];  
} else {
    echo "Cliente no encontrado.";
    exit();
}

// Verificar si hay un pedido abierto
$query_pedido_abierto = "SELECT id FROM pedidos WHERE cliente_id = '$id_cliente' AND `status` = 'abierto' LIMIT 1";
$resultado_pedido = $conexion->query($query_pedido_abierto);

if ($resultado_pedido && $resultado_pedido->num_rows > 0) {
    $pedido = $resultado_pedido->fetch_assoc();
    $id_pedido = $pedido['id'];
} else {
    $query_crear_pedido = "INSERT INTO pedidos (cliente_id, `status`) VALUES ('$id_cliente', 'abierto')";
    $conexion->query($query_crear_pedido);
    $id_pedido = $conexion->insert_id;
}

// Obtener el costo del producto
$query_producto = "SELECT costo FROM productos WHERE id = '$id_producto'";
$resultado_producto = $conexion->query($query_producto);

if ($resultado_producto && $resultado_producto->num_rows > 0) {
    $producto = $resultado_producto->fetch_assoc();
    $precio = $producto['costo'];
    $subtotal = $precio * $cantidad;

    // Verificar si el producto ya está en el pedido
    $query_producto_en_pedido = "SELECT * FROM pedidos_productos WHERE pedido_id = '$id_pedido' AND producto_id = '$id_producto'";
    $resultado_producto_pedido = $conexion->query($query_producto_en_pedido);

    if ($resultado_producto_pedido && $resultado_producto_pedido->num_rows > 0) {
        // Actualizar la cantidad y el subtotal
        $query_actualizar = "
            UPDATE pedidos_productos 
            SET cantidad = cantidad + '$cantidad', subtotal = subtotal + '$subtotal' 
            WHERE pedido_id = '$id_pedido' AND producto_id = '$id_producto'";
        $conexion->query($query_actualizar);
        echo "Producto actualizado en el carrito.";
    } else {
        // Insertar nuevo producto con cantidad y subtotal
        $query_agregar_producto = "
            INSERT INTO pedidos_productos (pedido_id, producto_id, cantidad, subtotal) 
            VALUES ('$id_pedido', '$id_producto', '$cantidad', '$subtotal')";
        $conexion->query($query_agregar_producto);
        echo "Producto agregado al carrito.";
    }

    // Actualizar el total del pedido
    $query_actualizar_total = "
        UPDATE pedidos 
        SET total = total + '$subtotal' 
        WHERE id = '$id_pedido'";
    $conexion->query($query_actualizar_total);
} else {
    echo "Producto no encontrado.";
}

$conexion->close();
?>
