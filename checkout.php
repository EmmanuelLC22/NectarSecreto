<?php
// checkout.php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Verifica que haya productos en el carrito
    if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
        // Aquí deberías implementar la lógica para procesar el pago, actualizar la base de datos, etc.
        // Luego de realizar el proceso de compra, puedes limpiar el carrito de la siguiente manera:
        $_SESSION['carrito'] = array();
    } else {
        echo '<p class="text-center">Tu carrito de compras está vacío.</p>';
    }
}

// Redirige de vuelta a la vista del carrito (puedes cambiar esto según tu flujo)
header('Location: carrito.php');
exit();
?>