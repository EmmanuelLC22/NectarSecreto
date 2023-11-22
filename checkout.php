<?php


session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
        $_SESSION['carrito'] = array();
    } else {
        echo '<p class="text-center">Tu carrito de compras está vacío.</p>';
    }
}

header('Location: carrito.php');
exit();
?>