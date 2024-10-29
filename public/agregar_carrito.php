<?php 

session_start();
include '../includes/funciones.php';
include '../includes/header.php';
$id_producto = isset($_GET["id"]) ? $_GET["id"] : null;
$errores = array();
$users = getInfoUser($_SESSION["email"]);
$tallas = ["S","M","L","XXL"];
$producto = getProductos($id_producto);
echo $_SESSION["email"];
if(isset($_SESSION["email"])){//Verifico si el usuario tiene una cuenta
    $user = getInfoUser($_SESSION["email"]);//Obtenemos toda la informacion de nuestro usuario
    $id_pedido = existsOrderCart($user["id_usuario"]);//Si el usuario tiene un pedido en estado carrito lo obtemos mediante la funcion 
    $_SESSION["id_pedido"] = $id_pedido; // Guardamos el id del pedido para poder usarlo en otras paginas
    if($_SERVER["REQUEST_METHOD"] == "POST"){ // Verificamos si recibimos peticiones mediante post
        $precio_total = $_POST["cantidad"] * $producto["precio"];
        $talla = $_POST["talla"];
        if($id_pedido){ // Si existe el pedido en estado carrito, agregamos una nueva linea de pedido relacionada con el pedido del usuario 

            addOrderLine($id_pedido,$id_producto,$talla,$producto["precio"],$_POST["cantidad"]); // Creamos una nueva linea de pedido, relacionada con el mismo pedido que ya tenia el usuario 
        }else {
            //Si no existe el pedido creamos uno nuevo en estado carrito
            $id_pedido_nuevo = addOrder($user["id_usuario"],$user["dni"],$precio_total,$user["nombre"],$user["apellido"],"carrito",$user["direccion"]);
            addOrderLine($id_pedido_nuevo,$id_producto,$talla,$producto["precio"],$_POST["cantidad"]);
        }
    }
}else{
    header("Location: ../public/logig.php"); //Si no tiene cuenta o no a iniciado sesion lo redirigimos al login
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Producto para agregar al carrito</h1>
    <div class="tarjeta_producto">
        <form action="<?= $_SERVER["PHP_SELF"] . "?id=" . $producto["id_producto"]?>" method="post">
    <img src="../assets/images/<?=$producto["imagen"]?>"alt="imagen producto" width="300px" height="300px">
    <div class="detalles_producto">
        <h4>Nombre del Producto</h4>
        <p><?=$producto["nombre_producto"]?></p>
        <label for="talla">Selecciona una talla</label>
        <select name="talla" id="talla">
            <?php foreach($tallas as $talla):?>
            <option value="<?=$talla?>"><?=$talla?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="precio">
        <p>Precio €<?=$producto["precio"]?></p>
        <label for="cantidad">Cantidad</label>
        <input type="number" step="1" name="cantidad" max = "<?=$producto["cantidad_stock"]?>">
        <button type="submit">Agregar</button>
    </div>
</form>
    </div>
    <?php if(!empty($errores)):?>
    <?= implode(" ", $errores)?>
    <?php endif?>
    <?php if(!empty($mensaje)):?>
    <?=$mensaje?>
    <?php endif?>
</body>
<?php include '../includes/footer.php';?>
</html>