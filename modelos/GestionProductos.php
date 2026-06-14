<?php
require_once "../env-bd/ConexionBD.php";
class GestionProductos{
    public static function getProductoById($id){
        $conexion = ConexionBD::createConexion();
        $sql = "SELECT * FROM productos where id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$id]);
        $producto = $stmt->fetch(PDO::FETCH_OBJ);
        return $producto;
    }

    public static function getAllProductos(){
        $conexion = ConexionBD::createConexion();
        $sql = "SELECT * FROM productos";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $producto = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $producto;
    }
}