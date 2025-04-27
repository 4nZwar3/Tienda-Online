<?php
require "Funciones/conecta.php";
$con = conecta();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    // Verificar si el correo ya existe, ignorando al empleado actual
    $sql = "SELECT * FROM empleados WHERE correo = '$correo' AND id != $id";
    $res = $con->query($sql);

    if ($res->num_rows > 0) {
        echo "1"; // El correo ya está ocupado por otro usuario
    } else {
        echo "0"; // El correo es válido
    }
}
?>
