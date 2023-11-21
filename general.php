<?php
// general.php

// Incluye el archivo de conexión
include('./modelo/conexionPDO.php');

// Consulta todos los productos
$sql = 'SELECT * FROM productos';
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

    <br><br><br><br><br><br>

    <div class="center">

    <h1>PRODUCTOS</h1>

    </div>

    <section>
        <div class="container">
            <div class="row">
                <?php foreach ($productos as $producto): ?>
                    <div class="col-md-4">
                        <div class="card">
                            <img class="card-img-top" src="./modelo/<?php echo $producto['imagen']; ?>" alt="Imagen del Producto">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $producto['nombre']; ?></h5>
                                <p class="card-text"><?php echo $producto['descripcion']; ?></p>
                                <p class="card-text">$<?php echo $producto['precio']; ?></p>
                                <a href="comprar.php?id=<?php echo $producto['id']; ?>" class="btn btn-dark">Comprar</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <script src="js/bootstrap.min.js"></script>

    </body>
    </html>