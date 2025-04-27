<?php
include('validar_sesion.php');

require "Funciones/conecta.php"; 
$con = conecta(); 
$sql = "SELECT * FROM promociones WHERE eliminado=0"; 
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
echo "<h2 id='contador'>Lista de promociones: ($num)</h2><br>";
echo "<a class='crear-registro' href='promociones_alta.php'>Agregar nueva promoción</a><br><br>";

echo "<table>";
echo "<tr><th>ID</th><th>Nombre</th><th>Imagen</th><th>Ver Detalle</th><th>Editar</th><th>Eliminar</th></tr>";

while ($row = $res->fetch_array()) { // Va fila por fila
    $id = $row['id'];
    $nombre = $row['nombre'];
    $archivo = $row['archivo'];
    $imagenPath = "archivos/" . $archivo; // Asumiendo que las imágenes están almacenadas en la carpeta "archivos"

    echo "<tr id='promocion_$id'>";
    echo "<td>$id</td>";
    echo "<td>$nombre</td>";
    echo "<td><img src='$imagenPath' alt='$nombre' width='100'></td>";
    echo "<td><a href='promociones_detalle.php?id=$id'>Ver detalle</a></td>";
    echo "<td><a href='promociones_editar.php?id=$id'>Editar</a></td>";
    echo "<td><a href='#' onclick='eliminarPromocion($id)'>Eliminar</a></td>";
    echo "</tr>";
}
echo "</table>";
echo "<div id='detallePromocion'></div>";
echo "</div>";

echo '<br><a href="bienvenido.php">Regresar al Inicio</a><br><br>';
?>

<script>
var numPromociones = <?php echo $num; ?>;
function eliminarPromocion(id) {
    if (confirm('¿Confirma eliminar esta promoción?')) { 
        $.ajax({
            url: 'promociones_eliminar.php',
            type: 'POST',
            data: {id: id},
            success: function(response) {
                if (response == 1) {
                    alert('Promoción eliminada exitosamente');
                    $('#promocion_' + id).remove();
                    numPromociones--;
                    $('#contador').text('Lista de promociones: (' + numPromociones + ')');
                } else {
                    alert('Error al eliminar la promoción');
                }
            },
        });
    }
}
</script>
