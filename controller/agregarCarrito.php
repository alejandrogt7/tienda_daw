<?php
session_start();

require_once "../modelos/GestionProductos.php";
require_once "../modelos/GestionCategorias.php";

if (!isset($_SESSION["carrito"])) {
    $_SESSION["carrito"] = [];
}

if (isset($_POST["pagina_detalle_producto"])) {
    $pagina_detalle_producto = $_POST["pagina_detalle_producto"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id_producto"];

    $producto_agregar = GestionProductos::getProductoById($id);
    $categoria = GestionCategorias::getCategoriaById($producto_agregar->categoria_id);

    if (isset($_SESSION["carrito"][$producto_agregar->id])) {
        $_SESSION["carrito"][$producto_agregar->id]["cantidad"] += 1;
    } else {
        $_SESSION["carrito"][$producto_agregar->id] = [
            "id" => $producto_agregar->id,
            "nombre" => $producto_agregar->nombre,
            "precio" => $producto_agregar->precio,
            "categoria" => $categoria->nombre,
            "imagen" => $producto_agregar->imagen,
            "stock" => $producto_agregar->stock,
            "cantidad" => 1
        ];
    }

    if (isset($pagina_detalle_producto)) {
        header("Location: ../public/detalle_producto.php?id=" . $id);
        exit();
    } else {
        header("Location: ../public/index.php");
        exit();
    }
}
