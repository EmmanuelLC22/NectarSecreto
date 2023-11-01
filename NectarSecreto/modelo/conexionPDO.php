<?php

    $server = 'localhost';
    $username = 'root';
    $password = '';
    $databases = 'bdnectar';

    try {
        $conn = new PDO("mysql:host=$server;dbname=$databases;",$username, $password);
    } catch (PDOException $e) {
        die('Conected failed: '.$e->getMessage);
    }

?>