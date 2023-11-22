<?php

session_start();

include_once('./modelo/conexionPDO.php');

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Nectar Secreto - Carrito de Compras</title>
            <link rel="stylesheet" href="css/bootstrap.min.css">
            <link rel="stylesheet" href="css/style.css">
            <link rel="icon" type="image/x-icon" href="./img/logo3.ico">
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

        <div class="container mt-4">
            <h2 class="text-center">Carrito de Compras</h2>
            <p class="text-center">Tu carrito de compras está vacío.</p>
        </div>

        </body>
        </html>';
    exit();
} else {
    
    try {
        
        include_once('./modelo/conexionPDO.php');
    } catch (PDOException $e) {
        exit("Error de conexión: " . $e->getMessage());
    }

    echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Nectar Secreto - Carrito de Compras</title>
            <link rel="stylesheet" href="css/bootstrap.min.css">
            <link rel="stylesheet" href="css/style.css">
        </head>
        <body>
        <br><br><br><br><br>
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

        <div class="container mt-4">
            <h2 class="text-center">Carrito de Compras</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>';

    $totalCarrito = 0;

    
    foreach ($_SESSION['carrito'] as $indice => $productoCarrito) {
        $totalProducto = $productoCarrito['precio'] * (isset($productoCarrito['cantidad']) ? $productoCarrito['cantidad'] : 1);
        $totalCarrito += $totalProducto;

        echo '
            <tr>
                <td><img src="./modelo/' . $productoCarrito['imagen'] . '" alt="Imagen del Producto" style="max-width: 100px;"></td>
                <td>' . $productoCarrito['nombre'] . '</td>
                <td>' . $productoCarrito['descripcion'] . '</td>
                <td>$' . number_format($productoCarrito['precio'], 2) . '</td>
                <td>
                    <form action="actualizar_carrito.php" method="post">
                        <input type="hidden" name="indice" value="' . $indice . '">
                        <input type="number" name="cantidad" value="' . (isset($productoCarrito['cantidad']) ? $productoCarrito['cantidad'] : 1) . '" min="1">
                        <button type="submit" class="btn btn-sm btn-primary">Actualizar</button>
                    </form>
                </td>
                <td>$' . number_format($totalProducto, 2) . '</td>
                <td>
                    <a href="eliminar_del_carrito.php?indice=' . $indice . '" class="btn btn-sm btn-danger">Eliminar</a>
                </td>
            </tr>';
    }

    echo '
                </tbody>
            </table>
            <div class="text-center">
                <h4>Total del Carrito: $' . number_format($totalCarrito, 2) . '</h4>
            </div>
            <!-- Formulario para datos de envío -->
            <form action="realizar_compra.php" method="post">
            <h4>Datos de Envío</h4>
            <label for="direccion_entrega">Dirección de entrega:</label>
            <input type="text" name="direccion_entrega" required>
            <br><br>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required>
            <br><br>
            <label for="apellido_paterno">Apellido paterno:</label>
            <input type="text" name="apellido_paterno" required>
            <br><br>
            <label for="apellido_materno">Apellido materno:</label>
            <input type="text" name="apellido_materno" required>
            <br><br>
            <button type="submit" name="realizar_compra" class="btn btn-success">Realizar Compra</button>
        </form>
        </div>';

    
    $conn = null;

    echo '
        </body>
        </html>';
}
?>