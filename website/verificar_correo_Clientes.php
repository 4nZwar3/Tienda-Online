<?php
require "Funciones/conecta.php";
$con = conecta();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];

    // Verificar si el correo ya existe
    $sql = "SELECT * FROM clientes WHERE correo = '$correo'";
    $res = $con->query($sql);

    if ($res->num_rows > 0) {
        echo "1"; // El correo ya está ocupado por otro usuario
    } else {
        echo "0"; // El correo es válido
    }
}
?>
