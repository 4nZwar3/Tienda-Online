<?php
//empleados_detalle.php
include('validar_sesion.php');

require "Funciones/conecta.php";
$con=conecta();
$id=$_GET['id'];

$sql="SELECT id, nombre, apellidos, correo, pass, rol, archivo_nombre, archivo_file, eliminado FROM empleados WHERE id=$id"; // Consulta en la base de datos
$res=$con->query($sql);

if($res){
    $row=$res->fetch_row(); // Obtenemos los datos en un array
    if($row){
        // Se crean nuevas variables para tomar los datos y poder mostrarlos
        $id=$row[0];
        $nombre=$row[1];
        $apellidos=$row[2];
        $correo=$row[3];
        $pass=$row[4];
        $rol=$row[5];
        $archivo_nombre=$row[6]; // Nombre del archivo de la imagen
        $archivo_file=$row[7]; // Ruta del archivo de la imagen
        $eliminado=$row[8];
        $status=($eliminado==0) ? 'Activo' : 'Inactivo';

        if($rol==1){ // Convierte de numero a texto
            $rol_text='Gerente';
        }elseif($rol==2){
            $rol_text='Ejecutivo';
        }

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

        // Se muestran los detalles
        echo "<h3>Detalles del Empleado</h3>";
        echo "<table>";
        echo "<tr><th>Nombre</th><td>$nombre $apellidos</td></tr>";
        echo "<tr><th>Correo</th><td>$correo</td></tr>";
        echo "<tr><th>Rol</th><td>$rol_text</td></tr>";
        echo "<tr><th>Status</th><td>$status</td></tr>";
        
        // Mostrar la imagen
        echo "<tr><th>Foto</th><td>";
        if(!empty($archivo_file)){
            echo "<img src='archivos/$archivo_file' alt='Foto del empleado' style='max-width: 150px;'>";
        }else{
            echo 'No hay imagen disponible.';
        }
        echo "</td></tr>";

        echo "</table>";
        echo '<a href="empleados_lista.php">Regresar a la lista</a>';
    }else{
        echo "Empleado no encontrado.";
    }
}else{
    echo "Error en la consulta.";
}
?>
