<?php
//empleados_salva
include('validar_sesion.php');

require "Funciones/conecta.php"; //incluir archivo_importar archivo
$con=conecta();

//recibe variables
$nombre=$_REQUEST['nombre'];
$apellidos=$_REQUEST['apellidos'];
$correo=$_REQUEST['correo'];
$pass=$_REQUEST['pass'];
$rol=$_REQUEST['rol'];
$archivo_n='';
$archivo='';
$encriptado=md5($pass);

$sql="INSERT INTO empleados
    (nombre, apellidos, correo, pass, rol, archivo_nombre, archivo_file)
    VALUES('$nombre', '$apellidos', '$correo', '$encriptado', $rol, '$archivo_n', '$archivo')";

$con->query($sql);

header("Location: empleados_lista.php");


?>