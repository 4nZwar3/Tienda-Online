<?php
//empleados_alta.php
include('validar_sesion.php');

require "Funciones/conecta.php";
$con = conecta();

// Verificar si la conexión es exitosa
if (!$con) {
    die("Error de conexión: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $pass = md5($_POST['pass']);  // Encriptar la contraseña
    $rol = $_POST['rol'];
    $res = false; // Inicializar la variable para evitar errores

    // Validación de campos obligatorios
    if (!empty($nombre) && !empty($apellidos) && !empty($correo) && !empty($pass) && !empty($rol)) {
        $file_name = $_FILES['foto']['name'] ?? '';
        $file_tmp = $_FILES['foto']['tmp_name'] ?? '';
        $nuevoFile = ''; // Inicializar el nombre del archivo encriptado para la base de datos

        // Procesamiento de la imagen si se ha subido una
        if ($file_name != "") {
            $cadena = explode(".", $file_name);
            $ext = end($cadena);
            $file_enc = md5_file($file_tmp);
            $nuevoFile = "$file_enc.$ext";
            $dir = "archivos/";
            $destino = $dir . basename($nuevoFile);

            // Intentar copiar el archivo; mostrar error si falla
            if (!copy($file_tmp, $destino)) {
                $mensajeCampos = "Error al cargar la imagen.";
                echo $mensajeCampos;
            }
        }

        // Ejecutar la consulta SQL, incluyendo o no el archivo, según su disponibilidad
        $sql = "INSERT INTO empleados (nombre, apellidos, correo, pass, rol, archivo_nombre, archivo_file, eliminado) 
                VALUES ('$nombre', '$apellidos', '$correo', '$pass', '$rol', '$file_name', '$nuevoFile', 0)";
        $res = $con->query($sql);

        // Verificar el resultado de la consulta
        if ($res) {
            echo "<script>alert('Registro completo'); window.location.href = 'empleados_lista.php';</script>";
        } else {
            echo "<script>alert('Error al registrar el empleado: " . $con->error . "'); window.location.href = 'empleados_lista.php';</script>";
        }
        
    } else {
        $mensajeCampos = "Faltan campos por llenar";
        echo $mensajeCampos;
    }
}
?>


<!DOCTYPE html>
<head>
    <title>Alta de empleados</title>
    <script src="jquery-3.3.1.min.js"></script>
</head>
<body>
    <h2>Alta de empleados</h2>

    <form id="empleadoForm" method="POST" enctype="multipart/form-data">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre"><br>
        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos"><br>
        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo"><br>
        <div id="mensajeCorreo"></div>  
        <label for="pass">Contraseña:</label>
        <input type="password" id="pass" name="pass"><br>
        <label for="rol">Rol:</label>
        <select id="rol" name="rol">
            <option value='0'>Seleccione rol</option>
            <option value="1">Gerente</option>
            <option value="2">Ejecutivo</option>
        </select><br>
        <label for="foto">Agregar foto: </label>
        <input type="file" id="foto" name="foto" accept="image/jpeg, image/png, image/jpg"><br><br>

        
        <button type="submit">Agregar empleado</button>
        <div id="mensajeCampos"><?php echo $mensajeCampos ?? ''; ?></div>
        <div id="mensaje"></div><br><br>
    </form>
    <a href="empleados_lista.php">Regresar a la lista</a>
    <script>
        $('#correo').on('blur', function(){ // Verificar si el correo ya existe al salir del campo
            let correo=$(this).val().trim();
            if (correo!=""){
                $.ajax({
                    url: 'verificar_correo.php',
                    type: 'POST',
                    data: {correo:correo},
                    success: function(response){
                        if(response=='1'){ // Si el correo ya existe, muestra el mensaje de error
                            $('#mensajeCorreo').html('El correo ' +correo+ ' ya existe.').show();
                            $('#correo').val(''); // Borra el valor del campo de correo
                            setTimeout(function(){
                                $('#mensajeCorreo').hide(); // Limpia el mensaje de error
                            }, 5000); // Oculta el mensaje después de 5 segundos
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>