<?php
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
    $pass = md5($_POST['pass']); // Encriptar la contraseña

    // Validación de campos obligatorios
    if (!empty($nombre) && !empty($apellidos) && !empty($correo) && !empty($pass)) {
        $sql = "INSERT INTO clientes (nombre, apellidos, correo, pass, eliminado) 
                VALUES ('$nombre', '$apellidos', '$correo', '$pass', 0)";
        $res = $con->query($sql);

        // Verificar el resultado de la consulta
        if ($res) {
            echo "<script>alert('Cliente registrado exitosamente'); window.location.href = 'login_Clientes.php';</script>";
        } else {
            echo "<script>alert('Error al registrar el cliente: " . $con->error . "');</script>";
        }
    } else {
        $mensajeCampos = "Faltan campos por llenar";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Clientes</title>
    <script src="jquery-3.3.1.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #F5F5F5;
        }

        h2 {
            text-align: center;
        }

        form {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #0A7075;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #086064;
        }

        #mensajeCampos {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>

<h2>Alta de Clientes</h2>

<form id="clienteForm" method="POST">
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required><br>
    
    <label for="apellidos">Apellidos:</label>
    <input type="text" id="apellidos" name="apellidos" required><br>
    
    <label for="correo">Correo:</label>
    <input type="email" id="correo" name="correo" required><br>
    <div id="mensajeCorreo"></div>  
    
    <label for="pass">Contraseña:</label>
    <input type="password" id="pass" name="pass" required><br>

    <button type="submit">Registrar Cliente</button>
    <div id="mensajeCampos"><?php echo $mensajeCampos ?? ''; ?></div>
</form>

<script>
    $('#correo').on('blur', function() {
        let correo = $(this).val().trim();
        if (correo != "") {
            $.ajax({
                url: 'verificar_correo_Clientes.php',
                type: 'POST',
                data: { correo: correo },
                success: function(response) {
                    if (response == '1') {
                        $('#mensajeCorreo').html('El correo ' + correo + ' ya existe.').show();
                        $('#correo').val('');
                        setTimeout(function() {
                            $('#mensajeCorreo').hide();
                        }, 5000);
                    }
                }
            });
        }
    });
</script>

</body>
</html>
