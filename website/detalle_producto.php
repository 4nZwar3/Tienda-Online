<?php
session_name("sesion_cliente");
session_start();  // Asegúrate de iniciar la sesión al principio del archivo

// Detalles del producto
include 'Administrador/Funciones/conecta.php';
$conexion = conecta();

if (isset($_GET['id_producto'])) {
    $id_producto = $_GET['id_producto'];

    // Consulta para obtener detalles del producto
    $query_detalles = "SELECT * FROM productos WHERE codigo = '$id_producto' AND eliminado = 0 LIMIT 1";
    $resultado_detalles = $conexion->query($query_detalles);

    if ($resultado_detalles && $resultado_detalles->num_rows > 0) {
        $producto = $resultado_detalles->fetch_assoc();
        // Mostrar detalles del producto
    } else {
        echo "<p>Producto no encontrado.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Producto</title>
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

        .producto-detalle-container {
            padding: 80px 20px 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        .producto-detalle-container h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .producto-detalle-container img {
            width: 100%;
            border-radius: 10px;
        }

        .producto-detalle-container p {
            font-size: 16px;
            margin: 10px 0;
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

<!-- CONTENIDO DE DETALLES DEL PRODUCTO -->
<div class="producto-detalle-container">
    <?php if (isset($producto)): ?>
        <h1><?php echo $producto['nombre']; ?></h1>
        <img src="Administrador/archivos/<?php echo $producto['archivo']; ?>" alt="<?php echo $producto['nombre']; ?>" />
        <p>Descripción: <?php echo $producto['descripcion']; ?></p>
        <p>Stock: <?php echo $producto['stock']; ?></p>
        <p>Costo: $<?php echo number_format($producto['costo'], 2); ?></p>
    <?php endif; ?>
</div>

<!-- BOTÓN REGRESAR -->
<a href="productos_Clientes.php" class="regresar-btn">Regresar</a>

<!-- FOOTER -->
<footer>        
    <p>&copy; <?php echo date("Y"); ?> Productos Julio | Todos los derechos reservados | <a href="#">Política de Privacidad</a> | <a href="#">Términos y Condiciones</a></p>
</footer>

</body>
</html>
