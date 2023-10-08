<?php

require_once "IBM.php";

class Usuario implements IBM
{
    public int $id;
    public string $nombre;
    public string $correo;
    public string $clave;
    public int $id_perfil;
    public string $perfil;

    public function __construct($id, $nombre,$correo,$clave,$idperfil, $perfil)
    {
        $this->id = $id;
        $this->nombre =$nombre;
        $this->correo = $correo;
        $this->clave = $clave;
        $this->id_perfil = $idperfil;
        $this->perfil = $perfil;
    }

    public function ToJson() 
    {    
        $array = array(
            "nombre" => $this->nombre,
            "correo" => $this->correo,
            "clave"  => $this->clave
        );

        return $array;
    }


public static function GuardarEnArchivo(Usuario $user)
{
    $archivo = 'D:\XAMPP\htdocs\modelo_pp\backend\archivos\usuarios.json';
    
    $archivoActual = file_get_contents($archivo);

    $archivoAbierto = fopen($archivo, 'w');

    if ($archivoAbierto === false) {

        $json_mensaje = [
            "exito" => false,
            "mensaje" => "Error al abrir el archivo para escritura",
            ];
            return json_encode($json_mensaje);
    }

    $usuariosArray = json_decode($archivoActual);

    $usuariosArray[] = $user->ToJson();

    $jsonString = json_encode($usuariosArray,JSON_PRETTY_PRINT);

    if ($jsonString === false) {

        $json_mensaje = [
            "exito" => false,
            "mensaje" => "Error al convertir datos a JSON",
            ];
            return json_encode($json_mensaje);
    }

    fwrite($archivoAbierto, $jsonString);

    fclose($archivoAbierto);

    echo 'El usuario: ' . $user->nombre . ' se agregó correctamente al archivo JSON <br>';

    $json_mensaje = [
        "exito" => true,
        "mensaje" => "todo ok",
        ];
            return json_encode($json_mensaje);
}

    public static function TraerTodosJSON() 
    {
        $archivo = 'D:\XAMPP\htdocs\modelo_pp\backend\archivos\usuarios.json';

        if (file_exists($archivo)) {
            // Leer el contenido del archivo
            $jsonString = file_get_contents($archivo);

            if ($jsonString === false) {
                throw new Exception('Error al leer el archivo JSON');
            }

            // Decodificar la cadena JSON en un arreglo de objetos Usuario
            $usuarios = json_decode($jsonString , true);

            if ($usuarios === null) {
                throw new Exception('Error al decodificar el archivo JSON');
            }

            return $usuarios;
        } else {
            throw new Exception('El archivo JSON no existe');
        }
    }

    public function Agregar()
    {  
        try
        {
             
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test", "root",""); 
            $sql = $pdo->prepare("INSERT INTO `usuarios`(`correo`, `clave`, `nombre`, `id_perfil`)
             VALUES (:correo,:clave,:nombre,:id_perfil)");

            $sql->bindParam(":correo",$this->correo, PDO::PARAM_STR,30);
            $sql->bindParam(":clave",$this->clave, PDO::PARAM_STR,20);
            $sql->bindParam(":nombre",$this->nombre, PDO::PARAM_STR,20);
            $sql->bindParam(":id_perfil",$this->id_perfil, PDO::PARAM_INT);

            if($sql->execute()){
                echo "todo ok";
                return true;
            }else
            {
                echo "todo no ok";
                return false;
            }
               
        }catch(PDOException $exc)
        {   

            echo $exc->getMessage() . "<br>";
            return false;
        }
    }

    public static function TraerTodos() : array
    {
        $usuarios = array();

        try
        {
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test", "root",""); 
            $sql = $pdo->query("SELECT * 
            FROM usuarios u
            INNER JOIN perfiles p ON u.id_perfil = p.id;");
            
            if($sql != false)
            {
                $retorno = $sql->fetchAll();
                if($retorno != false)
                {                
                    foreach($retorno as $fila)
                    {
                        $user = new Usuario($fila[0],$fila[3],$fila[1],$fila[2],$fila[4],$fila[6]);       
                        $usuarios[] = $user;      
                    }
                }
            }

        }catch(PDOException $exc)
        {
            echo $exc->getMessage() . "<br>";
        }

        return $usuarios;
    }

   /* public static function TraerUno(string $correo, string $clave)
    {  
        try
        {
             
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test", "root",""); 

            $sql = $pdo->prepare("SELECT u.id, u.correo, u.clave, u.nombre, u.id_perfil, p.descripcion
            FROM usuarios u
            INNER JOIN perfiles p ON u.id_perfil = p.id
            WHERE u.clave = :clave AND u.correo = :correo;");

            $sql->bindParam(":clave",$clave, PDO::PARAM_STR,20);
            $sql->bindParam(":correo",$correo, PDO::PARAM_STR,30);

            if($sql->execute())
            {
                echo "todo ok";
                $fila = $sql->fetch(PDO::FETCH_ASSOC);
                $user = new Usuario($fila['id'],$fila['nombre'],$fila['correo'],$fila['clave'],$fila['id_perfil'],$fila['descripcion']);  
               

            }else{echo "todo no ok";}
               
        }catch(PDOException $exc)
        {
            echo $exc->getMessage() . "<br>";
            return false;
        }

        return $user;
    }*/

    public static function TraerUno(string $correo, string $clave)
    {
       $array =  Usuario::TraerTodosJSON();

        foreach($array as $usuario)      
        {
            if($usuario['correo'] === $correo && $usuario['clave'] === $clave)
            {
                return new Usuario(0,$usuario['nombre'],$usuario['correo'],$usuario['clave'],0,0);
            }
        }
        return false;
    }

    public function Modificar() : bool
    {
        try
        {
             
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test", "root",""); 
            $sql = $pdo->prepare("UPDATE `usuarios` SET `correo`= :correo,
            `clave`=:clave,`nombre`=:nombre,`id_perfil`=:id_perfil WHERE id = :id");

            $sql->bindParam(":correo",$this->correo, PDO::PARAM_STR,30);
            $sql->bindParam(":clave",$this->clave, PDO::PARAM_STR,20);
            $sql->bindParam(":nombre",$this->nombre, PDO::PARAM_STR,20);
            $sql->bindParam(":id_perfil",$this->id_perfil, PDO::PARAM_INT);
            $sql->bindParam(":id",$this->id, PDO::PARAM_INT);

            if($sql->execute())
            {
                echo "todo ok";
                return true;
            }else
            {
                echo "todo no ok";
                return false;
            }
               
        }catch(PDOException $exc)
        {
            echo $exc->getMessage() . "<br>";
            return false;
        }

    }

    public static function Eliminar(int $id): bool
    {   
        try
        {
             
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test", "root",""); 
            $sql = $pdo->prepare("DELETE FROM `usuarios` WHERE id = :id");
            $sql->bindParam(":id",$id, PDO::PARAM_INT);

            if($sql->execute())
            {
                echo "todo ok";
                return true;
            }else
            {
                echo "todo no ok";
                return false;
            }
               
        }catch(PDOException $exc)
        {
            echo $exc->getMessage() . "<br>";
        }


    }

}