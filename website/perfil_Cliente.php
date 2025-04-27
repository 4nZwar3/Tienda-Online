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

// Obtener la información del usuario
$correo = $_SESSION['correo'];
$sql = "SELECT nombre, apellidos FROM clientes WHERE correo = '$correo'";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nombre = $row['nombre'];
    $apellidos = $row['apellidos'];
} else {
    echo "Error al obtener la información del perfil.";
    exit;
}

// Cerrar la conexión
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
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

        .profile-form {
            text-align: center;
            padding: 50px;
            background-color: #0C969C;
            width: 400px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            color: white;
        }

        .profile-form h2 {
            margin-bottom: 20px;
        }

        .profile-form input {
            margin-bottom: 10px;
            padding: 10px;
            width: 100%;
            border: none;
            border-radius: 5px;
            outline: none;
        }

        .profile-form button {
            background-color: #0A7075;
            border: none;
            color: white;
            padding: 10px 25px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-bottom: 10px;
        }

        .button-container {
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
        }

        .back-button, .orders-button {
            background-color: #0A7075;
            text-decoration: none;
            color: white;
            padding: 10px 25px;
            border-radius: 5px;
            display: inline-block;
            width: 100%;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="profile-form">
    <h2>Perfil de Usuario</h2>
    <form action="actualizar_Perfil.php" method="POST">
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $nombre; ?>" required><br>
        <label>Apellidos:</label>
        <input type="text" name="apellidos" value="<?php echo $apellidos; ?>" required><br>
        <button type="submit">Actualizar</button>
    </form>

    <div class="button-container">
        <a href="historial_Pedidos.php" class="orders-button">Ver Historial de Pedidos</a>
        <a href="index_Clientes.php" class="back-button">Regresar</a>
    </div>
</div>

</body>
</html>