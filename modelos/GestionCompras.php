<?php
require_once "../env-bd/conexionbd.php";

class GestionCompras
{
    public static function realizarCompra($usuario_id, $total, $items_carrito)
    {
        $conexion = ConexionBD::createConexion();
        $fecha = date("Y-m-d H:i:s");

        try {
            // Inicio una transaccion por si falla a la minima algo y queremos hacer roll back
            $conexion->beginTransaction();

            $sql_compra = "INSERT INTO compras (usuario_id, fecha, total) VALUES (?, ?, ?)";
            $stmt_compra = $conexion->prepare($sql_compra);
            $stmt_compra->execute([$usuario_id, $fecha, $total]);

            // Obtengo el id de la compra recien insertada
            $compra_id = $conexion->lastInsertId();

            $sql_detalle = "INSERT INTO detalle_compras (compra_id, producto_id, cantidad, precio) VALUES (?, ?, ?, ?)";
            $stmt_detalle = $conexion->prepare($sql_detalle);

            foreach ($items_carrito as $item) {
                $stmt_detalle->execute([
                    $compra_id,
                    $item['id'],
                    $item['cantidad'],
                    $item['precio']
                ]);
            }

            // Confirmo la transaccion una vez ha ido todo bien
            $conexion->commit();
            return true;
        } catch (PDOException $e) {
            $conexion->rollBack();
            return false;
        } catch (Exception $e) {
            // Si hay cualquier otro error
            $conexion->rollBack();
            error_log("Error de PHP/Lógica en realizarCompra: " . $e->getMessage());
            return false;
        }
    }
}
