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
           header("Location: ../admin/productos.php");
        }
    }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar</title>
</head>

<body>
    <p>Escribe la palabra <strong>confirmacion</strong>  para eliminar el producto</p>
        <legend>Eliminar producto</legend>
        <form action="<?= $_SERVER["PHP_SELF"]  . "?id=" . $_GET["id"] ?>" method="post">
        <label for="confirmacion"></label>
        <input type="text" name="confirmacion" id="confirmacion">
        <button type="submit">Eliminar</button>
        </form>
        <?=$mensaje?>
    
</body>
</html>