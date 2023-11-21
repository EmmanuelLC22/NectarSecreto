<?php
// eliminar.php

include('../modelo/conexionPDO.php');

// Verifica si se proporciona un ID válido en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Prepara la consulta SQL para la eliminación
    $sql = 'DELETE FROM productos WHERE id = :id';

    // Prepara y ejecuta la consulta
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo 'Producto eliminado correctamente.';
    } else {
        echo 'Error al eliminar el producto: ' . $stmt->errorInfo()[2];
    }
} else {
    echo 'ID de producto no válido.';
}

// Cierra la conexión
$conn = null;
?>
