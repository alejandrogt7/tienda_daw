<?php
require_once "../env-bd/ConexionBD.php";
class GestionUsuarios
{

    public static function getUsuarioById($id)
    {
        $conexion = ConexionBD::createConexion();
        $sql = "SELECT * FROM usuarios where id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$id]);
        $usuario = $stmt->fetch(PDO::FETCH_OBJ);
        return $usuario;
    }

    public static function createUser($user, $email, $pass, $rol_id = 3)
    {
        $fecha_actual = date('Y-m-d h-i-s');
        $conexion = ConexionBD::createConexion();
        $sql = "INSERT INTO usuarios (nombre, email, password, rol_id, fecha_registro) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$user, $email, $pass, $rol_id, $fecha_actual]);
    }

    public static function emailExist($email)
    {
        $conexion = ConexionBD::createConexion();
        $sql = "select email from usuarios where email = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$email]);
        $resultado = $stmt->fetch();


        //? Esto se supone que devuelve un booleano
        return $resultado ? true : false;
    }


    public static function verifyEmailAndPassword($email, $pass)
    {
        $conexion = ConexionBD::createConexion();
        $sql = "SELECT id,nombre,email,rol_id FROM usuarios WHERE email = ? AND password = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$email, hash("sha256", $pass)]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        return $usuario;
    }
}
