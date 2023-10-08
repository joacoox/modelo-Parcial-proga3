<?php 

require_once "clases/usuario.php";

if($_SERVER['REQUEST_METHOD'] === 'POST')
{

    $usuario_json = $_POST["usuario_json"];

    $usuario = json_decode($usuario_json, true); 
 
    $correo = $usuario["correo"];
    $clave = $usuario["clave"];

    $resultado = Usuario::TraerUno($correo,$clave);

    echo var_dump($resultado);

    if($resultado != false)
    {
        $json_mensaje = [
            "exito" => true,
            "mensaje" => "Salio todo ok",
            ];
    }else
    {
        $json_mensaje = [
            "exito" => false,
            "mensaje" => "Salio mal, no se encontro al usuario",
            ];
    }

    return json_encode($json_mensaje);
}
