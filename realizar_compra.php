<?php


session_start();

if (isset($_POST['realizar_compra'])) {
    $direccion_entrega = $_POST['direccion_entrega'];
    $nombre = $_POST['nombre'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];

    
    echo "Dirección de entrega: $direccion_entrega<br>";
    echo "Nombre: $nombre<br>";
    echo "Apellido paterno: $apellido_paterno<br>";
    echo "Apellido materno: $apellido_materno<br>";

    
    include('./modelo/conexionPDO.php');

    
    try {
        
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        
    } catch (PDOException $e) {
        exit("Error de conexión: " . $e->getMessage());
    }

    
    if (!$conn) {
        die("Error de conexión a la base de datos");
    }

    
    $direccion_entrega = htmlspecialchars($direccion_entrega);
    $nombre = htmlspecialchars($nombre);
    $apellido_paterno = htmlspecialchars($apellido_paterno);
    $apellido_materno = htmlspecialchars($apellido_materno);

    
    $carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];

    
    $productos_json = json_encode($carrito);

    
    $total_carrito = 0;
    foreach ($carrito as $producto) {
        $total_carrito += $producto['precio'] * (isset($producto['cantidad']) ? $producto['cantidad'] : 1);
    }

    
    $sql = "INSERT INTO datos_compra (direccion_entrega, nombre, apellido_paterno, apellido_materno, productos_json, total_carrito) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    
    $stmt->bindParam(1, $direccion_entrega);
    $stmt->bindParam(2, $nombre);
    $stmt->bindParam(3, $apellido_paterno);
    $stmt->bindParam(4, $apellido_materno);
    $stmt->bindParam(5, $productos_json);
    $stmt->bindParam(6, $total_carrito);

    
    if ($stmt->execute()) {
        
        echo "Datos insertados correctamente en la tabla datos_compra";
    } else {
        
        echo "Error al insertar datos en la tabla datos_compra: " . $stmt->errorInfo()[2];
    }

    
    $stmt->closeCursor();

    
    $stmt = null;
    $conn = null;

    
    header("Location: general.php");
    exit();
} else {
    
}
?>