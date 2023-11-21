<?php
// procesar_agregar.php

// Incluye el archivo de conexión
include('../modelo/conexionPDO.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene los datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];

    // Manejo de la imagen
    $imagen = $_FILES['imagen'];
    $nombreImagen = $imagen['name'];
    $rutaDestino = '../ruta/destino/';
    $rutaImagen = $rutaDestino . $nombreImagen;

    // Crea el directorio de destino si no existe
    if (!file_exists($rutaDestino)) {
        mkdir($rutaDestino, 0777, true);
    }

    // Mueve la imagen al directorio de destino
    if (move_uploaded_file($imagen['tmp_name'], $rutaImagen)) {
        // Prepara la consulta SQL para la inserción
        $sql = 'INSERT INTO productos (nombre, descripcion, precio, imagen) VALUES (:nombre, :descripcion, :precio, :imagen)';

        // Prepara y ejecuta la consulta
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':imagen', $rutaImagen);

        if ($stmt->execute()) {
            header('Location: administrador.php');
        } else {
            echo 'Error al agregar el producto: ' . $stmt->errorInfo()[2];
        }
    } else {
        echo 'Error al mover la imagen al directorio de destino.';
    }
} else {
    // Si el formulario no se envió por el método POST, redirige a la página de agregar
    header('Location: agregar.php');
    exit();
}

// Cierra la conexión
$conn = null;
?>
