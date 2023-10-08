<?php
require_once "clases/usuario.php";
if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $usuario_json = $_POST["usuario_json"];

    $usuario = json_decode($usuario_json, true); 

    $id = intval($usuario["id"]);
    $nombre = $usuario["nombre"];
    $correo = $usuario["correo"];
    $clave = $usuario["clave"];
    $id_perfil = intval($usuario["id_perfil"]);

    $user = new Usuario($id,$nombre,$correo,$clave,$id_perfil,0);

    $resultado = $user->Modificar();

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
