<?php
// eliminar_pedido.php

// Incluye el contenido de conexionPDO.php sin modificarlo
require_once('../modelo/conexionPDO.php');

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Sentencia SQL para eliminar el pedido con el ID proporcionado
    $sql = "DELETE FROM datos_compra WHERE id = :id";

    try {
        // Preparar la sentencia
        $stmt = $conn->prepare($sql);

        // Vincular los parámetros
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Ejecutar la sentencia
        $stmt->execute();

        // Cerrar la conexión
        $conn = null;

        // Devolver una respuesta JSON exitosa
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        // Manejar errores
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    // Si no se proporciona un ID, devolver un error
    echo json_encode(['error' => 'ID no proporcionado']);
}
?>
