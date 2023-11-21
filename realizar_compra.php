<?php
// realizar_compra.php

session_start();

if (isset($_POST['realizar_compra'])) {
    $direccion_entrega = $_POST['direccion_entrega'];
    $nombre = $_POST['nombre'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];

    // Puedes imprimir los datos para verificar
    echo "Dirección de entrega: $direccion_entrega<br>";
    echo "Nombre: $nombre<br>";
    echo "Apellido paterno: $apellido_paterno<br>";
    echo "Apellido materno: $apellido_materno<br>";

    // Incluye tu archivo de conexión
    include('./modelo/conexionPDO.php');

    // Intenta establecer la conexión a la base de datos
    try {
        // Ejecutamos las variables y aplicamos UTF8
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        //echo "Conexión Satisfactoria";
    } catch (PDOException $e) {
        exit("Error de conexión: " . $e->getMessage());
    }

    // Verifica si la conexión es exitosa
    if (!$conn) {
        die("Error de conexión a la base de datos");
    }

    // Asegúrate de escapar los datos para prevenir inyecciones SQL
    $direccion_entrega = htmlspecialchars($direccion_entrega);
    $nombre = htmlspecialchars($nombre);
    $apellido_paterno = htmlspecialchars($apellido_paterno);
    $apellido_materno = htmlspecialchars($apellido_materno);

    // Obtén los datos del carrito
    $carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];

    // Convierte el carrito a formato JSON para almacenarlo en la base de datos
    $productos_json = json_encode($carrito);

    // Calcula el total del carrito
    $total_carrito = 0;
    foreach ($carrito as $producto) {
        $total_carrito += $producto['precio'] * (isset($producto['cantidad']) ? $producto['cantidad'] : 1);
    }

    // Prepara la consulta SQL para la inserción
    $sql = "INSERT INTO datos_compra (direccion_entrega, nombre, apellido_paterno, apellido_materno, productos_json, total_carrito) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Vincula los parámetros
    $stmt->bindParam(1, $direccion_entrega);
    $stmt->bindParam(2, $nombre);
    $stmt->bindParam(3, $apellido_paterno);
    $stmt->bindParam(4, $apellido_materno);
    $stmt->bindParam(5, $productos_json);
    $stmt->bindParam(6, $total_carrito);

    // Ejecuta la consulta
    if ($stmt->execute()) {
        // Éxito en la inserción
        echo "Datos insertados correctamente en la tabla datos_compra";
    } else {
        // Error en la inserción
        echo "Error al insertar datos en la tabla datos_compra: " . $stmt->errorInfo()[2];
    }

    // Cierra el cursor de la consulta preparada
    $stmt->closeCursor();

    // Cierra la conexión y redirige
    $stmt = null;
    $conn = null;

    // Redirecciona a donde necesitas después de la compra
    header("Location: general.php");
    exit();
} else {
    // Manejar el caso en que no se haya enviado el formulario
    // ...
}
?>