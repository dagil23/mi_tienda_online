<?php
include '../config/database.php';
include '../includes/funciones.php';
session_start();
if (isset($_SESSION['email'])) {
    if(!isAdmin($_SESSION['email'])){
        header("Location: ../public/index.php");
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
    <form action="">
        <label for="nombre_producto">Nombre</label>
        <input type="text" name="nombre_producto">
        <label for="categoria">Categoria</label>
        <select name="categoria" id="categoria">
            <option value="camisetas">Camisetas</option>
            <option value="pantalones">Pantalones</option>
            <option value="guantes">Guantes</option>
            <option value="sudaderas">Sudaderas</option>
            <option value="gorras">Gorras</option>
            <option value="chaquetas">Chaquetas</option>
            <option value="polos">Polos</option>
        </select>
        <label for="precio">Precio</label>
        <input type="number" step="0.1">
        <label for="text">Color</label>
        <input type="text">
    
    <!-- </form> Hay que hacerlo con una consulta de momento estamos practicando agregar productos -->
     <button type="submit">Agregar</button>
</body>
</html>