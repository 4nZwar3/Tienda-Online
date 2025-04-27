<?php
// Incluir el archivo de conexión
include 'Funciones/conecta.php';

// Establecer la conexión
$conexion = conecta();

// Obtener los valores del formulario
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$pass = $_POST['pass'];

// Sanitizar los datos del formulario para evitar inyecciones SQL
$nombre = $conexion->real_escape_string($nombre);
$email = $conexion->real_escape_string($email);
$pass = $conexion->real_escape_string($pass);

// Encriptar la contraseña usando MD5
$pass_encriptada = md5($pass);

// Definir la consulta SQL con los valores del formulario
$sql = "INSERT INTO clientes (nombre, correo, pass) VALUES ('$nombre', '$email', '$pass_encriptada')";

if ($conexion->query($sql) === TRUE) {
    header("Location: login_Clientes.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conexion->error;
}

// Cerrar la conexión
$conexion->close();
?>