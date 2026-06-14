<?php
session_start();
require_once "../modelos/GestionProductos.php";
require_once "../modelos/GestionCategorias.php";
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $producto = GestionProductos::getProductoById($_GET["id"]);
    $categoria = GestionCategorias::getCategoriaById($producto->categoria_id);
} else {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="../styles.css" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <title><?= $producto->nombre ?></title>
</head>

<body>
    <?php require_once "../componentes/header.php"; ?>
    <div class="contenedor d-flex flex-wrap">

        <div class="product-layout col-12 text-center p-5">
            <div class="product-card d-flex flex-wrap">
                <div class="col-12 text-start mb-3"><a href="index.php" class="btn btn-primary btn-cart"><i class="bi bi-arrow-left"></i> Volver a la tienda</a></div>
                <div class="product-img col-6 shadow p-3">
                    <img src="../<?= $producto->imagen ?>" alt="">
                </div>
                <div class="product-body col-6 text-start p-3">
                    <div class="d-flex flex-wrap align-items-center">
                        <h2 class="col-6 fw-bold p-2"><?= $producto->nombre ?></h2>
                        <div class="col-6 p-2"><span class="badge rounded-pill text-bg-secondary mb-2 fs-4"><?= $categoria->nombre ?></span></div>
                        <p class="col-12 fs-4 p-2"><?= $producto->descripcion ?></p>
                    </div>

                    <div class="d-flex flex-wrap">
                        <div class="col-12 p-2"><span class="fs-4 fw-bold" style="color: green;"><?= $producto->precio ?> €</span></div>
                        <form action="../controller/agregarCarrito.php" method="POST">
                            <input type="hidden" name="id_producto" value="<?= $producto->id ?>">
                            <input type="hidden" name="pagina_detalle_producto" value="detalle_producto.php">
                            <div class="col-12 mt-3"><button type="submit" class="btn btn-primary btn-cart">Agregar al Carrito</button></div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>

</html>