<?php
// productos_detalle.php
include('validar_sesion.php');

require "Funciones/conecta.php";
$con = conecta();
$id = $_GET['id'];

$sql = "SELECT id, nombre, codigo, descripcion, costo, stock, archivo_n, archivo, eliminado 
        FROM productos 
        WHERE id = $id"; // Consulta en la base de datos
$res = $con->query($sql);

if ($res) {
    $row = $res->fetch_row(); // Obtenemos los datos en un array
    if ($row) {
        // Asignación de datos a variables
        $id = $row[0];
        $nombre = $row[1];
        $codigo = $row[2];
        $descripcion = $row[3];
        $costo = $row[4];
        $stock = $row[5];
        $archivo_nombre = $row[6]; // Nombre del archivo subido
        $archivo_file = $row[7]; // Ruta del archivo subido
        $eliminado = $row[8];
        $status = ($eliminado == 0) ? 'Activo' : 'Inactivo';

        echo "<style>
            table {
                width: 100%;
                border-collapse: collapse;
                margin: 20px 0;
            }
            th, td {
                border: 1px solid black;
                padding: 8px;
                text-align: left;
            }
            th {
                background-color: #6BA3BE;
                color: white;
            }
        </style>";

        // Mostrar detalles del producto
        echo "<h3>Detalles del Producto</h3>";
        echo "<table>";
        echo "<tr><th>Nombre</th><td>$nombre</td></tr>";
        echo "<tr><th>Código</th><td>$codigo</td></tr>";
        echo "<tr><th>Descripción</th><td>$descripcion</td></tr>";
        echo "<tr><th>Costo</th><td>\$$costo</td></tr>";
        echo "<tr><th>Stock</th><td>$stock unidades</td></tr>";
        echo "<tr><th>Status</th><td>$status</td></tr>";
        
        // Mostrar el archivo subido
        echo "<tr><th>Archivo</th><td>";
        if (!empty($archivo_file)) {
            $extension = pathinfo($archivo_file, PATHINFO_EXTENSION);
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'jfif'])) {
                // Mostrar imagen si el archivo es una imagen
                echo "<img src='archivos/$archivo_file' alt='Archivo del producto' style='max-width: 150px;'>";
            }
        } else {
            echo 'No hay archivo disponible.';
        }
        echo "</td></tr>";

        echo "</table>";
        echo '<a href="productos_lista.php">Regresar a la lista</a>';
    } else {
        echo "Producto no encontrado.";
    }
} else {
    echo "Error en la consulta.";
}
?>
