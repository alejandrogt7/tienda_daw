<?php
session_start();

function calcularTotal()
{
    $total = 0;
    if (!empty($_SESSION["carrito"])) {
        foreach ($_SESSION["carrito"] as $producto) {
            $total += $producto['precio'] * $producto['cantidad'];
        }
    }
    return $total;
}

if (isset($_POST['accion'])) {
    $id = $_POST['id'];
    switch ($_POST['accion']) {
        case 'aumentar':
            if ($_SESSION['carrito'][$id]["stock"] <= $_SESSION['carrito'][$id]['cantidad']) {
                $_SESSION["error"] = "No hay más stock de este producto";
                break;
            } else {
                $_SESSION['carrito'][$id]['cantidad'] += 1;
                unset($_SESSION["error"]);
            }
            break;
        case 'reducir':
            if ($_SESSION['carrito'][$id]['cantidad'] > 1) {
                $_SESSION['carrito'][$id]['cantidad'] -= 1;
                unset($_SESSION["error"]);
            }
            break;
        case 'eliminar':
            unset($_SESSION['carrito'][$id]);
            unset($_SESSION["error"]);
            break;
    }

    header("Location: detalles_carrito.php");
    exit();
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
    <title>Carrito</title>
</head>

<body>
    <?php require_once "../componentes/header.php"; ?>
    <div class="contenedor d-flex flex-wrap">
        <div class="col-12 text-start mt-3 ms-3"><a href="index.php" class="btn btn-primary btn-cart"><i class="bi bi-arrow-left"></i> Volver a la tienda</a></div>
        <table class="text-center table col-12">
            <th class="p-3">Imagen</th>
            <th class="p-3">Nombre</th>
            <th class="p-3">Cantidad</th>
            <th class="p-3">Precio</th>
            <th class="p-3">Categoria</th>
            <th class="p-3">Acciones</th>

            <?php
            if (!empty($_SESSION["carrito"])) {

                foreach ($_SESSION["carrito"] as $id => $producto) {
                    echo "<tr>";
                    echo "<td>" . $producto['nombre'] . "</td>";
                    echo "<td><img style='width: 50px;'  src='../" . $producto['imagen'] . "' alt='" . $producto['nombre'] . "'></td>";
                    echo "<td>" . $producto['cantidad'] . "</td>";
                    echo "<td>" . number_format($producto['precio'] * $producto['cantidad'], 2, ',', '.') . " €</td>";
                    echo "<td>" .  "<span class='badge rounded-pill text-bg-secondary mb-2'>" . $producto['categoria'] . "</span>" . "</td>";
                    //Aqui no se manda el post a ningun lado, es a la pagina misma en si
                    echo "<td>
                    <form method='post'>
                        <input type='hidden' name='id' value='$id'>
                        <button type='submit' name='accion' value='aumentar' class ='btn btn-primary btn-cart'><i class='bi bi-plus-circle-fill'></i></button>
                        <button type='submit' name='accion' value='reducir' class ='btn btn-primary btn-cart'><i class='bi bi-dash-circle-fill'></i></i></button>
                        <button type='submit' name='accion' value='eliminar' class ='btn btn-primary btn-cart'><i class='bi bi-trash-fill'></i></i></button>
                    </form>
                </td>";
                    echo "</tr>";
                }
            }

            ?>

        </table>
        <div class="col-12 text-start mt-3 ms-3 text-center">
            <div class="col-12">
                <span class="badge rounded-pill text-bg-secondary mb-2 fs-4 p-3">Total: <?= calcularTotal() ?> € </span>
            </div>
            <form action="">
                <input type="hidden" name="total" value="<?= calcularTotal() ?>">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Comprar
                </button>
            </form>
        </div>
    </div>

    <?php
    if (!isset($_SESSION["user"])) {
        $modal = <<<HTML
            <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel"><a href="login.php">No tan rapido! Necesita una cuenta</a></h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Para realizar la compra ha de de iniciar sesión, si no tiene una cuenta porfavor <a href="registro.php"><span class = "text-primary">registrate</span></a>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <a href="login.php" class="btn btn-primary">Iniciar Sesión</a>
                            </div>
                        </div>
                    </div>
                </div>
        HTML;
        echo $modal;
    } else {
        $user_id = $_SESSION["user"]["id"];
        $total = calcularTotal();
        $modal = <<<HTML
             <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">¿Desea realizar la compra?</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                    ¿Estás segur@ de realizar la compra?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <form action="../controller/realizar_pedido.php" method = "POST">
                                    <input type="hidden" name="user_id" value= "{$user_id}">
                                    <input type="hidden" name="total" value= "{$total}">
                                    <button class="btn btn-primary">Comprar</button>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
        HTML;
        echo $modal;
    }
    ?>



</body>

</html>