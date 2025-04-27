<?php
// productos_editar.php
include('validar_sesion.php');

require "Funciones/conecta.php";
$con = conecta();

// Obtener el ID del producto desde la URL (si no existe, el valor por defecto es 0)
$id = isset($_GET['id']) ? $_GET['id'] : 0;

if ($id > 0) {
    // Consulta para obtener los datos del producto
    $sql = "SELECT * FROM productos WHERE id = $id";
    $res = $con->query($sql);

    if ($res->num_rows > 0) {
        // Obtener los datos del producto
        $producto = $res->fetch_assoc();
    } else {
        echo "Producto no encontrado.";
        exit;
    }
} else {
    echo "ID de producto no válido.";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edición de productos</title>
    <script src="jquery-3.3.1.min.js"></script>
    <script>
    $(document).ready(function(){
        $('#productoForm').on('submit', function(e){
            e.preventDefault(); // Evita que el formulario se envíe hasta que se validen los campos

            let nombre = $('#nombre').val().trim();
            let codigo = $('#codigo').val().trim();
            let descripcion = $('#descripcion').val().trim();
            let costo = $('#costo').val().trim();
            let stock = $('#stock').val().trim();

            if (nombre == '' || codigo == '' || descripcion == '' || costo == '' || stock == '') {
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
    <h2>Edición de productos</h2>

    <form id="productoForm" method="POST" action="productos_actualizar.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $producto['nombre']; ?>"><br>

        <label for="codigo">Código:</label>
        <input type="text" id="codigo" name="codigo" value="<?php echo $producto['codigo']; ?>"><br>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion"><?php echo $producto['descripcion']; ?></textarea><br>

        <label for="costo">Costo:</label>
        <input type="number" id="costo" name="costo" value="<?php echo $producto['costo']; ?>" step="0.01" min="0"><br>

        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" value="<?php echo $producto['stock']; ?>" min="0"><br>

        <label for="archivo">Subir nuevo archivo:</label>
        <input type="file" id="archivo" name="archivo" accept="image/jpeg, image/png, image/jpg, application/pdf"><br><br>

        <button type="submit">Actualizar producto</button>
        <div id="mensajeCampos"></div>
    </form>

    <a href="productos_lista.php">Regresar a la lista</a>
</body>
</html>
