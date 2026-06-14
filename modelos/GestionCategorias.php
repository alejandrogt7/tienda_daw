<?php
require_once "../env-bd/ConexionBD.php";
class GestionCategorias{
    public static function getCategoriaById($id){
        $conexion = ConexionBD::createConexion();
        $sql = "SELECT * FROM categorias where id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$id]);
        $categoria = $stmt->fetch(PDO::FETCH_OBJ);
        return $categoria;
    }
}