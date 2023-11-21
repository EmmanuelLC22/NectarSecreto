<?php
// historial.php

// Inicia o reanuda la sesión
session_start();

// Incluye el archivo de conexión
require_once('./modelo/conexionPDO.php');

// Consulta el historial de compras del usuario
$sql = 'SELECT * FROM datos_compra ORDER BY id DESC';

try {
    $stmt = $conn->query($sql);

    // Verifica si hay resultados
    $historial = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "Error al ejecutar la consulta: " . $e->getMessage();
    exit();
}

// Cierra la conexión
$conn = null;
?>

<!-- historial.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nectar Secreto</title>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/x-icon" href="./img/logo3.ico">
    <style>
        body {
            padding: 20px;
        }

        .table th, .table td {
            text-align: center;
        }
    </style>
</head>
<body>
<header class="navar1">
        <div class="logo">
            <img src="./img/logo3.png" alt="logotipo">
        </div>
        <nav>
            <ul class="link">
                <li><a href="./indexUsuario.php">HOME</a></li>
				<li><a href="./general.php">TIENDA</a></li>
				<li><a href="./nosotros.php">NOSOTROS</a></li>
				<li><a href="./tiendas.php">TIENDAS</a></li>
                <li><a href="./historial.php">HISTORIAL</a></li>
                <li><a href="./carrito.php">CARRITO</a></li>
                <li><a href="./Usuario.php">USUARIO</a></li>
                <li><a href="./index.php">SALIR</a></li>
            </ul>
        </nav>
        </header>
    <br><br><br><br><br>

    <h1 class="mb-4">Historial de Compras</h1>

    <table class="table table-bordered table-hover">
        <thead class="thead-light">
            <tr>
                <th>Nombre del Producto</th>
                <th>Descripción del Producto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($historial as $compra): ?>
                <?php
                    // Decodifica el JSON en la columna productos_json
                    $productos = json_decode($compra['productos_json'], true);
                ?>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?php echo $producto['nombre']; ?></td>
                        <td><?php echo $producto['descripcion']; ?></td>
                        <td>
                            <a href="./general.php" class="btn btn-primary" target="_blank">Ir a tienda</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Agrega los scripts y estilos de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
