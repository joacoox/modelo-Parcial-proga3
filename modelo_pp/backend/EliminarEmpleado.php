<?php
require_once "clases/empleado.php";

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    
        
       
        $id = intval($_POST["id"]);

        $resultado = Empleado::Eliminar($id);

        if($resultado != false)
        {
            $json_mensaje = [
                "exito" => true,
                "mensaje" => "Salio todo ok, user borrado",
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
