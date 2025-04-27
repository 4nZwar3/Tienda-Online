<?php
//empleados_eliminar.php
include('validar_sesion.php');

require "Funciones/conecta.php";
$con=conecta();
$id=$_POST['id'];

$sql="UPDATE empleados SET eliminado=1 WHERE id=$id";
$res=$con->query($sql);

if($res){
    echo '1';
}else{
    echo '0';
}
?>
