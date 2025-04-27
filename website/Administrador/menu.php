

<!DOCTYPE html>
<head>
    <title>Panel Principal</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
            
        }

        .header {
            background-color: #0A7075;
            color: white;
            padding: 15px;
            text-align: center;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }

        .header p {
            margin: 0;
            font-weight: bold;
        }

        .menu-links {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 15px;
            justify-content: space-evenly; /* Distribuye equidistantemente los enlaces */
            flex-grow: 1; /* Hace que ocupe el espacio disponible */
        }

        .menu-links a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .menu-links a:hover {
            text-decoration: underline;
        }

        .btn a button {
            background-color: #0A7075;
            border: none;
            color: white;
            padding: 10px 25px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn a button:hover {
            background-color: #0A7075;
        }

        /* Estilos de bienvenida */
        .bienvenida {
            text-align: center;
            padding: 50px;
            background-color: #0C969C;
            width: 400px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            
        }

        .bienvenida h1 {
            font-size: 28px;
            color: #333;
        }

        .bienvenida p {
            font-size: 16px;
            color: #666;
        }
    </style>
</head>
<body>
    <header class="header">
        <p>Usuario: <?php echo $usuario; ?></p>
        <nav>
            <ul class="menu-links">
            <li><a href="#">Inicio</a></li>
                <li><a href="empleados_lista.php">Empleados</a></li>
                <li><a href="productos_lista.php">Productos</a></li>
                <li><a href="promociones_lista.php">Promociones</a></li>
                <li><a href="pedidos.php">Pedidos</a></li>
            </ul>
        </nav>
        <div class="btn">
            <a href="salir.php"><button>Cerrar Sesión</button></a>
        </div>
    </header>

    <div class="bienvenida">
        <h1>Hola, <?php echo $usuario; ?>!</h1>
    </div>
</body>
</html>
