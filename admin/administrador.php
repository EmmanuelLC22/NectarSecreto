<?php
// admin.php

// Incluye el archivo de conexión
include('../modelo/conexionPDO.php');

// Consulta todos los productos con ID ordenado
$sql = 'SELECT * FROM productos ORDER BY id';
$resultado = $conn->query($sql);

// Verifica si hay resultados
if ($resultado) {
    // Obtiene todos los productos
    $productos = $resultado->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo 'Error al obtener productos: ' . $conn->errorInfo()[2];
}

// Cierra la conexión
$conn = null;
?>

<!-- admin.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/x-icon" href="../img/logo3.ico">
    <style>
        /* Personalizaciones adicionales de estilo */
        body {
            background-color: #f8f9fa;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #007bff;
        }

        .table th, .table td {
            text-align: center;
        }

        .table th.actions, .table td.actions {
            width: 150px;
        }

        .btn-edit {
            color: #ffffff;
            background-color: #28a745;
            border: none;
        }

        .btn-delete {
            color: #ffffff;
            background-color: #dc3545;
            border: none;
        }
    </style>
</head>
<br><br><br><br><br><br>
<body>
    <header class="navar1">
        <div class="logo">
            <img src="../img/logo3.png" alt="logotipo">
        </div>
        <nav>
            <ul class="link">
                <li><a href="administrador.php">PRODUCTOS</a></li>
                <li><a href="adminUsuarios.php">USUARIOS</a></li>
                <li><a href="pedidos.php">PEDIDOS</a></li>
                <li><a href="../login.php">CERRAR SESION</a></li>
            </ul>
        </nav>
    </header>

    <div class="container mt-4">
    <h2>Administrar Productos</h2>

    <!-- Lista de productos -->
    <table class="table table-bordered table-hover">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Imagen</th>
                <th class="actions">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Genera dinámicamente las filas de la tabla -->
            <?php
            $fila = 1; // Inicializa la variable de fila
            foreach ($productos as $producto): ?>
                <tr>
                    <td><?php echo $fila++; ?></td>
                    <td><?php echo $producto['nombre']; ?></td>
                    <td><?php echo $producto['descripcion']; ?></td>
                    <td>$<?php echo $producto['precio']; ?></td>
                    <td><img src="<?php echo $producto['imagen']; ?>" alt="Imagen del Producto" style="max-width: 100px;"></td>
                    <td class="actions">
                        <a href="editar.php?id=<?php echo $producto['id']; ?>" class="btn btn-success btn-edit">Editar</a>
                        <a href="eliminar.php?id=<?php echo $producto['id']; ?>" class="btn btn-danger btn-delete">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Botón para agregar producto -->
    <a href="agregar.php" class="btn btn-success">Agregar Producto</a>
</div>

    <script src="js/bootstrap.min.js"></script>
</body>
</html>
