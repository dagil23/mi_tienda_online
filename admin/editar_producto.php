<?php

$id_producto = $_GET["id"]

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

    <form action="">
        <label for="nombre">Nuevo nombre</label>
        <input type="text" name="nombre" id="nombre">
        <label for="categoria">Nueva Categoria</label>
        <input type="text" name="categoria" id="categoria">
        <label for="precio">Nuevo Precio</label>
        <input type="number" name="precio" step="0.1">
        <label for="text"> Nuevo Color</label>
        <input type="text" name="color">
        <label for="imagen">Nueva Imagen</label>
        <input type="file" name="imagen">
        <label for="cantidad">Nueva Cantidad</label>
        <input type="number" name="cantidad" id="cantidad">
        <label for="descripcion">Nueva Descripcion del producto</label>
        <textarea name="descripcion" id="descripcion" rows="4" cols="50"></textarea>
        <button type="submit">Agregar</button>
        
    </form>
</body>
</html>