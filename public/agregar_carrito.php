<?php 

session_start();
include '../includes/funciones.php';
include '../includes/header.php';
$id_producto = isset($_GET["id"]) ? $_GET["id"] : null;
$errores = array();
$users = getInfoUser($_SESSION["email"]);
$tallas = ["S","M","L","XXL"];
$producto = getProductos($id_producto);

if(isset($_SESSION["email"])){
    echo "hverificacion iniciada";

$user = getInfoUser($_SESSION["email"]);
$id_pedido = existsOrderCart($user["id_usuario"]);
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        echo "entrando a post";

        $cantidad = isset($_POST["cantidad"]) ? intval($_POST["cantidad"]) : 0;
        $talla = isset($_POST["talla"]) ? $_POST["talla"] : "";
        if($cantidad > $producto["cantidad_stock"]){
            $errores [] = "¡Ups! Solo nos quedan " . $producto["cantidad_stock"] ." en stock. Por favor, ajusta tu cantidad";
           exit;
        }
        $id_usuario = $user["id_usuario"];
        $dni = $user["dni"];
        $precio_total = $producto["precio"] * $cantidad;
        $nombre = $user["nombre"];
        $apellidos = $user["apellido"];
        $estado = "carrito";
        $direccion = $user["direccion"];

        if($id_pedido){
            echo $id_pedido;
            // updateOrder($id_pedido,$precio_total,$estado,$direccion);
            $id_linea_pedido = getOrderLineId($id_pedido,$producto["id_producto"]);
            if($id_linea_pedido){

                echo var_dump($id_linea_pedido);
                echo var_dump($cantidad);
                updateOrderLine($id_linea_pedido,$cantidad);
            }else{
                addOrderLine($id_pedido,$id_producto,$talla,$precio,$cantidad);
            }
         
    }else{
        echo "hola";
        echo var_dump($id_pedido);
        $id_pedido =  addOrder($id_usuario,$dni,$precio_total,$nombre,$apellidos,$estado,$direccion);
        addOrderLine($id_pedido,$producto["id_producto"],$talla,$producto["precio"],$cantidad);
    }
}

}else{
    header("Location: ../public/index.php");
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
        <form action="<?= $_SERVER['PHP_SELF'] . "?id=" . $id_prodcuto ?>" method="post">
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
    </div>
    <button type="submit">Agregar</button>
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