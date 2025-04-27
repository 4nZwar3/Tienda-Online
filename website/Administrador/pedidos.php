<?php
// pedidos.php

session_name("sesion_admin");
session_start();
include 'Funciones/conecta.php';

$conexion = conecta();

if (!$conexion) {
    die("Error en la conexión a la base de datos");
}

$mesSeleccionado = isset($_POST['mes']) ? $_POST['mes'] : '';

echo "<style>
    .container {
        max-width: flex;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #6BA3BE;
    }
    th, td {
        text-align: left;
        border-bottom: 1px solid black;
        padding: 8px;
    }
    th {
        background-color: #0A7075;
        color: white;
    }
    a {
        color: #0A7075;
        font-weight: bold;
        text-decoration: none;
    }
    a:hover {
        text-decoration: underline;
    }
    #filtro-mes {
        padding: 6px;
        margin-bottom: 15px;
        background-color: #0A7075;
        color: white;
        border: none;
        border-radius: 5px;
    }
</style>";

echo '<script src="jquery-3.3.1.min.js"></script>';

echo "<div class='container'>";
echo "<h2 id='contador'>Lista de pedidos</h2><br>";

echo "<form id='form-filtro' method='POST'>";
echo "<label for='mes'>Filtrar por mes: </label>";
echo "<select id='filtro-mes' name='mes' onchange='this.form.submit()'>
    <option value=''>-- Todos --</option>
    <option value='01' " . ($mesSeleccionado == '01' ? 'selected' : '') . ">Enero</option>
    <option value='02' " . ($mesSeleccionado == '02' ? 'selected' : '') . ">Febrero</option>
    <option value='03' " . ($mesSeleccionado == '03' ? 'selected' : '') . ">Marzo</option>
    <option value='04' " . ($mesSeleccionado == '04' ? 'selected' : '') . ">Abril</option>
    <option value='05' " . ($mesSeleccionado == '05' ? 'selected' : '') . ">Mayo</option>
    <option value='06' " . ($mesSeleccionado == '06' ? 'selected' : '') . ">Junio</option>
    <option value='07' " . ($mesSeleccionado == '07' ? 'selected' : '') . ">Julio</option>
    <option value='08' " . ($mesSeleccionado == '08' ? 'selected' : '') . ">Agosto</option>
    <option value='09' " . ($mesSeleccionado == '09' ? 'selected' : '') . ">Septiembre</option>
    <option value='10' " . ($mesSeleccionado == '10' ? 'selected' : '') . ">Octubre</option>
    <option value='11' " . ($mesSeleccionado == '11' ? 'selected' : '') . ">Noviembre</option>
    <option value='12' " . ($mesSeleccionado == '12' ? 'selected' : '') . ">Diciembre</option>
</select>";
echo "</form><br>";

echo "<div id='tabla-pedidos'>";

// Consulta de pedidos según mes seleccionado
if ($mesSeleccionado != '') {
    $query = "SELECT id, cliente_id, total, fecha, status FROM pedidos WHERE MONTH(fecha) = '$mesSeleccionado' ORDER BY fecha DESC";
} else {
    $query = "SELECT id, cliente_id, total, fecha, status FROM pedidos ORDER BY fecha DESC";
}

$res = $conexion->query($query);

if ($res && $res->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID Pedido</th><th>ID Cliente</th><th>Total</th><th>Fecha</th><th>Estatus</th><th>Detalle</th></tr>";

    while ($pedido = $res->fetch_assoc()) {
        $id = $pedido['id'];
        $cliente_id = $pedido['cliente_id'];
        $total = number_format($pedido['total'], 2);
        $fecha = $pedido['fecha'];
        $status = $pedido['status'];
        $estatus_texto = ($status == 1) ? 'Cerrado' : 'Abierto';

        echo "<tr>";
        echo "<td>$id</td>";
        echo "<td>$cliente_id</td>";
        echo "<td>$$total</td>";
        echo "<td>$fecha</td>";
        echo "<td>$estatus_texto</td>";
        echo "<td><a href='detalle_pedido.php?id=$id'>Ver Detalle</a></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>No hay pedidos registrados" . ($mesSeleccionado ? " para este mes." : ".") . "</p>";
}

echo "</div>"; // Cierra tabla-pedidos
echo "<br><a href='index.php'>Regresar</a><br><br>";
echo "</div>"; // Cierra container
?>
