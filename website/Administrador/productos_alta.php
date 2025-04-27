<?php
// productos_alta.php
include('validar_sesion.php');
require "Funciones/conecta.php";
$con = conecta();

// Verificar si la conexión es exitosa
if (!$con) {
    die("Error de conexión: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    $descripcion = $_POST['descripcion'];
    $costo = floatval($_POST['costo']);
    $stock = intval($_POST['stock']);
    $mensajeCampos = "";

    $res = false; // Inicializar la variable para evitar errores

    // Validación de campos obligatorios
    if (!empty($nombre) && !empty($codigo) && !empty($descripcion) && $costo > 0 && $stock >= 0) {
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
        $sql = "INSERT INTO productos (nombre, codigo, descripcion, costo, stock, archivo_n, archivo, eliminado) 
                VALUES ('$nombre', '$codigo', '$descripcion', $costo, $stock, '$file_name', '$nuevoFile', 0)";
        $res = $con->query($sql);

        // Verificar el resultado de la consulta
        if ($res) {
            echo "<script>alert('Producto agregado exitosamente.'); window.location.href = 'productos_lista.php';</script>";
        } else {
            echo "<script>alert('Error al registrar el producto: " . $con->error . "'); window.location.href = 'productos_lista.php';</script>";
        }
        
    } else {
        $mensajeCampos = "Todos los campos son obligatorios y deben ser válidos.";
        echo $mensajeCampos;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Alta de Productos</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="jquery-3.3.1.min.js"></script>
</head>
<body>
    <h2>Alta de Productos</h2>

    <form id="productoForm" method="POST" enctype="multipart/form-data">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>
        
        <label for="codigo">Código:</label>
        <input type="text" id="codigo" name="codigo" required><br>
        
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" rows="4" required></textarea><br>
        
        <label for="costo">Costo:</label>
        <input type="number" id="costo" name="costo" step="0.01" min="0.01" required><br>
        
        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" min="0" required><br>
        
        <label for="archivo">Agregar archivo: </label>
        <input type="file" id="archivo" name="archivo" accept="image/jpeg, image/png, application/pdf" required><br><br>
        
        <button type="submit">Agregar Producto</button>
        <div id="mensajeCampos"><?php echo $mensajeCampos ?? ''; ?></div>
    </form>
    <a href="productos_lista.php">Regresar a la lista</a>

    <script>
        // Validaciones adicionales en el lado del cliente si es necesario
        $('#codigo').on('blur', function() {
            let codigo = $(this).val().trim();
            if (codigo != "") {
                $.ajax({
                    url: 'verificar_codigo.php',
                    type: 'POST',
                    data: {codigo: codigo},
                    success: function(response) {
                        if (response == '1') {
                            alert('El código ' + codigo + ' ya existe. Por favor, elige otro.');
                            $('#codigo').val('');
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>
