<?php
session_name("sesion_cliente");
session_start();

// Verificar si el usuario está iniciado sesión
if (!isset($_SESSION['nombre'])) {
    // Si no está iniciado, redirigir a login-Clientes.php con un mensaje
    echo "<script>alert('Por favor, inicie sesión para acceder a esta página.'); window.location.href='login-Clientes.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
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

        .welcome-container {
            text-align: center;
            padding: 50px;
            background-color: #0C969C;
            width: 400px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            color: white;
        }

        .welcome-container h2 {
            margin-bottom: 20px;
        }

        .back-button {
            background-color: #0A7075;
            text-decoration: none;
            color: white;
            padding: 10px 25px;
            border-radius: 5px;
            display: inline-block;
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="welcome-container">
    <h2>Bienvenido, <?php echo $_SESSION['nombre']; ?>!</h2>
    <p>Has iniciado sesión con éxito.</p>
    <br>
    <a href="logout.php" class="back-button">Cerrar Sesión</a>
</div>

</body>
</html>
