<?php
// comprar.php

// Inicia la sesión
session_start();

// Incluye el archivo de conexión
include('./modelo/conexionPDO.php');

// Verifica si se proporcionó un ID de producto en la URL
if (isset($_GET['id'])) {
    $producto_id = $_GET['id'];

    // Consulta el producto específico
    $sql = "SELECT * FROM productos WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $producto_id);
    $stmt->execute();

    // Obtiene la información del producto
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    // Consulta tres productos al azar, excluyendo el producto actual
    $sqlSugerencias = "SELECT * FROM productos WHERE id != :id ORDER BY RAND() LIMIT 3";
    $stmtSugerencias = $conn->prepare($sqlSugerencias);
    $stmtSugerencias->bindParam(':id', $producto_id);
    $stmtSugerencias->execute();

    // Obtiene la información de los productos sugeridos
    $productosSugeridos = $stmtSugerencias->fetchAll(PDO::FETCH_ASSOC);

    // Cierra la conexión
    $conn = null;

    // Almacena el producto en el carrito de la sesión
    $_SESSION['carrito'][] = $producto;
} else {
    // Si no se proporcionó un ID, redirige a la página de tienda
    header('Location: tienda.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nectar Secreto - Detalles del Producto</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
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
				<li><a href="./tiendas.php">PUNTOS DE VENTA</a></li>
				<li><a href="./blog.php">BLOG</a></li>
			</ul>
		</nav>
        <div class="logo2">
            <img src="./img/usuario.png" alt="usuario">
        </div>
        <div class="logo2">
            <img src="./img/carrito.png" alt="carrito">
        </div>
	</header>

    <br><br><br><br><br>

    <section>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <img class="img-fluid" src="./modelo/<?php echo $producto['imagen']; ?>" alt="Imagen del Producto">
            </div>
            <div class="col-md-6">
                <br><br><br><br><br>
                <h2><?php echo $producto['nombre']; ?></h2>
                <p><?php echo $producto['descripcion']; ?></p>
                <p>Precio: $<?php echo $producto['precio']; ?></p>
                <!-- Puedes agregar más información del producto aquí -->
                <a href="#" class="btn btn-warning">Comprar Ahora</a>
                <a href="carrito.php?id=<?php echo $producto['id']; ?>" class="btn btn-dark">Agregar al carrito</a>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container mt-4">
        <div class="center">
            <h2>Productos Sugeridos</h2>
        </div>
        <div class="row">
            <?php foreach ($productosSugeridos as $productoSugerido): ?>
                <div class="col-md-4">
                    <div class="card">
                        <img class="card-img-top" src="./modelo/<?php echo $productoSugerido['imagen']; ?>" alt="Imagen del Producto Sugerido">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $productoSugerido['nombre']; ?></h5>
                            <p class="card-text"><?php echo $productoSugerido['descripcion']; ?></p>
                            <p class="card-text">$<?php echo $productoSugerido['precio']; ?></p>
                            <a href="comprar.php?id=<?php echo $productoSugerido['id']; ?>" class="btn btn-dark">Ver Detalles</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

</body>
</html>
