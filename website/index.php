<?php
session_name("sesion_cliente");
session_start();
include 'Administrador/Funciones/conecta.php';

$conexion = conecta();

if (!$conexion) {
    die("Error en la conexión a la base de datos");
}

// Consulta para obtener imágenes activas de la tabla promociones
$query_promociones = "SELECT archivo, nombre FROM promociones WHERE eliminado = 0 ORDER BY RAND() LIMIT 6";
$resultado_promociones = $conexion->query($query_promociones);
$promociones = [];
if ($resultado_promociones && $resultado_promociones->num_rows > 0) {
    while ($row = $resultado_promociones->fetch_assoc()) {
        $promociones[] = $row;
    }
}

// Consulta para obtener productos activos
$query_productos = "SELECT archivo, nombre, codigo, costo FROM productos WHERE eliminado = 0 ORDER BY RAND() LIMIT 6";
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
    <title>Home</title>
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
            max-height: 50px; /* Ajusta el tamaño de la imagen */
            height: auto;
            margin-right: 20px; /* Espacio entre la imagen y el menú */
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

        .carousel-container {
            margin-top: 80px;
            position: relative;
            max-width: 100%;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .carousel-slide img {
            width: 100%;
            display: none;
            transition: opacity 0.5s ease-in-out;
        }

        .carousel-slide img:first-child {
            display: block;
        }

        .prev, .next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            z-index: 100;
            border-radius: 5px;
        }

        .prev { left: 10px; }
        .next { right: 10px; }

        .prev:hover, .next:hover {
            background-color: rgba(0, 0, 0, 0.8);
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
    </style>
</head>
<body>

<div class="header">
    <!-- Reemplaza el texto con la imagen y ajusta su tamaño -->
    <img src="logoJ.webp" alt="Logo" class="logo">
    <ul class="menu-links">
        <li><a href="index_Clientes.php">Home</a></li>
        <li><a href="productos_Clientes.php">Productos</a></li>
        <li><a href="Formcorreo.php">Contacto</a></li>
        <?php if (isset($_SESSION['nombre'])): ?>
            <li><a href="carrito_Clientes.php">Ver Carrito</a></li>
            <li><a href="logout.php">Salir</a></li>
            <li>Bienvenido, <a href="perfil_Cliente.php"><?php echo $_SESSION['nombre']; ?></a></li>
        <?php else: ?>
            <li><a href="login_Clientes.php">Login</a></li>
        <?php endif; ?>
    </ul>
</div>

<div class="carousel-container">
    <div class="carousel-slide">
        <?php foreach ($promociones as $promo): ?>
            <img src="Administrador/archivos/<?php echo $promo['archivo']; ?>" alt="<?php echo $promo['nombre']; ?>">
        <?php endforeach; ?>
    </div>
    <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
    <button class="next" onclick="moveSlide(1)">&#10095;</button>
</div>

<div class="productos-container">
    <?php foreach ($productos as $producto): ?>
        <div class="producto">
            <img src="Administrador/archivos/<?php echo $producto['archivo']; ?>" alt="<?php echo $producto['nombre']; ?>">
            <h2><?php echo $producto['nombre']; ?></h2>
            <p>Modelo: <?php echo $producto['codigo']; ?></p>
            <p class="precio">$<?php echo number_format($producto['costo'], 2); ?></p>
        </div>
    <?php endforeach; ?>
</div>

<script>
let index = 0;
function moveSlide(n) {
    const slides = document.querySelectorAll(".carousel-slide img");
    slides[index].style.display = "none";
    index = (index + n + slides.length) % slides.length;
    slides[index].style.display = "block";
}
</script>

<footer>        
    <p>&copy; <?php echo date("Y"); ?> Productos Julio | Todos los derechos reservados | <a href="#">Política de Privacidad</a> | <a href="#">Términos y Condiciones</a></p>
</footer>

</body>
</html>
