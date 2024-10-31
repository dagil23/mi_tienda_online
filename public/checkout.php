<?php
include '../config/database.php';
include '../includes/funciones.php';
include '../includes/header.php';
session_start();
if(isset($_SESSION["email"])){
    $id_pedido = $_GET["id"];
    echo $id_pedido;
    $userOrder = getUserOrders($id_pedido);
    $email  = $_SESSION["email"];
    $nombre  = $_SESSION["nombre"];
    $nombre  = $_SESSION["nombre"];
    $id_usuario = $_SESSION["id_usuario"];
    $apellido = $_SESSION["apellido"];
    $email = $_SESSION["email"];
    $dni = $_SESSION["dni"];
    $direccion = $_SESSION["direccion"];
    $telefono = $_SESSION["telefono"];
    $precio_total = $_SESSION["total"];


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
        <form action="">
            
        <h5>Informacion de contacto</h5>
        <label for="email">Email</label>
        <input type="text" id="email">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre">
        <label for="apellido">Apellido</label>
        <input type="text" name="apellido" id="apellido">
        <label for="dni">DNI</label>
        <input type="text" id="dni" name="dni">
        <h5>Direccion de envio</h5>
        <label for="direccion">Direccion</label>
        <input type="text" id="direccion">
        </form>

        <div class="deatails-info">
            <h5>Detalles del pedido</h5>
            <?php foreach ($userOrders as $userOrder):?> 
             <p>E</p>
            <?php endforeach; ?>
            <h2>Total <?=$precio_total ?></h2>
        </div>
        </body>
        <?php  include '../includes/footer.php'; ?>
</html>