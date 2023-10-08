<?php
// Incluir la clase Empleado y otras dependencias si es necesario
require_once 'clases/Empleado.php'; // Asegúrate de que la ruta al archivo Empleado.php sea correcta

// Obtener la lista de empleados utilizando el método TraerTodos
$empleados = Empleado::TraerTodos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Empleados</title>
</head>
<body>
    <h1>Listado de Empleados</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Perfil</th>
                <th>Foto</th>
                <th>Sueldo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($empleados as $empleado): ?>
                <tr>
                    <td><?= $empleado->id ?></td>
                    <td><?= $empleado->nombre ?></td>
                    <td><?= $empleado->correo ?></td>
                    <td><?= $empleado->perfil ?></td>
                    <td><?= $empleado->getSueldo() ?></td>
                    <td><img src="<?= $empleado->getFoto()[0] ?>" alt="Foto de perfil" width="50" height="50"></td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>