<?php
// promociones_editar.php
include('validar_sesion.php');

require "Funciones/conecta.php";
$con = conecta();

// Obtener el ID de la promoción desde la URL (si no existe, el valor por defecto es 0)
$id = isset($_GET['id']) ? $_GET['id'] : 0;

if ($id > 0) {
    // Consulta para obtener los datos de la promoción
    $sql = "SELECT * FROM promociones WHERE id = $id";
    $res = $con->query($sql);

    if ($res->num_rows > 0) {
        // Obtener los datos de la promoción
        $promocion = $res->fetch_assoc();
    } else {
        echo "Promoción no encontrada.";
        exit;
    }
} else {
    echo "ID de promoción no válido.";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edición de promociones</title>
    <script src="jquery-3.3.1.min.js"></script>
    <script>
    $(document).ready(function(){
        $('#promocionForm').on('submit', function(e){
            e.preventDefault(); // Evita que el formulario se envíe hasta que se validen los campos

            let nombre = $('#nombre').val().trim();
            let archivo = $('#archivo').val().trim();

            if (nombre == '') {
                $('#mensajeCampos').html('Faltan campos por llenar.').show();
                setTimeout(function(){
                    $('#mensajeCampos').hide();
                }, 5000);
            } else {
                this.submit(); // Si todo está bien, enviar el formulario
            }
        });
    });
    </script>
</head>
<body>
    <h2>Edición de promociones</h2>

    <form id="promocionForm" method="POST" action="promociones_actualizar.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $promocion['id']; ?>">

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $promocion['nombre']; ?>"><br>

        <label for="archivo">Subir nuevo archivo (opcional):</label>
        <input type="file" id="archivo" name="archivo" accept="image/jpeg, image/png, image/jpg, application/pdf"><br><br>

        <button type="submit">Actualizar promoción</button>
        <div id="mensajeCampos"></div>
    </form>

    <a href="promociones_lista.php">Regresar a la lista</a>
</body>
</html>
