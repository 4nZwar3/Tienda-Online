<?php
// promociones_actualizar.php
include('validar_sesion.php');

require "Funciones/conecta.php";
$con = conecta();

$id = $_POST['id'];
$nombre = $_POST['nombre'];

// Verifica que los campos obligatorios no estén vacíos
if (!empty($nombre)) {
    // Verificar si se subió un nuevo archivo
    $file_name = isset($_FILES['archivo']['name']) ? $_FILES['archivo']['name'] : '';
    $file_tmp = isset($_FILES['archivo']['tmp_name']) ? $_FILES['archivo']['tmp_name'] : '';

    // Si no se subió un nuevo archivo, no actualizar el archivo
    $file_clause = '';
    if (!empty($file_name)) {
        $cadena = explode(".", $file_name);
        $ext = end($cadena); // Obtener la extensión del archivo
        $file_enc = md5_file($file_tmp); // Nombre encriptado
        $nuevoFile = "$file_enc.$ext"; // Nombre final del archivo
        $dir = "archivos/"; // Carpeta de destino
        $destino = $dir . $nuevoFile;

        // Mover el archivo a la carpeta destino
        if (move_uploaded_file($file_tmp, $destino)) {
            // Preparar la cláusula para actualizar el archivo
            $file_clause = ", archivo_n='$file_name', archivo='$nuevoFile'";
        } else {
            echo "<p>Error al subir el archivo.</p>";
            exit;
        }
    }

    // Actualizar los datos de la promoción
    $sql = "UPDATE promociones 
            SET nombre='$nombre' $file_clause
            WHERE id='$id'";

    if ($con->query($sql)) {
        echo "<script>
                alert('Promoción actualizada correctamente.');
                window.location.href='promociones_lista.php';
              </script>";
    } else {
        echo "Error al actualizar la promoción: " . $con->error;
    }
} else {
    echo "Faltan campos por llenar.";
}
?>
