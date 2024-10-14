<?php
include '../config/database.php';
include '../includes/funciones.php';
session_start();
$categorias = getCategorias();
if (isset($_SESSION['email'])) {
    if (!isAdmin($_SESSION['email'])) {
        header("Location: ../public/index.php");
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_POST["categoria"]) && isset($_POST["precio"]) && isset($_POST["color"]) && isset($_POST["imagen"])) {

    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
</head>

<body>
    <h1>Productos</h1>
    <form action="" method="post">
        <label for="nombre_producto">Nombre</label>
        <input type="text" name="nombre_producto"><br>
        <label for="categoria">Categoria</label>
            <select name="categoria" id="categoria">
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?= htmlspecialchars($categoria) ?>"> <?= htmlspecialchars($categoria) ?></option>
                <?php endforeach; ?>
            </select>
            <label for="precio">Precio</label>
            <input type="number" name="precio" step="0.1"><br>
            <label for="text">Color</label>
            <input type="text" name = "color"><br>
            <label for="imagen">Imagen</label>
            <input type="file" name="imagen">
            <label for="cantidad">Cantidad</label>
            <input type="number" name="cantidad" id ="cantidad">
            <label for="descripcion">Descripcion del producto</label>
            <textarea name="descripcion" id="descripcion" ></textarea>
            <input type="">
            <button type="submit">Agregar</button>
</body>

</html>