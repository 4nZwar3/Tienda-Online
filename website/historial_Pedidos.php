<?php
session_name("sesion_cliente");
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['correo'])) {
    header('Location: login_Clientes.php');
    exit;
}

// Incluir el archivo de conexión
include 'Funciones/conecta.php';

// Establecer la conexión
$conexion = conecta();

// Obtener el correo del cliente de la sesión
$correo = $_SESSION['correo'];

// Obtener el cliente_id del cliente actual
$sql_cliente = "SELECT id FROM clientes WHERE correo = '$correo'";
$result_cliente = $conexion->query($sql_cliente);

if ($result_cliente->num_rows > 0) {
    $row_cliente = $result_cliente->fetch_assoc();
    $cliente_id = $row_cliente['id'];
} else {
    echo "Error al obtener el ID del cliente.";
    exit;
}

// Consulta para obtener el historial de pedidos del cliente
$sql = "SELECT * FROM pedidos WHERE cliente_id = '$cliente_id'";
$result = $conexion->query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Pedidos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #F5F5F5;
        }

        .orders-container {
            text-align: center;
            padding: 50px;
            background-color: #0C969C;
            width: 600px;
            height: 80vh;
            overflow-y: auto;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
                   }

        .orders-container h2 {
            margin-bottom: 20px;
        }

        .order {
            background-color: #0A7075;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .button-container {
            display: flex;
            justify-content: center;
        }

        .back-button {
            background-color: #0A7075;
            text-decoration: none;
            color: white;
            padding: 10px 25px;
            border-radius: 5px;
            display: inline-block;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="orders-container">
    <h2>Historial de Pedidos</h2>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='order'>";
            echo "<p>Pedido ID: " . $row['id'] . "</p>";
            echo "<p>Fecha: " . $row['fecha'] . "</p>";
            echo "<p>Total: $" . $row['total'] . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No hay pedidos en tu historial.</p>";
    }
    ?>
    <div class="button-container">
        <a href="perfil_Cliente.php" class="back-button">Regresar</a>
    </div>
</div>

</body>
</html>

<?php
// Cerrar la conexión
$conexion->close();
?>