<?php
session_name("sesion_admin");
session_start();
session_destroy();
header("Location: index.php");

?>