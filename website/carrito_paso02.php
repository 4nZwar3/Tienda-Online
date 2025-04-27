<?php
session_name("sesion_cliente");
session_start();
include 'Administrador/Funciones/conecta.php';

$conexion = conecta();

if (!$conexion) {
    die("Error en la conexión a la base de datos");
}

if (!isset($_SESSION['nombre'])) {
    die("El cliente no está logueado.");
}

$nombre_cliente = $_SESSION['nombre'];

// Obtener el ID del cliente
$query_cliente_id = "SELECT id FROM clientes WHERE nombre = '$nombre_cliente' LIMIT 1";
$resultado_cliente = $conexion->query($query_cliente_id);
$cliente = $resultado_cliente->fetch_assoc();
$id_cliente = $cliente['id'];

// Consultar el pedido abierto
$query_pedido_abierto = "SELECT id FROM pedidos WHERE cliente_id = '$id_cliente' AND status = 'abierto' LIMIT 1";
$resultado_pedido = $conexion->query($query_pedido_abierto);

if ($resultado_pedido && $resultado_pedido->num_rows > 0) {
    $pedido = $resultado_pedido->fetch_assoc();
    $id_pedido = $pedido['id'];

    // Obtener los productos del carrito
    $query_productos_carrito = "
    SELECT p.nombre, pp.cantidad, pp.subtotal 
    FROM pedidos_productos pp
    JOIN productos p ON pp.producto_id = p.id
    WHERE pp.pedido_id = '$id_pedido' AND pp.cantidad > 0";
    $resultado_carrito = $conexion->query($query_productos_carrito);

    // Calcular el total
    $query_total = "SELECT SUM(subtotal) AS total FROM pedidos_productos WHERE pedido_id = '$id_pedido'";
    $resultado_total = $conexion->query($query_total);
    $total = $resultado_total->fetch_assoc()['total'];

    // Actualizar el total en la tabla pedidos
    $query_actualizar_total = "UPDATE pedidos SET total = '$total' WHERE id = '$id_pedido'";
    if ($conexion->query($query_actualizar_total)) {
        echo "Total actualizado correctamente.";
    } else {
        echo "Error al actualizar el total.";
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen del Pedido</title>
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

        .container {
            padding: 80px 20px 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        .mensaje {
            color: green;
            font-weight: bold;
            margin-top: 20px;
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

        button {
            background-color: #0A7075;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }

        button:hover {
            background-color: #0C969C;
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
        <li><a href="carrito_Clientes.php">Ver Carrito</a></li>
        <li><a href="logout.php">Salir</a></li>
        <li>Bienvenido, <?php echo $_SESSION['nombre']; ?></li>
    </ul>
</div>

<div class="container">
    <h1>Resumen del Pedido</h1>
    <?php if ($resultado_carrito && $resultado_carrito->num_rows > 0): ?>
        <ul>
            <?php
            while ($producto = $resultado_carrito->fetch_assoc()):
                echo "<li>{$producto['nombre']} - Cantidad: {$producto['cantidad']} - Subtotal: $" . number_format($producto['subtotal'], 2) . "</li>";
            endwhile;
            ?>
        </ul>
        <?php
        // Calcular el total
        $query_total = "SELECT SUM(subtotal) AS total FROM pedidos_productos WHERE pedido_id = '$id_pedido'";
        $resultado_total = $conexion->query($query_total);
        $total = $resultado_total->fetch_assoc()['total'];
        ?>
        <h3>Total: $<?php echo number_format($total, 2); ?></h3>
        <a href="carrito_Clientes.php" class="regresar-btn">Regresar al carrito</a><br><br>
        <button id="finalizarPedido">Finalizar Pedido</button>
    <?php else: ?>
        <p>No tienes productos en tu pedido.</p>
    <?php endif; ?>
</div>

<footer>
    <p>&copy; <?php echo date("Y"); ?> Productos Julio | Todos los derechos reservados | <a href="#">Política de Privacidad</a> | <a href="#">Términos y Condiciones</a></p>
</footer>

<script>
document.getElementById('finalizarPedido').addEventListener('click', function() {
    var confirmation = confirm('¿Estás seguro de que deseas finalizar el pedido?');

    if (confirmation) {
        var formData = new FormData();
        formData.append('id_pedido', <?php echo $id_pedido; ?>);

        fetch('finalizarPedido.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const container = document.querySelector('.container');
                container.innerHTML = `
                    <h1>Resumen del Pedido</h1>
                    <p class="mensaje">¡Pedido finalizado con éxito!</p>
                    <a href="index_Clientes.php" style="display:inline-block; margin-top:20px;">
                        <button>Volver a la página principal</button>
                    </a>
                `;
            } else {
                alert('Error al finalizar el pedido.');
            }
        });
    }
});
</script>


</body>
</html>
