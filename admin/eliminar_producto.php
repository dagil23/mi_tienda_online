<?php
session_start();
include '../includes/funciones.php';
if(!isset($_SESSION["email"]) || !isAdmin($_SESSION["email"])){
    header("Location: ../public/index.php");
    exit;
}
$id_producto = isset($_GET["id"]) ? $_GET["id"] : null;
$confirmar = "confirmacion";
$mensaje = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["confirmacion"]) && $_POST["confirmacion"] == $confirmar){    
           $mensaje = deleteProduct($id_producto) ? "Producto eliminado" : "Error al eliminar el producto";
        }
    }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/productos.css">
    <title>Eliminar</title>
</head>
    <header>
        <nav>
            <ul>
                <li> <a href="../admin/index.php">Inicio</a></li>
            </ul>
        </nav>
    </header>
<body>
    <div class="eliminar_producto">
        <p>Escribe la palabra <strong>confirmacion</strong>  para eliminar el producto</p>
    <form action="<?= $_SERVER["PHP_SELF"]  . "?id=" . $_GET["id"] ?>" method="post">
        <label for="confirmacion"></label>
        <input type="text" name="confirmacion" id="confirmacion">
        <button type="submit">Eliminar</button>
        </form>
        <?php if(!empty($mensaje)):?>
        <p id="mensaje_eliminacion"><?=$mensaje?></p>
        <?php endif;?>
    </div>
</body>
</html>