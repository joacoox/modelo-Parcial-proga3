<!DOCTYPE html>
<html>
<head>
    <title>Listado de Usuarios</title>
</head>
<body>
    <h1>Listado de Usuarios</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Correo</th>
                <th>Nombre</th>
                <th>Perfil</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once 'clases/Usuario.php';

            try {
                $usuarios = Usuario::TraerTodos();

                foreach ($usuarios as $usuario) {
                    echo '<tr>';
                    echo '<td>' . $usuario->id . '</td>';
                    echo '<td>' . $usuario->correo . '</td>';
                    echo '<td>' . $usuario->nombre . '</td>';
                    echo '<td>' . $usuario->perfil . '</td>';
                    echo '</tr>';
                }
            } catch (Exception $e) {
                echo 'Error: ' . $e->getMessage();
            }
            ?>
        </tbody>
    </table>
</body>
</html>