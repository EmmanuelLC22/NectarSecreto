<?php
// actualizar_carrito.php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica que se recibieron los datos necesarios
    if (isset($_POST['indice']) && isset($_POST['cantidad'])) {
        $indice = $_POST['indice'];
        $cantidad = $_POST['cantidad'];

        // Valida que la cantidad sea mayor que cero
        if ($cantidad > 0) {
            // Actualiza la cantidad en el carrito
            $_SESSION['carrito'][$indice]['cantidad'] = $cantidad;
        } else {
            // Si la cantidad es 0 o menor, elimina el producto del carrito
            unset($_SESSION['carrito'][$indice]);
            $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexa el array
        }
    }
}

// Redirige de vuelta a la vista del carrito
header('Location: carrito.php');
exit();
?>