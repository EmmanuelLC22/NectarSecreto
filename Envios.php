<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Producto</th>
            <th>Descripción</th>
            <th>Precio</th>
            <!-- Agrega más columnas según sea necesario -->
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Recorre los productos comprados y muestra en forma de tabla
        foreach ($productosComprados as $producto):
        ?>
            <tr>
                <td><?php echo $producto['id']; ?></td>
                <td><?php echo $producto['nombre']; ?></td>
                <td><?php echo $producto['descripcion']; ?></td>
                <td>$<?php echo $producto['precio']; ?></td>
                <!-- Agrega más columnas según sea necesario -->
                <td>
                    <button class="btn btn-success">Recibido</button>
                    <button class="btn btn-danger">Reportar</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
