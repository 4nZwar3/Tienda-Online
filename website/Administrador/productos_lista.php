<?php
include('validar_sesion.php');

require "Funciones/conecta.php"; 
$con = conecta(); 
$sql = "SELECT * FROM productos WHERE eliminado=0"; 
$res = $con->query($sql); 
$num = $res->num_rows;

echo "<style>
    .container {
        max-width: flex;    
    }
    .crear-registro:hover {
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #6BA3BE;
    }
    th, td {
        text-align: left;
        border-bottom: 1px solid black;
    }
    th {
        background-color: #0A7075;
        color: white;
    }
</style>";

echo '<script src="jquery-3.3.1.min.js"></script>';

echo "<div class='container'>";
echo "<h2 id='contador'>Lista de productos: ($num)</h2><br>";
echo "<a class='crear-registro' href='productos_alta.php'>Agregar nuevo producto</a><br><br>";

echo "<table>";
echo "<tr><th>ID</th><th>Nombre</th><th>Código</th><th>Descripción</th><th>Costo</th><th>Stock</th><th>Archivo</th><th>Editar</th><th>Eliminar</th></tr>";

while ($row = $res->fetch_array()) { // Va fila por fila
    $id = $row['id'];
    $nombre = $row['nombre'];
    $codigo = $row['codigo'];
    $descripcion = $row['descripcion'];
    $costo = $row['costo'];
    $stock = $row['stock'];
    $archivo = $row['archivo'];

    echo "<tr id='producto_$id'>";
    echo "<td>$id</td>";
    echo "<td>$nombre</td>";
    echo "<td>$codigo</td>";
    echo "<td>$descripcion</td>";
    echo "<td>$costo</td>";
    echo "<td>$stock</td>";
    echo "<td><a href='productos_detalle.php?id=$id'>Ver detalle</a></td>";
    echo "<td><a href='productos_editar.php?id=$id'>Editar</a></td>";
    echo "<td><a href='#' onclick='eliminarProducto($id)'>Eliminar</a></td>";
    echo "</tr>";
}
echo "</table>";
echo "<div id='detalleProducto'></div>";
echo "</div>";

echo '<br><a href="bienvenido.php">Regresar al Inicio</a><br><br>';
?>

<script>
var numProductos = <?php echo $num; ?>;
function eliminarProducto(id) {
    if (confirm('¿Confirma eliminar este producto?')) { 
        $.ajax({
            url: 'productos_eliminar.php',
            type: 'POST',
            data: {id: id},
            success: function(response) {
                if (response == 1) {
                    alert('Producto eliminado exitosamente');
                    $('#producto_' + id).remove();
                    numProductos--;
                    $('#contador').text('Lista de productos: (' + numProductos + ')');
                } else {
                    alert('Error al eliminar el producto');
                }
            },
        });
    }
}
</script>
