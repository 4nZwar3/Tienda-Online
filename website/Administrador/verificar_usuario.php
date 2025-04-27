<?php
session_name("sesion_admin");
session_start(); // Inicia la sesión

require "Funciones/conecta.php"; // Conectar a la base de datos
$con = conecta();

$correo = $_POST['correo'];
$pass = md5($_POST['pass']); // Hasheamos la contraseña ingresada

// Consulta para buscar al empleado por correo
$sql = "SELECT * FROM empleados WHERE correo = ? AND eliminado = 0"; // Solo usuarios no eliminados

if ($stmt = $con->prepare($sql)) {
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $empleado = $res->fetch_assoc();

        if ($pass == $empleado['pass']) {
            // Establecemos la sesión para el nombre del usuario
            $_SESSION['nombre'] = $empleado['nombre']; // Guarda el nombre del empleado en la sesión
            echo "existe"; // Usuario encontrado y contraseña correcta
        } else {
            echo "Contraseña incorrecta"; // Contraseña incorrecta
        }
    } else {
        echo "Usuario no encontrado o inactivo"; // Usuario no encontrado o eliminado
    }
    $stmt->close();
} else {
    echo "Error en la consulta"; // Manejo de error de consulta
}

$con->close();
?>
