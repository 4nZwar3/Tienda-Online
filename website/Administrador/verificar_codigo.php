<?php
require "Funciones/conecta.php";
$con = conecta();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codigo = $_POST['codigo']; // Código enviado desde el formulario
    
    // Consulta para verificar si el código ya existe
    $sql = "SELECT * FROM productos WHERE codigo = '$codigo'";
    $res = $con->query($sql);

    if ($res->num_rows > 0) {
        echo "1"; // El código ya existe
    } else {
        echo "0"; // El código no existe
    }
}
?>
