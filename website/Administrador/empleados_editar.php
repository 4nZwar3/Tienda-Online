<?php
// empleados_editar.php
//session_start();
include('validar_sesion.php');

require "Funciones/conecta.php";
$con=conecta();

// Obtener el ID del empleado desde la URL (si no existe, el valor por defecto es 0)
$id=isset($_GET['id']) ? $_GET['id'] : 0;

if($id>0){
    // Consulta para obtener los datos del empleado
    $sql="SELECT * FROM empleados WHERE id = $id";
    $res=$con->query($sql);

    if($res->num_rows > 0){
        // Obtener los datos del empleado
        $empleado=$res->fetch_assoc();
    }else{
        echo "Empleado no encontrado.";
        exit;
    }
}else{
    echo "ID de empleado no válido.";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edición de empleados</title>
    <script src="jquery-3.3.1.min.js"></script>
    <script>
$(document).ready(function() {
    let correoValido = true; // Variable para controlar si el correo fue validado correctamente

    $('#empleadoForm').on('submit', function(e) {
        e.preventDefault(); // Evita que el formulario se envíe hasta que se validen los campos

        let nombre = $('#nombre').val().trim();
        let apellidos = $('#apellidos').val().trim();
        let correo = $('#correo').val().trim();
        let rol = $('#rol').val();

        if (nombre == '' || apellidos == '' || correo == '' || rol == '0') {
            $('#mensajeCampos').html('Faltan campos por llenar.').show();
            setTimeout(function() {
                $('#mensajeCampos').hide();
            }, 5000);
        } else {
            this.submit(); // Si todo está bien, enviar el formulario
        }
    });

    // Verificar si el correo ya existe al salir del campo
    $('#correo').on('blur', function() {
        let correo = $(this).val().trim();
        let id = $('input[name="id"]').val(); // Obtenemos el ID del empleado actual

        if (correo != "") {
            $.ajax({
                url: 'verificar_correo.php',
                type: 'POST',
                data: { correo: correo, id: id }, // Enviamos el correo y el id
                success: function(response) {
                    if (response == '1') { // Si el correo ya existe y pertenece a otro usuario
                        $('#mensajeCorreo').html('El correo ' + correo + ' ya existe.').show();
                        correoValido = false;
                        setTimeout(function() {
                            $('#mensajeCorreo').hide(); // Oculta el mensaje después de 5 segundos
                        }, 5000);
                    } else {
                        correoValido = true; // El correo es válido
                    }
                }
            });
        } else {
            correoValido = true; // Restablecer el estado si el campo está vacío
        }
    });

    // Limpiar mensaje de error al modificar el correo
    $('#correo').on('focus', function() {
        if (!correoValido) {
            $(this).val(""); // Limpia el valor del campo si no era válido
            correoValido = true; // Reinicia el estado
        }
        $('#mensajeCorreo').hide(); // Oculta el mensaje al enfocar
    });
});

    </script>
</head>
<body>
    <h2>Edición de empleados</h2>

    <form id="empleadoForm" method="POST" action="empleados_actualizar.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $empleado['id']; ?>">

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $empleado['nombre']; ?>"><br>

        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" value="<?php echo $empleado['apellidos']; ?>"><br>

        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" value="<?php echo $empleado['correo']; ?>"><br>
        <div id="mensajeCorreo"></div>

        <label for="pass">Contraseña:</label>
        <input type="password" id="pass" name="pass"><br>

        <label for="rol">Rol:</label>
        <select id="rol" name="rol">
            <option value='0'>Seleccione rol</option>
            <option value="1" <?php if($empleado['rol']==1) echo 'selected'; ?>>Gerente</option>
            <option value="2" <?php if($empleado['rol']==2) echo 'selected'; ?>>Ejecutivo</option>
        </select><br>

        <label for="foto" accept="image/jpeg, image/png, image/jpg">Subir nueva foto</label>
        <input type="file" id="foto" name="foto" accept="image/jpeg, image/png, image/jpg"><br><br>

        <button type="submit">Actualizar empleado</button>
        <div id="mensajeCampos"></div>
    </form>

    <a href="empleados_lista.php">Regresar a la lista</a>
</body>
</html>
