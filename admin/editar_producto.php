<?php
session_start();
include '../includes/funciones.php';
if (!isset($_SESSION["email"]) || !isAdmin($_SESSION["email"])) {
    header("Location: ../public/index.php");
    exit;
}

$id_producto = isset($_GET["id"]) ? $_GET["id"] : null;
$producto = getProductos($id_producto);
$categorias = getCategorias();
$errores = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_producto = !empty($_POST["nombre"]) ? $_POST["nombre"] : $producto["nombre_producto"];
    $precio = !empty($_POST["precio"]) ? $_POST["precio"] : $producto["precio"];
    $color = !empty($_POST["color"]) ? $_POST["color"] : $producto["color"];
    $cantidad = !empty($_POST["cantidad"]) ? $_POST["cantidad"] : $producto["cantidad_stock"];
    $categoria = !empty($_POST["id_categoria"]) ? $_POST["id_categoria"] : $producto["id_categoria"];
    $descripcion = !empty($_POST["descripcion"]) ? $_POST["descripcion"] : $producto["descripcion"];

    if (!empty($_FILES["imagen"]["name"])) {
        if (!verifyImage($_FILES["imagen"])) {
            $errores[] = "Formato de imagen incorrecto";
        } else {
            $pathImages = "../assets/images/" . basename($_FILES["imagen"]["name"]);
            if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $pathImages)) {
                $imagen = $_FILES["imagen"]["name"];
            } else {
                $errores[] = "Error al subir la imagen";
                $imagen = $producto["imagen"];
            }
        }
    } else {
        $imagen = $producto["imagen"];
    }

    // Si no hay errores, proceder con la actualización
    if (empty($errores)) {
        if (updateProducto($id_producto, $nombre_producto, $precio, $cantidad, $color, $descripcion, $imagen, $categoria)) {
            header("Location: ../admin/productos.php?action=edit");
            exit;
        } else {
            $errores[] = "Error al actualizar el producto";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/productos.css">
    <title>Editar Producto</title>
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

    <?php if (!empty($errores)): ?>
        <div class="mensaje-error">
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . htmlspecialchars($_GET["id"]) ?>" method="post" enctype="multipart/form-data">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($producto["nombre_producto"]) ?>">
        
        <label for="precio">Precio</label>
        <input type="number" name="precio" step="0.1" value="<?= htmlspecialchars($producto["precio"]) ?>">
        
        <label for="color">Color</label>
        <input type="text" name="color" value="<?= htmlspecialchars($producto["color"]) ?>">
        
        <label for="imagen">Imagen</label>
        <input type="file" name="imagen">
        
        <label for="cantidad">Cantidad</label>
        <input type="number" name="cantidad" id="cantidad" value="<?= htmlspecialchars($producto["cantidad_stock"]) ?>">
        
        <label for="categoria">Categoría</label>
        <select name="id_categoria" id="categoria">
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?= htmlspecialchars($categoria["id_categoria"]) ?>" <?= $categoria["id_categoria"] == $producto["id_categoria"] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($categoria["nombre"]) ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <label for="descripcion">Nueva Descripción del producto</label>
        <textarea name="descripcion" id="descripcion" rows="4" cols="50"><?= htmlspecialchars($producto["descripcion"]) ?></textarea>
        
        <button type="submit" class="btn-producto">Guardar Cambios</button>
    </form>
</body>

</html>
