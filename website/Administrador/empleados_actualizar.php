<?php
// empleados_actualizar.php
include('validar_sesion.php');

require "Funciones/conecta.php";
$con=conecta();

$id=$_POST['id'];
$nombre=$_POST['nombre'];
$apellidos=$_POST['apellidos'];
$correo=$_POST['correo'];
$pass=!empty($_POST['pass']) ? md5($_POST['pass']) : '';
$rol=$_POST['rol'];

// Verifica que los campos no estén vacíos
if(!empty($nombre) && !empty($apellidos) && !empty($correo) && !empty($rol)){
    // Verificar si se subió una nueva imagen
    $file_name=isset($_FILES['foto']['name']) ? $_FILES['foto']['name'] : '';
    $file_tmp=isset($_FILES['foto']['tmp_name']) ? $_FILES['foto']['tmp_name'] : '';

    // Si no se subió una nueva imagen, no actualizar la imagen
    $image_clause = '';
    if(!empty($file_name)){
        $cadena=explode(".", $file_name);
        $ext=end($cadena); // Obtener la extensión del archivo
        $file_enc=md5_file($file_tmp); // Nombre encriptado
        $nuevoFile="$file_enc.$ext"; // Nombre final del archivo
        $dir="archivos/"; // Carpeta de destino
        $destino=$dir . $nuevoFile;

        // Mover el archivo a la carpeta destino
        if(move_uploaded_file($file_tmp, $destino)){
            // Preparar la actualización de la imagen
            $image_clause=", archivo_nombre='$file_name', archivo_file='$nuevoFile'";
        }else{
            echo "<p>Error al subir la imagen.</p>";
            exit;
        }
    }
    if($pass){
        // Actualizar incluyendo la contraseña si fue modificada
        $sql="UPDATE empleados SET nombre='$nombre', apellidos='$apellidos', correo='$correo', pass='$pass', rol='$rol' $pass $image_clause WHERE id='$id'";
    }else{
        // Actualizar sin cambiar la contraseña
        $sql="UPDATE empleados SET nombre='$nombre', apellidos='$apellidos', correo='$correo', rol='$rol' $pass $image_clause WHERE id='$id'";
    }

    $res=$con->query($sql);

    if($res){
        echo "Registro actualizado.";
        echo "<script>
                setTimeout(function(){
                    window.location.href='empleados_lista.php';
                }, 5000);
              </script>";
    }else{
        echo "Error al actualizar el empleado.";
    }
}else{
    echo "Faltan campos por llenar.";
}
?>