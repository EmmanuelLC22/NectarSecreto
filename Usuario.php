<?php
require_once('./modelo/conexionPDO.php');

$sql = 'SELECT * FROM t_usuarios LIMIT 1';

try {
    // Prepara la consulta
    $stmt = $conn->prepare($sql);

    // Ejecuta la consulta
    $stmt->execute();

    // Obtiene los datos del usuario
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    echo "Error al ejecutar la consulta: " . $e->getMessage();
    exit();
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

    <br><br><br><br><br>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <br><br>
                    <img src="https://cdn-icons-png.flaticon.com/512/456/456212.png" alt="">
                </div>

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
                    <h4>Nombre completo:</h4>
                    <p><?php echo $usuario['nombreUsuario'] . ' ' . $usuario['aPaterno']. ' ' . $usuario['aMaterno']; ?></p>
                    <br>
                    <h4>Número fijo:</h4>
                    <p><?php echo $usuario['telefono']; ?></p>
                    <br>
                    <h4>Correo Electrónico:</h4>
                    <p><?php echo $usuario['correo']; ?></p>
                    <br>
                    <div class="center">
                        <!-- Agregado el formulario para cerrar sesión -->
                        <form method="post" action="cerrar_sesion.php">
                            <button type="submit" class="btn btn-dark">Cerrar sesión</button>
                        </form>
                    </div>
                    <br>
                </div>
                <hr>
                <div class="center"><H1>Productos de la tienda</H1></div>
                <br>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <img class="card-img-top" src="https://www.aromesdemorella.com/128-thickbox_default/jabon-avena-y-miel-100gr.jpg" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">JABONES</h5>
                                <p class="card-text">Visita nuestra tienda en línea y conoce nuestros productos!</p>
                                <a href="./general.php" class="btn btn-dark">Visitar</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <img class="card-img-top" src="https://mahaloficial.com/wp-content/uploads/2022/02/shampoo_Miel.jpg" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">SHAMPOOS</h5>
                                <p class="card-text">Al tener una cuenta podrás opinar acerca de nuestros productos y comprar más fácilmente</p>
                                <a href="./general.php" class="btn btn-dark">Visitar</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <img class="card-img-top" src="https://verbena.co/cdn/shop/products/balsamo_labial_miel_verbena.jpg?v=1637893554" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">Bálsamo</h5>
                                <p class="card-text">Conoce las tiendas más cercanas a tu hogar para comprar tus productos favoritos</p>
                                <a href="./general.php" class="btn btn-dark">Visitar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">
        window.addEventListener("scroll", function(){
            var header = document.querySelector("header");
            header.classList.toggle("abajo",window.scrollY>0);
        })
    </script>

    <footer>
        <P>Boulevard Belizario Domìnguez, kilómetro 1081, sin número. Teràn Tuxtla Gutiérrez, Chiapas.</P>
        <p>&copy; 2023 Derechos reservados</p>
    </footer>
</body>
</html>
