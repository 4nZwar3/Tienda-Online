<?php
// Recibir los datos del formulario
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$mensaje = $_POST['mensaje'];

// Configuración del correo
$destinatario = "julio.gonzalez5493@alumnos.udg.mx";  // Reemplaza con tu correo
$asunto = "Nuevo mensaje de contacto desde el formulario";
$contenido = "
    Nombre: $nombre\n
    Correo: $email\n
    Mensaje: $mensaje
";

// Configuración de los encabezados del correo
$headers = "From: $email" . "\r\n" .
    "Reply-To: $email" . "\r\n" .
    "X-Mailer: PHP/" . phpversion();

// Enviar el correo
if(mail($destinatario, $asunto, $contenido, $headers)){
    $mensaje_enviado = "Mensaje enviado correctamente.";
} else {
    $mensaje_enviado = "Hubo un error al enviar el mensaje. Por favor, inténtalo de nuevo.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Envío</title>
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

        .confirmation-container {
            padding: 80px 20px 20px;
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }

        .confirmation-container p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .regresar-btn {
            display: inline-block;
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
    </style>
</head>
<body>

<!-- HEADER -->
<div class="header">
    <img src="logoJ.webp" alt="Logo" class="logo">
    <ul class="menu-links">
        <li><a href="index_Clientes.php">Home</a></li>
        <li><a href="productos_Clientes.php">Productos</a></li>
        <li><a href="Formcorreo.html">Contacto</a></li>
        <?php if (isset($_SESSION['nombre'])): ?>
            <li><a href="carrito_Clientes.php">Ver Carrito</a></li>
            <li><a href="logout.php">Salir</a></li>
            <li>Bienvenido, <?php echo $_SESSION['nombre']; ?></li>
        <?php else: ?>
            <li><a href="login_Clientes.php">Login</a></li>
        <?php endif; ?>
    </ul>
</div>

<!-- CONFIRMACIÓN DE ENVÍO -->
<div class="confirmation-container">
    <h1>Confirmación de Envío</h1>
    <p><?php echo $mensaje_enviado; ?></p>
    <a href="index_Clientes.php" class="regresar-btn">Regresar al inicio</a>
</div>

<!-- FOOTER -->
<footer>        
    <p>&copy; <?php echo date("Y"); ?> Productos Julio | Todos los derechos reservados | <a href="#">Política de Privacidad</a> | <a href="#">Términos y Condiciones</a></p>
</footer>

</body>
</html>

