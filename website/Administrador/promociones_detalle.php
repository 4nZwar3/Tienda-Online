<?php
// promociones_detalle.php
include('validar_sesion.php');
require "Funciones/conecta.php";
$con = conecta();
$id = $_GET['id'];

$sql = "SELECT id, nombre, archivo, eliminado 
        FROM promociones 
        WHERE id = $id"; // Consulta en la base de datos
$res = $con->query($sql);

if ($res) {
    $row = $res->fetch_row(); // Obtenemos los datos en un array
    if ($row) {
        // Asignación de datos a variables
        $id = $row[0];
        $nombre = $row[1];
        $archivo_file = $row[2]; // Ruta del archivo subido
        $eliminado = $row[3];
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

        // Mostrar detalles de la promoción
        echo "<h3>Detalles de la Promoción</h3>";
        echo "<table>";
        echo "<tr><th>Nombre</th><td>$nombre</td></tr>";
        echo "<tr><th>Status</th><td>$status</td></tr>";
        
        // Mostrar el archivo subido
        echo "<tr><th>Archivo</th><td>";
        if (!empty($archivo_file)) {
            $extension = pathinfo($archivo_file, PATHINFO_EXTENSION);
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'jfif', 'JPG'])) {
                // Mostrar imagen si el archivo es una imagen
                echo "<img src='archivos/$archivo_file' alt='Archivo de la promoción' style='max-width: 150px;'>";
            } elseif (in_array($extension, ['pdf'])) {
                // Mostrar enlace si el archivo es un PDF
                echo "<a href='archivos/$archivo_file' target='_blank'>Ver archivo PDF</a>";
            } else {
                echo 'Archivo no soportado.';
            }
        } else {
            echo 'No hay archivo disponible.';
        }
        echo "</td></tr>";

        echo "</table>";
        echo '<a href="promociones_lista.php">Regresar a la lista</a>';
    } else {
        echo "Promoción no encontrada.";
    }
} else {
    echo "Error en la consulta.";
}
?>
