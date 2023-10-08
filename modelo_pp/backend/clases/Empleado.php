<?php

require_once "ICRUD.php";
require_once "Usuario.php";

class Empleado extends Usuario
{
    public array $foto;
    public int $sueldo;

    public function __construct($id, $nombre,$correo,$clave,$idperfil, $perfil, $foto, $sueldo)
    {
        parent::__construct($id, $nombre,$correo,$clave,$idperfil, $perfil);
        $this->foto = $foto;
        $this->sueldo = $sueldo;
    }
    
    public function getSueldo() {
        return $this->sueldo;
    }

    public function getFoto() {
        return $this->foto;
    }
   public static function TraerTodos():array
    {
        $usuarios = array();

        try
        {
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test", "root",""); 
            $sql = $pdo->query("SELECT * 
            FROM empleados e
            INNER JOIN perfiles p ON e.id_perfil = p.id;");
            
            if($sql != false)
            {
                $retorno = $sql->fetchAll();
                if($retorno != false)
                {                
                    foreach($retorno as $fila)
                    {
                        $foto = array();
                        $foto[] = $fila[5];

                        
                        $user = new Empleado(intval($fila[0]),$fila[3],$fila[1],$fila[2],intval($fila[4]),$fila[7],$foto,intval($fila[6]));   

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
   

    public function Agregar():bool 
    {
        try
        {
            $destinoCarpeta = "./empleados/fotos/";
            $pathImage = $this->foto["name"];
            $destino = $destinoCarpeta . $pathImage;
            $tipoArchivo = pathinfo($destino, PATHINFO_EXTENSION);
            $destino = $destinoCarpeta . "{$this->nombre}.{$tipoArchivo}";
            move_uploaded_file($this->foto["tmp_name"] , $destino);

            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test", "root",""); 
            $sql = $pdo->prepare("INSERT INTO `empleados`(`correo`, `clave`, `nombre`, `id_perfil`,`foto`,`sueldo`)
             VALUES (:correo,:clave,:nombre,:id_perfil,:foto,:sueldo)");

            $sql->bindParam(":correo",$this->correo, PDO::PARAM_STR,30);
            $sql->bindParam(":clave",$this->clave, PDO::PARAM_STR,20);
            $sql->bindParam(":nombre",$this->nombre, PDO::PARAM_STR,20);
            $sql->bindParam(":id_perfil",$this->id_perfil, PDO::PARAM_INT);
            $sql->bindParam(":foto",$destino, PDO::PARAM_STR,30);
            $sql->bindParam(":sueldo",$this->sueldo, PDO::PARAM_INT);

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

    public function Modificar():bool
    {
        try
        {
            $destinoCarpeta = "./empleados/fotos/";
            $pathImage = $this->foto["name"];
            $destino = $destinoCarpeta . $pathImage;
            $tipoArchivo = pathinfo($destino, PATHINFO_EXTENSION);
            $destino = $destinoCarpeta . "{$this->nombre}.{$tipoArchivo}";
            move_uploaded_file($this->foto["tmp_name"] , $destino);

            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test", "root",""); 
            $sql = $pdo->prepare("UPDATE `empleados` SET `correo`= :correo,
            `clave`=:clave,`nombre`=:nombre,`id_perfil`=:id_perfil,`foto`=:foto,`sueldo`=:sueldo WHERE id = :id");

            $sql->bindParam(":correo",$this->correo, PDO::PARAM_STR,30);
            $sql->bindParam(":clave",$this->clave, PDO::PARAM_STR,20);
            $sql->bindParam(":nombre",$this->nombre, PDO::PARAM_STR,20);
            $sql->bindParam(":id_perfil",$this->id_perfil, PDO::PARAM_INT);
            $sql->bindParam(":id",$this->id, PDO::PARAM_INT);
            $sql->bindParam(":foto",$destino, PDO::PARAM_STR,30);
            $sql->bindParam(":sueldo",$this->sueldo, PDO::PARAM_INT);


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

    public static function Eliminar($id):bool
    {
        try
        {       
            $pdo = new PDO("mysql:host=localhost;dbname=usuarios_test", "root",""); 
            $sql = $pdo->prepare("DELETE FROM `empleados` WHERE id = :id");
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
