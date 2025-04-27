<?php
// detalle_pedido.php

session_name("sesion_admin");
session_start();
include 'Funciones/conecta.php';

$conexion = conecta();

if (!$conexion) {
    die("Error en la conexión a la base de datos");
}

// Obtener el ID del pedido desde la URL
$id_pedido = isset($_GET['id']) ? $_GET['id'] : die("Pedido no válido.");

// Consultar los detalles del pedido (productos asociados a este pedido)
$query_detalle = "SELECT productos.nombre, pedidos_productos.cantidad, productos.costo, pedidos_productos.subtotal
                  FROM pedidos_productos
                  JOIN productos ON pedidos_productos.producto_id = productos.id
                  WHERE pedidos_productos.pedido_id = '$id_pedido'";
$resultado_detalle = $conexion->query($query_detalle);

// Consultar el total del pedido
$query_total = "SELECT total FROM pedidos WHERE id = '$id_pedido'";
$resultado_total = $conexion->query($query_total);
$total_pedido = $resultado_total->fetch_assoc()['total'];
?>

<style>
    .container {
        max-width: flex;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #6BA3BE;
    }
    th, td {
        text-align: left;
        border-bottom: 1px solid black;
        padding: 8px;
    }
    th {
        background-color: #0A7075;
        color: white;
    }
    a {
        color: #0A7075;
        font-weight: bold;
        text-decoration: none;
    }
    a:hover {
        text-decoration: underline;
    }
    h1, h3 {
        color: #0A7075;
    }
</style>

<div class="container">
    <h1>Detalle del Pedido <?php echo $id_pedido; ?></h1>

    <?php if ($resultado_detalle && $resultado_detalle->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $gran_total = 0;
                while ($detalle = $resultado_detalle->fetch_assoc()):
                    $gran_total += $detalle['subtotal'];
                ?>
                <tr>
                    <td><?php echo $detalle['nombre']; ?></td>
                    <td><?php echo $detalle['cantidad']; ?></td>
                    <td>$<?php echo number_format($detalle['costo'], 2); ?></td>
                    <td>$<?php echo number_format($detalle['subtotal'], 2); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h3>Total del Pedido: $<?php echo number_format($total_pedido, 2); ?></h3>

    <?php else: ?>
        <p>No hay detalles disponibles para este pedido.</p>
    <?php endif; ?>

    <br>
    <a href="pedidos.php">Regresar</a>
</div>
