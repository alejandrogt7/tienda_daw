<?php
require_once "../env-bd/ConexionBD.php";
class GestionRoles
{

    public static function getRoles()
    {
        $conexion = ConexionBD::createConexion();
        $sql = "SELECT * FROM roles";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $roles = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $roles;
    }

    public static function getRoleById($id)
    {
        $conexion = ConexionBD::createConexion();
        $sql = "SELECT * FROM roles where id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$id]);
        $rol = $stmt->fetch(PDO::FETCH_OBJ);
        return $rol;
    }

    public static function createRole($rol)
    {
        $conexion = ConexionBD::createConexion();
        $sql = "INSERT INTO roles (rol) VALUES (?)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$rol]);
    }

    public static function updateRole($id, $rol)
    {
        $conexion = ConexionBD::createConexion();
        $sql = "UPDATE roles SET rol = ? WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$rol, $id]);
    }

    public static function deleteRole($id)
    {
        $conexion = ConexionBD::createConexion();
        $sql = "DELETE FROM roles WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$id]);
    }
}
