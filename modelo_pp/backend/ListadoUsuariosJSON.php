<?php 

require_once "clases/usuario.php";

if($_SERVER['REQUEST_METHOD'] == 'GET')
{
    try {
        $usuarios = Usuario::TraerTodosJSON();
    
        foreach ($usuarios as $usuario) {
            
            var_dump($usuario);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}