<?php  

require_once "clases/empleado.php";

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $correo = $_POST["correo"];
    $clave = $_POST["clave"];
    $nombre = $_POST["nombre"];
    $id_perfil = $_POST["id_perfil"];
    $idParseada = intval($id_perfil);
    $sueldo = intval($_POST["sueldo"]);
    $foto = $_FILES["foto"];

    $empleado = new Empleado(0,$nombre,$correo,$clave,$idParseada,0,$foto,$sueldo);


    if($empleado->Agregar())
    {
        $json_mensaje = [
            "exito" => true,
            "mensaje" => "Se pudo agregar el usuario a la DB",
            ];
       return json_encode($json_mensaje);

    }else
    {
        $json_mensaje = [
            "exito" => false,
            "mensaje" => "No se pudo agregar el usuario a la DB",
            ];
        return json_encode($json_mensaje);
    }

}