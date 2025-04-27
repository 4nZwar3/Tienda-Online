<?php
session_name("sesion_admin");
session_start();
//Si ya inició sesión, se redirige a bienvenido.php
if (isset($_SESSION['nombre'])) {
    header('Location: bienvenido.php');
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
            padding: 50px;
            background-color: #0C969C;
            width: 400px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            color: white;
        }

        .login-form h2 {
            margin-bottom: 20px;
        }

        .login-form input {
            margin-bottom: 10px;
            padding: 10px;
            width: 100%;
            border: none;
            border-radius: 5px;
            outline: none;
        }

        .login-form button {
            background-color: #0A7075;
            border: none;
            color: white;
            padding: 10px 25px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        #mensaje {
            margin-top: 10px;
            color: red;
        }
    </style>
</head>
<body>

<div class="login-form">
    <h2>Iniciar Sesión</h2>
    <form id="loginForm">
        <label>Correo:</label>
        <input type="email" name="correo" id="correo" required><br>
        <label>Contraseña:</label>
        <input type="password" name="pass" id="pass" required><br>
        <div id="mensaje"></div><br>
        <button type="button" onclick="validarFormulario()">Iniciar Sesión</button> 
    </form>
</div>

<script>
    function validarFormulario(){
        var correo = $("#correo").val();
        var pass = $("#pass").val();

        if(correo === "" || pass === ""){
            $("#mensaje").html("Faltan campos por llenar").css("color", "red");
        } else {
            $.ajax({
                url: "verificar_usuario.php",
                method: "POST",
                data: {
                    correo: correo,
                    pass: pass
                },
                success: function(response){
                    if(response.trim() === "existe"){
                        window.location.href = "bienvenido.php";
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
