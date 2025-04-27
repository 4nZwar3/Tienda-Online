<?php
// promociones_alta.php
include('validar_sesion.php');
require "Funciones/conecta.php";
$con = conecta();

// Verificar si la conexión es exitosa
if (!$con) {
    die("Error de conexión: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $mensajeCampos = "";

    $res = false; // Inicializar la variable para evitar errores

    // Validación de campos obligatorios
    if (!empty($nombre)) {
        $file_name = $_FILES['archivo']['name'] ?? '';
        $file_tmp = $_FILES['archivo']['tmp_name'] ?? '';
        $nuevoFile = ''; // Inicializar el nombre del archivo encriptado para la base de datos

        // Procesamiento del archivo si se ha subido uno
        if ($file_name != "") {
            $cadena = explode(".", $file_name);
            $ext = end($cadena);
            $file_enc = md5_file($file_tmp);
            $nuevoFile = "$file_enc.$ext";
            $dir = "archivos/";
            $destino = $dir . basename($nuevoFile);

            // Intentar copiar el archivo; mostrar error si falla
            if (!copy($file_tmp, $destino)) {
                $mensajeCampos = "Error al cargar el archivo.";
                echo $mensajeCampos;
            }
        }

        // Ejecutar la consulta SQL, incluyendo o no el archivo, según su disponibilidad
        $sql = "INSERT INTO promociones (nombre, archivo, eliminado) 
                VALUES ('$nombre', '$nuevoFile', 0)";
        $res = $con->query($sql);

        // Verificar el resultado de la consulta
        if ($res) {
            echo "<script>alert('Promoción agregada exitosamente.'); window.location.href = 'promociones_lista.php';</script>";
        } else {
            echo "<script>alert('Error al registrar la promoción: " . $con->error . "'); window.location.href = 'promociones_lista.php';</script>";
        }
        
    } else {
        $mensajeCampos = "Todos los campos son obligatorios.";
        echo $mensajeCampos;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Alta de Promociones</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="jquery-3.3.1.min.js"></script>
</head>
<body>
    <h2>Alta de Promociones</h2>

    <form id="promocionForm" method="POST" enctype="multipart/form-data">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>
        
        <label for="archivo">Agregar archivo (imagen, PDF, etc.): </label>
        <input type="file" id="archivo" name="archivo" accept="image/jpeg, image/png, application/pdf" required><br><br>
        
        <button type="submit">Agregar Promoción</button>
        <div id="mensajeCampos"><?php echo $mensajeCampos ?? ''; ?></div>
    </form>
    <a href="promociones_lista.php">Regresar a la lista</a>

    <script>
        // Validaciones adicionales si es necesario
        $('#nombre').on('blur', function() {
            let nombre = $(this).val().trim();
            if (nombre != "") {
                // Aquí se podrían agregar validaciones AJAX si es necesario
            }
        });
    </script>
</body>
</html>
