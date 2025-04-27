<?php
//funciones/conecta.php
define("HOST",'db');
define("DB",'proyecto');
define("USER_DB",'root');
define("PASS_DB",'rootpassword');

function conecta(){
    $con=new mysqli(HOST, USER_DB, PASS_DB, DB); //conexion a base de datos
    return $con;
}
?>
