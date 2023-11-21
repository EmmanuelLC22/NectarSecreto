<?php
// procesar_editar.php

include('../modelo/conexionPDO.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene los datos del formulario
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $imagen_actual = $_POST['imagen_actual'];

    // Manejo de la nueva imagen
    $imagen = $_FILES['imagen'];
    $nombreImagen = $imagen['name'];
    $rutaDestino = '../ruta/destino/';
    $rutaImagen = $rutaDestino . $nombreImagen;

    // Crea el directorio de destino si no existe
    if (!file_exists($rutaDestino)) {
        mkdir($rutaDestino, 0777, true);
    }

    // Mueve la nueva imagen al directorio de destino si se proporciona
    if (!empty($nombreImagen)) {
        move_uploaded_file($imagen['tmp_name'], $rutaImagen);
    } else {
        // Si no se proporciona una nueva imagen, utiliza la imagen actual
        $rutaImagen = $imagen_actual;
    }

    // Prepara la consulta SQL para la actualización
    $sql = 'UPDATE productos SET nombre = :nombre, descripcion = :descripcion, precio = :precio, imagen = :imagen WHERE id = :id';

    // Prepara y ejecuta la consulta
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':precio', $precio);
    $stmt->bindParam(':imagen', $rutaImagen);

    if ($stmt->execute()) {
        echo 'Producto actualizado correctamente.';
    } else {
        echo 'Error al actualizar el producto: ' . $stmt->errorInfo()[2];
    }
} else {
    // Si el formulario no se envió por el método POST, redirige a la página de administrador
    header('Location: admin.php');
    exit();
}

// Cierra la conexión
$conn = null;
?>
