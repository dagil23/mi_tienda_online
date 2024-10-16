<?php
include '../includes/funciones.php';
$id_producto = $_GET["id"];
$producto = getProductos($id_producto);
$categorias = getCategorias();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/productos.css">
    <title>Document</title>
</head>
<body>
    <h1>Aqui voy a editar los productos con un formulario</h1>
    <p><?=$id_producto?></p>

    <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="post">
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
        <textarea name="descripcion" id="descripcion" rows="4" cols="50"></textarea>
        <button type="submit">Guardar Cambios</button>

        <?= var_dump($producto) ?>
        
    </form>
</body>
</html>