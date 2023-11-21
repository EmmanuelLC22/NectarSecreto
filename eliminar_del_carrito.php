<?php
// eliminar_del_carrito.php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Verifica que se recibió el índice del producto a eliminar
    if (isset($_GET['indice'])) {
        $indice = $_GET['indice'];

        // Elimina el producto del carrito
        unset($_SESSION['carrito'][$indice]);
        $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexa el array
    }
}

// Redirige de vuelta a la vista del carrito
header('Location: carrito.php');
exit();
?>