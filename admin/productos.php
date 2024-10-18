<?php
include '../config/database.php';
include '../includes/funciones.php';
session_start();
$productos = getProductos();
$categorias = getCategorias();
$mensaje = array();
$error = array();
$action = isset($_GET['action']) ? $_GET['action'] : 'add';
if (isset($_SESSION['email'])) {
    if (!isAdmin($_SESSION['email'])) {
        header("Location: ../public/index.php");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $campos = [
        'nombre_producto' => "Nombre del Producto",
        'categoria' => "Categoria",
        'precio' => "Precio",
        'color' => "Color",
        'cantidad' => "Cantidad",
        'descripcion' => "Descripcion"
    ];

    //Aqui estoy accediendo a a la propiedad de imagen[size] para saber si tiene un tamaño
    if ($_FILES["imagen"]["size"] == 0) {
        $error[] = "Debes de subir una imagen";
    }
    foreach ($campos as $campo => $nombreCampo) {
        if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
            $error[] = "El campo $nombreCampo no puede estar vacio";
        }
    }


    if (empty($error)) {   //Si no encontramos ningun error introducimos el producto

        $imagen = $_FILES["imagen"]["name"];
        $pathImages = "../assets/images" . basename($imagen);
        move_uploaded_file($_FILES["imagen"]["tmp_name"], $pathImages);

        $id_categoria = (int)$_POST["categoria"];
        $nombre = $_POST["nombre_producto"];
        $precio = $_POST["precio"];
        $color = $_POST["color"];
        $descripcion = $_POST["descripcion"];
        $cantidad = $_POST["cantidad"];

        $mensaje[] = addProduct($id_categoria, $nombre, $precio, $color, $descripcion, $imagen, $cantidad);
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/productos.css">
    <title>Productos</title>
</head>

<body>
    <header>
        <h1>Productos</h1>
        <nav class="barra-navegacion">
            <ul>
                <li><a href="?action=add">Agregar</a></li>
                <li><a href="?action=edit">Modificar</a></li>
                <li><a href="?action=delete">Eliminar</a></li>
            </ul>
        </nav>

    </header>
    <?php if($action == 'add'): ?>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="nombre_producto">Nombre</label>
        <input type="text" name="nombre_producto">
        <label for="categoria">Categoria</label>
        <select name="categoria" id="categoria">
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?= htmlspecialchars($categoria["id_categoria"]) ?>"> <?= htmlspecialchars($categoria["nombre"]) ?></option>
            <?php endforeach; ?>
        </select>
        <label for="precio">Precio</label>
        <input type="number" name="precio" step="0.1">
        <label for="text">Color</label>
        <input type="text" name="color">
        <label for="imagen">Imagen</label>
        <input type="file" name="imagen">
        <label for="cantidad">Cantidad</label>
        <input type="number" name="cantidad" id="cantidad">
        <label for="descripcion">Descripcion del producto</label>
        <textarea name="descripcion" id="descripcion" rows="4" cols="50"></textarea>
        <button type="submit">Agregar</button>

        <?php if (!empty($mensaje)): ?>
            <div class="mensaje-exito">
                <ul>
                    <?php foreach ($mensaje as $msg): ?>
                        <li id="valido"><?= $msg ?></li>
                        <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="mensaje-error">
                <ul>
                    <?php foreach ($error as $err): ?>
                        <li id="error"> <?= $err ?></li>
                        <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <?php elseif ($action == "edit"): ?>
            <h1>Editar</h1>
            <?php foreach($productos as $producto):?>
            <table border="1" cellpadding="10">
            <tbody>
                <tr>
                    <td>Id producto</td>
                    <td>Id Categoria</td>
                    <td>Precio</td>
                    <td>Color</td>
                    <td>Imagen</td> 
                    <td>Descripcion</td>
                    <td>Nombre</td>
                    <td>Cantidad en Stock</td>
                </tr>
            <tr>
            <td><?= $producto["id_producto"];?></td>
            <td><?= $producto["id_categoria"]; ?></td>
            <td><?= $producto["precio"]; ?></td>
            <td><?= $producto["color"]; ?></td>
            <td><img src="../assets/images/<?= $producto["imagen"]; ?>" width="200" alt="Imagen del Producto"></td>
            <td><?= $producto["descripcion"]; ?></td>
            <td><?= $producto["nombre_producto"]; ?></td>
            <td><?= $producto["cantidad_stock"]; ?></td>
            <td><a href="editar_producto.php?id=<?=$producto["id_producto"]?>">Editar</a></td>
            </tr>
            </tbody>
            </table>
            <?php endforeach; ?>
            <?php elseif ($action == "delete"): ?>
                <h1>Eliminar</h1>
            <?php foreach($productos as $producto):?>
            <table border="1" cellpadding="10">
            <tbody>
                <tr>
                    <td>Id producto</td>
                    <td>Id Categoria</td>
                    <td>Precio</td>
                    <td>Color</td>
                    <td>Imagen</td> 
                    <td>Descripcion</td>
                    <td>Nombre</td>
                    <td>Cantidad en Stock</td>
                </tr>
            <tr>
            <td><?= $producto["id_producto"];?></td>
            <td><?= $producto["id_categoria"]; ?></td>
            <td><?= $producto["precio"]; ?></td>
            <td><?= $producto["color"]; ?></td>
            <td><img src="../assets/images/<?= $producto["imagen"]; ?>" width="200" alt="Imagen del Producto"></td>
            <td><?= $producto["descripcion"]; ?></td>
            <td><?= $producto["nombre_producto"]; ?></td>
            <td><?= $producto["cantidad_stock"]; ?></td>
            <td><a href="eliminar_producto.php?id=<?=$producto["id_producto"]?>">Eliminar</a></td>
            </tr>
            </tbody>
            </table>
            <?php endforeach; ?>
        <?php endif; ?>


</body>

</html>

<!-- Con el id del producto, puedo redireccionar a la otra pagina y autorellenar los campos para editarlos -->