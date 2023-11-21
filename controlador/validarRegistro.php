<?php
require("../modelo/conexionPDO.php");

try {
    // Verifica si el campo 'clave' está presente en $_POST
    if (isset($_POST['clave'])) {
        // Verifico los datos del login
        $correo = htmlentities(addslashes($_POST['correo']));
        $clave = $_POST['clave'];

        $sql = "SELECT * FROM t_usuarios WHERE correo = :correo";

        // Prepara la consulta SQL
        $resultado = $conn->prepare($sql);

        // Ejecución de la consulta
        $resultado->execute(array(":correo" => $correo));

        $login = $resultado->fetch(PDO::FETCH_ASSOC);

        if ($login && password_verify($clave, $login['clave'])) {
            echo '<script>
                Swal.fire({
                icon: "success",
                title: "Usuario aceptado",
                text: "Inicio de sesión correcto",
                showConfirmButton: true,
                confirmButtonText: "Aceptar"
            }) </script>';

            // Verifica si el usuario autenticado es el administrador
            if ($login['es_administrador'] == 1) {
                // Inicia o reanuda la sesión
                session_start();

                // Almacena la información del usuario en la sesión
                $_SESSION['usuario_id'] = $login['id'];
                $_SESSION['usuario_nombre'] = $login['nombreUsuario'];

                // Redirige directamente a la página de administrador
                header("Location: ../admin/administrador.php");
                exit();
            } else {
                // Redirige a la página de usuario normal
                header("Location: ../indexUsuario.php");
                exit();
            }
        } else {
            echo '<script>
                Swal.fire({
                icon: "error",
                title: "Credenciales no válidas",
                text: "Inicio de sesión incorrecto",
                showConfirmButton: true,
                confirmButtonText: "Aceptar"
            }) </script>';
            header("Location: ../../index.php?error=si");
            exit();
        }
    } else {
        echo "Error: Contraseña no proporcionada.";
        // Puedes redirigir o manejar el error de alguna manera
    }

} catch (Exception $e) {
    die($e->getMessage());
}
?>