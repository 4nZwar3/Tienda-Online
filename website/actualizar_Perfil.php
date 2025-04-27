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

// Obtener los valores del formulario
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$correo = $_SESSION['correo']; // Cambiar $_SESSION['nombre'] a $_SESSION['correo']

// Sanitizar los datos del formulario para evitar inyecciones SQL
$nombre = $conexion->real_escape_string($nombre);
$apellidos = $conexion->real_escape_string($apellidos);

// Definir la consulta SQL para actualizar la información del perfil
$sql = "UPDATE clientes SET nombre = '$nombre', apellidos = '$apellidos' WHERE correo = '$correo'";

if ($conexion->query($sql) === TRUE) {
    // Actualizar la sesión con el nuevo nombre
    $_SESSION['nombre'] = $nombre;
    header("Location: perfil_Cliente.php");
    exit();
} else {
    echo "Error al actualizar la información del perfil: " . $conexion->error;
}

// Cerrar la conexión
$conexion->close();
?>