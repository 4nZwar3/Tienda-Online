<?php
session_name("sesion_cliente");
session_start();
session_destroy();
header("Location: index_Clientes.php");

?>