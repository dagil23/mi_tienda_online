<?php
include '../includes/funciones.php';
$id_categoria = isset($_GET["id"]) ? $_GET["id"] : null;
$confirmar = "confirmacion";
$mensaje = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["cofirmacion"]) && $_POST["confirmacion"] == $confirmar){
            $mensaje = deleteCategoria($id_categoria) ? "Categoria eliminada" : "Error al eliminar la categoria";
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/categoria.css">
    <title>Document</title>
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