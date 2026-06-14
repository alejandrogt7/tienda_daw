<?php
require_once "../modelos/GestionCompras.php";
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: ../public/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_SESSION["user"]["id"];
    $carrito = $_SESSION["carrito"] ?? [];

    if (empty($carrito)) {
        header("Location: ../public/index.php");
        exit();
    }

    $total_calculado = 0;
    foreach ($carrito as $item) {
        $total_calculado += $item['precio'] * $item['cantidad'];
    }

    if (GestionCompras::realizarCompra($user_id, $total_calculado, $carrito)) {
        unset($_SESSION["carrito"]);
        header("Location: ../public/index.php");
        exit();
    } else {
        echo "Algo ha fallado";
    }
} else {
    header("Location: ../public/index.php");
    exit();
}
