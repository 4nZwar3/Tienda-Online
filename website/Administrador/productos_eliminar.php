<?php
// productos_eliminar.php
include('validar_sesion.php');

require "Funciones/conecta.php";
$con = conecta();

// Obtener el ID del producto desde el formulario
$id = $_POST['id'];

// Actualizar el campo 'eliminado' a 1 para marcar el producto como eliminado
$sql = "UPDATE productos SET eliminado = 1 WHERE id = $id";
$res = $con->query($sql);

// Retornar una respuesta según el resultado de la consulta
if($res){
    echo '1'; // Éxito
}else{
    echo '0'; // Error
}
?>
