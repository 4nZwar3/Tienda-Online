<?php
session_name("sesion_cliente");
session_start();  // Inicia la sesión al principio

include 'Administrador/Funciones/conecta.php';
$conexion = conecta();

if (!$conexion) {
    die("Error en la conexión a la base de datos");
}

// Inicializa las variables de búsqueda y precios
$busqueda = isset($_POST['busqueda']) ? $_POST['busqueda'] : '';

// Crea la condición para la búsqueda
$condicion_busqueda = "WHERE eliminado = 0";

// Agrega la condición para búsqueda de productos
if ($busqueda) {
    $condicion_busqueda .= " AND nombre LIKE '%$busqueda%'";
}

// Consulta para obtener los productos con búsqueda
$query_productos = "SELECT archivo, nombre, codigo, costo FROM productos $condicion_busqueda ORDER BY RAND()";
$resultado_productos = $conexion->query($query_productos);

$productos = [];
if ($resultado_productos && $resultado_productos->num_rows > 0) {
    while ($row = $resultado_productos->fetch_assoc()) {
        $productos[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #F5F5F5;
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

        .productos-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 20px;
            max-width: 1200px;
            margin: 20px auto;
        }

        .producto {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            padding: 15px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .producto:hover {
            transform: translateY(-10px);
        }

        .producto img {
            max-width: 100%;
            border-radius: 10px;
        }

        .producto h2 {
            font-size: 18px;
            margin: 10px 0;
        }

        .producto p {
            margin: 5px 0;
        }

        .producto .precio {
            font-size: 20px;
            font-weight: bold;
            color: #0A7075;
        }

        .producto .cantidad-container {
            margin: 10px 0;
        }

        .producto input[type="number"] {
            padding: 5px;
            width: 60px;
            border-radius: 5px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .producto button {
            background-color: #0A7075;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .producto button:hover {
            background-color: #0C969C;
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

        .search-container {
            text-align: center;
            margin: 20px;
        }

        .search-container input[type="text"] {
            padding: 10px;
            width: 200px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        .search-container input[type="number"] {
            padding: 10px;
            width: 100px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
            margin-top: 10px;
        }

        .search-container button {
            padding: 10px 20px;
            background-color: #0A7075;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .search-container button:hover {
            background-color: #0C969C;
        }
    </style>
</head>
<body>

<a href="index_Clientes.php" class="regresar-btn">Regresar</a>

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

<!-- Formulario de búsqueda y filtro de precios -->
<div class="search-container">
    <form id="form-busqueda" method="POST" action="productos_Clientes.php">
        <input type="text" name="busqueda" placeholder="Buscar productos..." value="<?php echo $busqueda; ?>">
        <button type="submit">Buscar</button>
    </form>
</div>

<div class="productos-container">
    <?php if (isset($productos) && count($productos) > 0): ?>
        <?php foreach ($productos as $producto): ?>
            <div class="producto">
                <a href="detalle_producto.php?id_producto=<?php echo $producto['codigo']; ?>">
                    <img src="Administrador/archivos/<?php echo $producto['archivo']; ?>" alt="<?php echo $producto['nombre']; ?>">
                </a>
                <h2><a href="detalle_producto.php?id_producto=<?php echo $producto['codigo']; ?>"><?php echo $producto['nombre']; ?></a></h2>
                <p>Modelo: <?php echo $producto['codigo']; ?></p>
                <p class="precio">$<?php echo number_format($producto['costo'], 2); ?></p>

                <?php if (isset($_SESSION['nombre'])): ?>
                    <div class="cantidad-container">
                        <input type="number" min="1" value="1" id="cantidad_<?php echo $producto['codigo']; ?>" />
                    </div>
                    <button onclick="agregarAlCarrito('<?php echo $producto['codigo']; ?>')">Agregar al Carrito</button>
                <?php else: ?>
                    <p>Por favor, <a href="login_Clientes.php">inicie sesión</a> para agregar productos al carrito.</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay productos disponibles.</p>
    <?php endif; ?>
</div>

<script>
    function agregarAlCarrito(codigo) {
        const cantidad = document.getElementById(`cantidad_${codigo}`).value;

        if (cantidad > 0) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "insertarProducto.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = xhr.responseText;
                    alert(response);
                }
            };
            xhr.send("id_producto=" + codigo + "&cantidad=" + cantidad);
        } else {
            alert("Por favor, ingresa una cantidad válida.");
        }
    }
</script>

<footer>
    <p>&copy; <?php echo date("Y"); ?> Productos Julio | Todos los derechos reservados | <a href="#">Política de Privacidad</a> | <a href="#">Términos y Condiciones</a></p>
</footer>

</body>
</html>