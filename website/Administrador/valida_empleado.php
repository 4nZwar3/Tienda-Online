<?php
//valida_empleado
session_name("sesion_admin");
session_start();
requiere "Funciones/conecta.php";
$con=conecta();

$correo=$_REQUEST['correo'];
$pass=md5($_REQUEST['pass']);

$sql="SELECT * FROM empleados WHERE correo='$correo' AND pass='$pass' AND eliminado=0";
$res=$con->query($sql);
$num=$res->num_rows;

if($num==1){
    $row=$res->fetch_array();
    $idEmp=$row["id"];
    $nombre=$row["nombre"].' '.$row["apellidos"];
    $correo=$row['correo'];
    $_SESSION['idEmp']=$idEmp;
    $_SESSION['nombre']=$nombre;
    $_SESSION['correo']=$correo;



}

?>