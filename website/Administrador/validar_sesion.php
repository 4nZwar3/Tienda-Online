<?php
session_name("sesion_admin");
session_start();
if (!isset($_SESSION['nombre'])) {
    echo "Por favor, inicia sesión primero.";
    echo '<br><br>';
    echo '<a href="index.php">Iniciar sesión</a>';
    exit;
}
?>