<?php

require_once "env.php";
class ConexionBD{
    
    private static $conexion;

    //*Creamos la conexion mediante PDO y si ya existe la devolvemos
    public static function createConexion(){
        if (self::$conexion == null) {
            try{
                self::$conexion = new PDO($_ENV["dsn"],$_ENV["user"],$_ENV["pass"]);
    
            }catch(PDOException $e){
                echo "Error de Conexión " . $e->getMessage();
                die();
            }
        }
        return self::$conexion;
    }
}