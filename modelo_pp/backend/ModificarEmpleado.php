<?php
require_once "clases/empleado.php";

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $empleado_json = $_POST["empleado_json"];

    $empleado = json_decode($empleado_json, true); 

    $id = intval($empleado["id"]);
    $nombre = $empleado["nombre"];
    $correo = $empleado["correo"];
    $clave = $empleado["clave"];
    $id_perfil = intval($empleado["id_perfil"]);
    $sueldo = intval($empleado["sueldo"]);
    $path_image = isset($_FILES["foto"]) ? $_FILES["foto"] : array();

    $empleadoDos = new Empleado($id,$nombre,$correo,$clave,$id_perfil,0,$path_image,$sueldo);

    $resultado = $empleadoDos->Modificar();

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