<?php
session_name("sesion_cliente");
session_start();
include 'Administrador/Funciones/conecta.php';

$conexion = conecta();

if (!$conexion) {
    die("Error en la conexión a la base de datos");
}

// Verificar si el cliente ha iniciado sesión
if (!isset($_SESSION['nombre'])) {
    die("No has iniciado sesión.");
}

// Obtener el nombre del cliente desde la sesión
$nombre_cliente = $_SESSION['nombre'];

// Consultar el ID del cliente usando el nombre
$query_cliente = "SELECT id FROM clientes WHERE nombre = '$nombre_cliente' LIMIT 1";
$resultado_cliente = $conexion->query($query_cliente);

if ($resultado_cliente && $resultado_cliente->num_rows > 0) {
    $cliente = $resultado_cliente->fetch_assoc();
    $id_cliente = $cliente['id'];  // Asignar el ID del cliente encontrado
} else {
    die("No se encuentra el cliente en la base de datos.");
}

// Consultar si el cliente tiene un pedido abierto
$query_pedido_abierto = "SELECT id, total FROM pedidos WHERE cliente_id = '$id_cliente' AND status = 'abierto' LIMIT 1";
$resultado_pedido = $conexion->query($query_pedido_abierto);

if ($resultado_pedido && $resultado_pedido->num_rows > 0) {
    // Si existe un pedido abierto, obtener el ID del pedido y el total actual
    $pedido = $resultado_pedido->fetch_assoc();
    $id_pedido = $pedido['id'];  // Asignamos el ID del pedido abierto
    $total_pedido = $pedido['total'];
} else {
    // Si no existe un pedido abierto, se crea uno nuevo
    $fecha = date("Y-m-d H:i:s");
    $total_pedido = 0; // Inicializamos el total en 0

    // Crear un nuevo pedido
    $query_crear_pedido = "INSERT INTO pedidos (cliente_id, total, status, fecha) VALUES ('$id_cliente', '$total_pedido', 'abierto', '$fecha')";
    if ($conexion->query($query_crear_pedido)) {
        $id_pedido = $conexion->insert_id;  // Obtener el ID del nuevo pedido
        $total_pedido = 0;  // Asegurarnos de que el total esté en 0
    } else {
        die("Error al crear el pedido: " . $conexion->error);
    }
}

// Consultar los productos en el carrito (tabla pedidos_productos)
$query_carrito = "SELECT pedidos_productos.id, productos.nombre, pedidos_productos.cantidad, productos.costo, pedidos_productos.subtotal
FROM pedidos_productos
JOIN productos ON pedidos_productos.producto_id = productos.id
WHERE pedidos_productos.pedido_id = '$id_pedido'";

// Ejecutar la consulta
$resultado_carrito = $conexion->query($query_carrito);

if (!$resultado_carrito) {
    die("Error al obtener los productos del carrito: " . $conexion->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #F5F5F5;
        }

        .header {
            background-color: #0A7075;
            color: white;
            padding: 15px;
            text-align: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }

        .header .logo {
            max-height: 50px;
            height: auto;
            margin-right: 20px;
        }

        .menu-links {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 15px;
            justify-content: space-evenly;
            flex-grow: 1;
        }

        .menu-links a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .menu-links a:hover {
            text-decoration: underline;
        }

        footer {
            background-color: #0A7075;
            color: white;
            text-align: center;
            padding: 10px;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        footer a {
            color: white;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        .contact-form-container {
            padding: 80px 20px 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        form {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        form input, form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        form button {
            background-color: #0A7075;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }

        form button:hover {
            background-color: #0C969C;
        }

        .regresar-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #0A7075;
            color: white;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }

        .regresar-btn:hover {
            background-color: #0C969C;
        }

        .continuar-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #0A7075;
            color: white;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }

        .continuar-btn:hover {
            background-color: #0C969C;
        }

        table {
            width: 100%;
            margin-top: 80px;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #0A7075;
            color: white;
        }

        td {
            background-color: #fff;
        }

        .subtotal-producto {
            font-weight: bold;
        }

        .mensaje {
            color: green;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<!-- HEADER -->
<div class="header">
    <img src="logoJ.webp" alt="Logo" class="logo">
    <ul class="menu-links">
        <li><a href="index_Clientes.php">Home</a></li>
        <li><a href="productos_Clientes.php">Productos</a></li>
        <li><a href="Formcorreo.php">Contacto</a></li>
        <?php if (isset($_SESSION['nombre'])): ?>
            <li><a href="carrito_Clientes.php">Ver Carrito</a></li>
            <li><a href="logout.php">Salir</a></li>
            <li>Bienvenido, <?php echo $_SESSION['nombre']; ?></li>
        <?php else: ?>
            <li><a href="login_Clientes.php">Login</a></li>
        <?php endif; ?>
    </ul>
</div>

<h1>Carrito de Compras</h1>

<?php if ($resultado_carrito && $resultado_carrito->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php $total = 0; ?>
            <?php while ($producto = $resultado_carrito->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $producto['nombre']; ?></td>
                    <td><?php echo $producto['cantidad']; ?></td>
                    <td>$<?php echo number_format($producto['costo'], 2); ?></td>
                    <td class="subtotal-producto">$<?php echo number_format($producto['subtotal'], 2); ?></td>
                </tr>
                <?php $total += $producto['subtotal']; ?>
            <?php endwhile; ?>
            <tr>
                <td colspan="3" class="total-pedido">Total</td>
                <td colspan="2" class="total-pedido">$<?php echo number_format($total, 2); ?></td>
            </tr>
        </tbody>
    </table>
    <div class="mensaje">¡Gracias por tu compra!</div>
    <a href="carrito_paso02.php" class="continuar-btn">Continuar con la compra</a>
<?php else: ?>
    <p>No tienes productos en el carrito.</p>
<?php endif; ?>

<a href="productos_Clientes.php" class="regresar-btn">Regresar a productos</a>

<!-- FOOTER -->
<footer>
    <p>&copy; 2024 Tu Tienda Online. Todos los derechos reservados. <a href="#">Política de privacidad</a></p>
</footer>

<script>
    // Aquí puedes agregar código JavaScript para manejar la actualización de cantidades o eliminación de productos
</script>

</body>
</html>
