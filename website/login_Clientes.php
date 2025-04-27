<?php
session_name("sesion_cliente");
session_start();
// Si ya inició sesión, se redirige a home_Clientes.php
if (isset($_SESSION['nombre'])) {
    header('Location: home_Clientes.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <script src="jquery-3.3.1.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #F5F5F5;
        }

        .login-form {
            text-align: center;
            padding: 40px;
            background-color: #0C969C;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            color: white;
            width: 350px;
        }

        .login-form h2 {
            margin-bottom: 20px;
        }

        .login-form label {
            display: block;
            text-align: left;
            margin: 5px 0;
        }

        .login-form input {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: none;
            border-radius: 5px;
            outline: none;
            display: block;
        }

        .login-form button {
            background-color: #0A7075;
            border: none;
            color: white;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }

        #mensaje {
            margin-top: 10px;
            color: red;
        }

        .back-button {
            background-color: #0A7075;
            text-decoration: none;
            color: white;
            padding: 10px;
            border-radius: 5px;
            display: block;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="login-form">
    <h2>Iniciar Sesión</h2>
    <form id="loginForm">
        <label for="correo">Correo:</label>
        <input type="email" name="correo" id="correo" required>
        <label for="pass">Contraseña:</label>
        <input type="password" name="pass" id="pass" required>
        <div id="mensaje"></div>
        <button type="button" onclick="validarFormulario()">Iniciar Sesión</button>
    </form>

    <h2>Registrar Nuevo Usuario</h2>
    <form action="procesar_Registro.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required>
        <label for="email">Correo:</label>
        <input type="email" name="email" id="email" required>
        <label for="pass">Contraseña:</label>
        <input type="password" name="pass" id="pass" required>
        <button type="submit">Registrar</button>
    </form>

    <a href="index_Clientes.php" class="back-button">Regresar</a>
</div>

<script>
    function validarFormulario(){
        var correo = $("#correo").val();
        var pass = $("#pass").val();

        if(correo === "" || pass === ""){
            $("#mensaje").html("Faltan campos por llenar").css("color", "red");
        } else {
            $.ajax({
                url: "verificar_Clientes.php",
                method: "POST",
                data: {
                    correo: correo,
                    pass: pass
                },
                success: function(response){
                    if(response.trim() === "existe"){
                        window.location.href = "index_Clientes.php";
                    } else {
                        $("#mensaje").html(response).css("color", "red");
                    }
                },
                error: function(){
                    $("#mensaje").html("Error al procesar la solicitud.").css("color", "red");
                }
            });
        }
    }
</script>

</body>
</html>
