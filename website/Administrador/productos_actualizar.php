<?php
// productos_actualizar.php
include('validar_sesion.php');

require "Funciones/conecta.php";
$con = conecta();

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$codigo = $_POST['codigo'];
$descripcion = $_POST['descripcion'];
$costo = $_POST['costo'];
$stock = $_POST['stock'];

// Verifica que los campos obligatorios no estén vacíos
if (!empty($nombre) && !empty($codigo) && !empty($descripcion) && !empty($costo) && !empty($stock)) {
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

    // Actualizar los datos del producto
    $sql = "UPDATE productos 
            SET nombre='$nombre', codigo='$codigo', descripcion='$descripcion', costo='$costo', stock='$stock' $file_clause 
            WHERE id='$id'";

    $res = $con->query($sql);

    if ($res) {
        echo "<script>
                alert('Producto actualizado correctamente.');
                window.location.href='productos_lista.php';
              </script>";
    } else {
        echo "Error al actualizar el producto.";
    }
} else {
    echo "Faltan campos por llenar.";
}
?>
