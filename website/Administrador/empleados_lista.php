<?php
//empleados_lista.php

include('validar_sesion.php');

require "Funciones/conecta.php"; 
$con=conecta(); 
$sql="SELECT * FROM empleados WHERE eliminado=0"; 
$res=$con->query($sql); 
$num=$res->num_rows;

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
echo "<h2 id='contador'>Lista de empleados:($num)</h2><br>";
echo "<a class='crear-registro' href='empleados_alta.php'>Agregar nuevo empleado</a><br><br>";

echo "<table>";
echo "<tr><th>ID</th><th>Nombre</th><th>Apellidos</th><th>Correo</th><th>Rol</th><th>Ver detalle</th><th>Editar</th><th>Eliminar</th></tr>";

while($row=$res->fetch_array()){ //Va fila por fila
    $id=$row['id'];
    $nombre=$row['nombre'];
    $apellidos=$row['apellidos'];
    $correo=$row['correo'];
    $rol=$row['rol'];

    if($rol==1){
        $rol_text='Gerente';
    }elseif($rol==2){
        $rol_text='Ejecutivo';
    }else{
        $rol_text='Desconocido';
    }

    echo "<tr id='empleado_$id'>";
    echo "<td>$id</td>";
    echo "<td>$nombre</td>";
    echo "<td>$apellidos</td>";
    echo "<td>$correo</td>";
    echo "<td>$rol_text</td>";
    echo "<td><a href='#' onclick='detalleEmpleado($id)'>Ver detalle</a></td>";
    echo "<td><a href='empleados_editar.php?id=$id'>Editar</a></td>";
    echo "<td><a href='#' onclick='eliminarEmpleado($id)'>Eliminar</a></td>";
    echo "</tr>";
}
echo "</table>";
echo "<div id='detalleEmpleado'></div>";
echo "</div>";

echo '<br><a href="bienvenido.php">Regresar al Inicio</a><br><br>';


?>


<script>
var numEmpleados=<?php echo $num;?>;
function eliminarEmpleado(id){
    if(confirm('¿Confirma eliminar este empleado?')){ 
        $.ajax({
            url:'empleados_eliminar.php',
            type:'POST',
            data: {id:id},
            success:function(response){
                if(response==1){
                    alert('Empleado eliminado exitosamente');
                    $('#empleado_'+id).remove();
                    numEmpleados--;
                    $('#contador').text('Lista de empleados: (' +numEmpleados+ ')');
                }else{
                    alert('Error al eliminar el empleado');
                }
            },
        });
    }
}

function detalleEmpleado(id){
    if(confirm('¿Confirma ver detalle de este empleado?')){
        window.location.href = 'empleados_detalle.php?id=' + id;
    }
}
</script>

