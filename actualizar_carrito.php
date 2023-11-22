<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['indice']) && isset($_POST['cantidad'])) {
        $indice = $_POST['indice'];
        $cantidad = $_POST['cantidad'];

      
        if ($cantidad > 0) {
            
            $_SESSION['carrito'][$indice]['cantidad'] = $cantidad;
        } else {
            
            unset($_SESSION['carrito'][$indice]);
            $_SESSION['carrito'] = array_values($_SESSION['carrito']); 
        }
    }
}

header('Location: carrito.php');
exit();
?>