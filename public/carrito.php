<?php
include '../config/database.php';
include '../includes/funciones.php';
include '../includes/header.php';
session_start();
$id_pedido = isset($_SESSION["id_pedido"]) ? (int)$_SESSION["id_pedido"] : null;
$total = floatval(sumOrdersUser($id_pedido));
$userOrders = getUserOrders($id_pedido); //Obtenemos las ordenes que ha realizado el usuario para luego mostralas
$id_producto = isset($_GET["id_producto"]) ? $_GET["id_producto"] : null;
echo $id_producto;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id_linea_pedido = getOrderLineId($id_pedido,$id_producto);
    if(isset($_POST["eliminar"])){ // Si el usuario a pulsado la opcion de eliminar
        $mensaje = deleteOrderLine($id_linea_pedido);//Eliminamos el producto y le mostramos un mensaje informativo
        header("Location: " . $_SERVER["PHP_SELF"]);//Redirigmos a la misma pagina para ver los cambios
    }elseif(isset($_POST["actualizar"]) && isset($_POST["cantidad"])){ //Si el usuario ha elegido una cantidad y a pulsado actualizar
        updateOrderLine($id_linea_pedido,$_POST["cantidad"]);//Actualizamos la linea de pedido con la nueva cantidad
        header("Location: " . $_SERVER["PHP_SELF"]);//Redirigmos a la misma pagina para ver los cambios
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/carrito.css">
    <title>Carrito</title>
</head>
<body>
    <!-- Si el usuario tiene pedidos se los mostramos -->
    <?php if (!empty($userOrders)): ?> 
    <h1>Tus Pedidos</h1>
    <table>
        <thead>
            <tr>
                <th>Talla</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Producto</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
    <?php foreach ($userOrders as $userOrder): ?>
        <tr>
            <td><?= htmlspecialchars($userOrder["talla"]) ?></td>
            <td>€<?= number_format($userOrder["precio_unitario"], 2) ?></td>
            <td>
                <!-- Formulario para ajustar la cantidad y actualizar -->
                <form action="<?= $_SERVER["PHP_SELF"] . "?id_producto=" . $userOrder["id_producto"] ?>" method="post" class="form-actualizar">
                    <input type="number" name="cantidad" value="<?= htmlspecialchars($userOrder["cantidad"]) ?>" min="1" max="50">
                    <button type="submit" class="btn-actualizar" name="actualizar">Actualizar</button>
                </form>
            </td>
            <td><img src="../assets/images/<?= htmlspecialchars($userOrder["imagen"]) ?>" alt="Imagen del producto"></td>
            <td>
                <!-- Formulario para eliminar producto -->
                <form action="<?= $_SERVER["PHP_SELF"] . "?id_producto=" . $userOrder["id_producto"] ?>" method="post" class="form-eliminar">
                    <button type="submit" class="btn-eliminar" name="eliminar">Eliminar</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>
    </table>
    <div class="total-container">
        <h2>Total a Pagar: €<?= number_format($total, 2) ?></h2>
        <button>Finalizar pedido</button>
    </div>
    <?=$mensaje?>
    <?php else:?>
        <h1>Tu carrito esta vacio</h1>
    <?php endif;?>
</body>
<?php include '../includes/footer.php'; ?>
</html>




