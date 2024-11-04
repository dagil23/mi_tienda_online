<?php
include '../config/database.php';
include '../includes/header.php';
$id_pedido = isset($_GET["id"]) ? $_GET["id"] : null;
$_SESSION["id"] = $id_pedido;
$userOrders = getUserOrders($id_pedido);
$total = floatval(sumOrdersUser($id_pedido));
$statusOrder = getOrderStatus($id_pedido);
$errores = array();
$estado_pago = $_GET['estado'] ?? null;
$mostrarFormularioPago = false;

if (!isset($_SESSION["email"])) {
    header("Location: ../public/login.php");
    exit;
}
if ($statusOrder === "procesado") {
    $mostrarFormularioPago = false;
} else {
    $mostrarFormularioPago = true;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["checkout"]) && $statusOrder == "carrito") {
    $email = $_SESSION["email"] ?? $_POST["email"];
    $nombre = $_SESSION["nombre"] ?? $_POST["nombre"];
    $id_usuario = $_SESSION["id_usuario"];
    $apellido = $_SESSION["apellido"] ?? $_POST["apellido"];
    $dni = $_SESSION["dni"] ?? $_POST["dni"];
    $direccion = $_SESSION["direccion"] ?? $_POST["direccion"];
    $telefono = $_SESSION["telefono"] ?? $_POST["telefono"];

    if (!verifyDNI($dni)) {
        $errores[] = "Formato de DNI incorrecto";
    }

    if (empty($errores)) {
        $mostrarFormularioPago = true;
        $statusOrder = "checkout_iniciado";
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["pago"]) && ($statusOrder == "carrito" || $statusOrder == "checkout_iniciado")) {
    if (!verifyCardNumber($_POST["num_tarjeta"])) {
        $errores[] = "El número de la tarjeta no es válido";
    }
    if (!verifyCVV($_POST["cvv"])) {
        $errores[] = "El CVV no es válido";
    }
    if (!verifyExpirationDate($_POST["fecha_expiracion"])) {
        $errores[] = "La fecha de expiración no es válida";
    }

    if (empty($errores)) {
        $estado_pago = "aprobado";
        if (updateOrder($_SESSION["id"], $total, "procesado")) {
            header("Location: " . $_SERVER["PHP_SELF"] . "?estado=aprobado&id=" . $id_pedido);
            exit;
        } else {
            $errores[] = "Hubo un problema al actualizar el pedido.";
        }
    } else {
        $estado_pago = "rechazado";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/checkout.css">
    <title>Checkout</title>
</head>
<body>
    <div class="container">
        <?php if (!$estado_pago && $mostrarFormularioPago && $statusOrder == "carrito"): ?>
            <!-- Formulario de checkout -->
            <h2 class="section-title">Datos del pedido</h2>
            <form action="<?= $_SERVER["PHP_SELF"] ?>?id=<?= $id_pedido ?>" method="post" class="checkout-form">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" required>
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" name="apellido" id="apellido" required>
                </div>
                <div class="form-group">
                    <label for="dni">DNI</label>
                    <input type="text" id="dni" name="dni" required>
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" id="direccion" name="direccion" required>
                </div>
                <button type="submit" name="checkout" class="button-primary">Pagar</button>
            </form>

            <div class="pedido-container">
                <h2>Resumen de tu Pedido</h2>
                <div class="productos-carrusel">
                    <?php foreach ($userOrders as $userOrder): ?>
                        <div class="producto-card-carrusel">
                            <img src="../assets/images/<?= htmlspecialchars($userOrder["imagen"]) ?>" alt="Imagen del producto">
                            <div class="producto-info">
                                <h3><?= htmlspecialchars($userOrder["nombre_producto"]) ?></h3>
                                <p>Talla: <?= htmlspecialchars($userOrder["talla"]) ?></p>
                                <p>Cantidad: <?= htmlspecialchars($userOrder["cantidad"]) ?></p>
                                <p>Precio: €<?= number_format($userOrder["precio_unitario"], 2) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="total-pedido">
                    <h3>Total a Pagar: €<?= number_format($total, 2) ?></h3>
                </div>
            </div>
        <?php elseif (!$estado_pago && $statusOrder === "checkout_iniciado"): ?>
            <div class="pago-container">
                <h2 class="section-title">Detalles de Pago</h2>
                <form action="<?= $_SERVER["PHP_SELF"] . "?id=" . $_GET["id"] ?>" method="post" class="form-pago">
                    <div class="form-group">
                        <label for="num_tarjeta">Número de Tarjeta</label>
                        <input type="text" id="num_tarjeta" name="num_tarjeta" placeholder="1234 5678 9012 3456" required>
                    </div>
                    <div class="form-group">
                        <label for="nombre_tarjeta">Nombre en la Tarjeta</label>
                        <input type="text" id="nombre_tarjeta" name="nombre_tarjeta" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_expiracion">Fecha de Expiración</label>
                        <input type="text" id="fecha_expiracion" name="fecha_expiracion" placeholder="MM/YY" required>
                    </div>
                    <div class="form-group">
                        <label for="cvv">CVV</label>
                        <input type="text" id="cvv" name="cvv" placeholder="123" required>
                    </div>
                    <button type="submit" name="pago" class="button-primary">Confirmar Pago</button>
                </form>
            </div>
        <?php else: ?>
            <div class="confirmacion-container">
                <?php if ($estado_pago === "aprobado"): ?>
                    <h2 class="section-title">Pago Exitoso</h2>
                    <p>Gracias por tu compra. Tu pedido ha sido procesado con éxito.</p>
                <?php else: ?>
                    <h2 class="section-title">Pago Rechazado</h2>
                    <div class="error-container">
                        <?php foreach ($errores as $err): ?>
                            <p class="error-message"><?= $err ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
