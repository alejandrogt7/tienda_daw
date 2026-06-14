<?php
session_start();
require_once "../modelos/GestionProductos.php";
require_once "../modelos/GestionCategorias.php";

$misProductos = GestionProductos::getAllProductos();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PCGarden</title>
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

</head>

<body>
  <?php require_once "../componentes/header.php"; ?>

  <div class="d-flex flex-wrap ">
    <?php
    foreach ($misProductos as $producto) {
      $categoria = GestionCategorias::getCategoriaById($producto->categoria_id);
      $stock_css = ($producto->stock) ? "text-bg-success" : "text-bg-danger";
      $detalle_producto = "detalle_producto.php?id=$producto->id";
      echo <<<HTML
      <div class ="col-3 p-5 d-flex flex-wrap text-center ">
        <div class="card product" style="width: 25rem;">
          <a href="$detalle_producto">
          <div class = "p-3 img-product"><img src="../$producto->imagen" class="card-img-top" alt="..."></div>
          <div class="card-body ">
            <h5 class="card-title">$producto->nombre</h5>
            <p class="card-text">$producto->descripcion</p>
            <p class="card-text">$producto->precio €</p>
            <div class = "d-flex flex-wrap justify-content-center">
              <span class="badge rounded-pill text-bg-secondary mb-2">$categoria->nombre </span>
            </div>
            <div class = "d-flex flex-wrap justify-content-center">
              <span class="badge rounded-pill $stock_css mb-2">Unidades disponibles: $producto->stock</span>
            </div>
            <form action="..\controller\agregarCarrito.php" method ="POST">
                <input type="hidden" name="id_producto" value="$producto->id">
                <button type="submit" class ="btn btn-primary btn-cart">Agregar al Carrito</button>
            </form>
          </div>
        </div>
        </a>
      </div>
      HTML;
    }
    ?>
  </div>
</body>

</html>