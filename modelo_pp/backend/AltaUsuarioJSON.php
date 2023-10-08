<?php 

require_once "clases/usuario.php";

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $correo = $_POST["correo"];
    $clave = $_POST["clave"];
    $nombre = $_POST["nombre"];
 

    $user = new Usuario(0,$nombre,$correo,$clave,0,0);
    Usuario::GuardarEnArchivo($user);

}