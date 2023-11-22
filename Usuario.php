<?php

session_start();

require_once('./modelo/conexionPDO.php');

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../index.php");
    exit();
}

$correoUsuario = $_SESSION['usuario_correo'];


if (!$conn) {
    echo "Error: No se pudo establecer la conexión a la base de datos.";
    exit();
}

$sql = 'SELECT * FROM t_usuarios WHERE correo = :correo';

try {
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':correo', $correoUsuario);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "Error al ejecutar la consulta: " . $e->getMessage();
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $targetDir = "img/";  
    $targetFile = $targetDir . uniqid('imagen_') . '.' . pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);

    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $targetFile)) {
        
        $sqlUpdateImagen = 'UPDATE t_usuarios SET imagen_perfil = :imagen WHERE correo = :correo';
        try {
            $stmtUpdateImagen = $conn->prepare($sqlUpdateImagen);
            $stmtUpdateImagen->bindParam(':imagen', $targetFile);
            $stmtUpdateImagen->bindParam(':correo', $correoUsuario);
            $stmtUpdateImagen->execute();
        } catch (Exception $e) {
            echo "Error al actualizar la imagen en la base de datos: " . $e->getMessage();
            exit();
        }

        
        header("Location: Usuario.php");
        exit();
    } else {
        echo "Lo siento, hubo un error al subir tu archivo.";
    }
}

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
    <section>
        <div class="container">
            <div class="row">
            <div class="center">
        
        <?php if (!empty($usuario['imagen_perfil'])): ?>
            <img src="<?php echo $usuario['imagen_perfil']; ?>" alt="Imagen de perfil">
        <?php endif; ?>
            <br><br>
        <form method="post" action="Usuario.php" enctype="multipart/form-data">
            <label for="imagen">Selecciona una imagen:</label>
            <input type="file" name="imagen" id="imagen" accept="image/*"><br><br>
            <button type="submit" class="btn btn-dark">Subir Imagen</button>
        </form>

                <div class="col-md-4"></div>

                <div class="center">
                    <br><br>
                    <h1>Bienvenido <?php echo $usuario['nombreUsuario']; ?></h1>
                    <br>
                    <h2>Información del usuario</h2>
                    <br>
                </div>
                <br>
                <div class="justificado">
                    <br>
                    <h4>Nombre completo:</h4>
                    <p><?php echo $usuario['nombreUsuario'] . ' ' . $usuario['aPaterno'] . ' ' . $usuario['aMaterno']; ?></p>
                    <br>
                    <h4>Número fijo:</h4>
                    <p><?php echo $usuario['telefono']; ?></p>
                    <br>
                    <h4>Correo Electrónico:</h4>
                    <p><?php echo $usuario['correo']; ?></p>
                    <br>
                    <div class="center">
                        <form method="post" action="cerrar_sesion.php">
                            <button type="submit" class="btn btn-dark">Cerrar sesión</button>
                        </form>
                    </div>
                    <br>
                </div>
                <hr>
                <div class="center"><h1>Productos de la tienda</h1></div>

<div class="row">
    <?php
    
    $sqlSugerencias = "SELECT * FROM productos ORDER BY RAND() LIMIT 3";
    $stmtSugerencias = $conn->prepare($sqlSugerencias);
    $stmtSugerencias->execute();
    $productosSugeridos = $stmtSugerencias->fetchAll(PDO::FETCH_ASSOC);
    
    
    foreach ($productosSugeridos as $productoSugerido): ?>
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
        </div>
    </section>

    <script type="text/javascript">
        window.addEventListener("scroll", function () {
            var header = document.querySelector("header");
            header.classList.toggle("abajo", window.scrollY > 0);
        })
    </script>

    <footer>
        <p>Boulevard Belizario Domìnguez, kilómetro 1081, sin número. Teràn Tuxtla Gutiérrez, Chiapas.</p>
        <p>&copy; 2023 Derechos reservados</p>
    </footer>
</body>
</html>
