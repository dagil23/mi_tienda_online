<?php
session_start();
include '../includes/funciones.php';
if(!isset($_SESSION["email"]) || !isAdmin($_SESSION["email"])){
    header("Location: ../public/index.php");
    exit;
}
$id_producto = isset($_GET["id"]) ? $_GET["id"] : null;
$producto = getProductos($id_producto);
$categorias = getCategorias();
$errores = array();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        $nombre_producto = !empty($_POST["nombre"]) ? $_POST["nombre"] : $producto["nombre_producto"];
        $precio = !empty($_POST["precio"]) ? $_POST["precio"] : $producto["precio"];
        $color = !empty($_POST["color"]) ? $_POST["color"] : $producto["color"];
        $cantidad = !empty($_POST["cantidad"]) ? $_POST["cantidad"] : $producto["cantidad_stock"];
        $categoria = !empty( $_POST["id_categoria"]) ? $_POST["id_categoria"] : $producto["id_categoria"];
        $descripcion = !empty( $_POST["descripcion"]) ? $_POST["descripcion"] : $producto["descripcion"];

        if(!empty($_FILES["imagen"]["name"])){

            $pathImages = "../assets/images/" . basename($_FILES["imagen"]["name"]);
            if(move_uploaded_file($_FILES["imagen"]["tmp_name"], $pathImages )){
                $imagen = $_FILES["imagen"]["name"];
            }else{
                echo "error al subir la imagen";
                $imagen = $producto["imagen"];
            }
        }else{
            $imagen = $producto["imagen"];
        }
        if(!verifyImage($_FILES["imagen"])){
            $error [] = "Formato de imagen incorrecto"; 
        }
        if(!empty($error)){

            if(updateProducto( $id_producto,$nombre_producto, $precio, $cantidad, $color, $descripcion,$imagen, $categoria)){
                header("Location: ../admin/productos.php?action=edit");
            }
        }else{
            echo "Error al actualizar el producto";
        }
        
    }
?>
<!-- <!DOCTYPE html> -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/productos.css">
    <title>Document</title>
</head>
<body>
<header>
        <nav class="barra-navegacion">
            <ul>
                <li><a href="../admin/index.php">Inicio</a></li>
                <li><a href="../admin/productos.php">Agregar</a></li>
            </ul>
        </nav>
    </header>
    <h1>Editar Productos</h1>
    <form action="<?= $_SERVER["PHP_SELF"] . "?id=" . $_GET["id"] ?>" method="post" enctype="multipart/form-data">
        <label for="nombre"> Nombre</label>
        <input type="text" name="nombre" id="nombre" value="<?=$producto["nombre_producto"]?>">
        <label for="precio">Precio</label>
        <input type="number" name="precio" step="0.1" value="<?=$producto["precio"]?>">
        <label for="text"> Color</label>
        <input type="text" name="color" value="<?=$producto["color"]?>">
        <label for="imagen"> Imagen</label>
        <input type="file" name="imagen">
        <label for="cantidad"> Cantidad</label>
        <input type="number" name="cantidad" id="cantidad" value="<?=$producto["cantidad_stock"]?>">
        <label for="categoria"> Categoria</label>
        <select name="id_categoria" id="categoria">
            <?php foreach($categorias as $categoria): ?>
                <?php if($categoria["id_categoria"] == $producto["id_categoria"]): ?>
            <option value="<?=$categoria["id_categoria"] ?>"><?=$categoria["nombre"]?></option>
            <?php else: ?>
            <option value="<?=$categoria["id_categoria"] ?>"><?=$categoria["nombre"]?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        <label for="descripcion">Nueva Descripcion del producto</label>
        <textarea name="descripcion" id="descripcion" rows="4" cols="50" value="<?= $producto["descripcion"] ?>"></textarea>
        <button type="submit">Guardar Cambios</button>   
    </form>
</body>
</html>