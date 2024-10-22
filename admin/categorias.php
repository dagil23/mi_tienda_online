<?php
include '../config/database.php';
include '../includes/funciones.php';
session_start();
$action = isset($_GET['action']) ? $_GET['action'] : 'add';
$categorias = getCategorias();
echo var_dump($categorias);
if (isset($_SESSION['email'])) {
    if (!isAdmin($_SESSION['email'])) {
        header("Location: ../public/index.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/productos.css">
    <title>Categorias</title>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="?action=add">Agregar</a></li>
                <li><a href="?action=edit">Modificar</a></li>
                <li><a href="?action=delete">Eliminar</a></li>
            </ul>
        </nav>
    </header>
    <h1>Categorias</h1>
    <?php if ($action == 'add'): ?>
        <form action="" method="post">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre">
            <label for="descripcion">Descripcion del producto</label>
            <textarea name="descripcion" id="descripcion"></textarea>
        </form>
    <?php elseif ($action == 'edit'): ?>
        <?php foreach ($categorias as $categoria): ?>
            <p><?= var_dump($categoria) ?></p>
            <tbody>
               <tr>
                <td>Nombre</td>
                <td>Id</td>
                <td>Imagen</td>
               </tr>
               <tr>
                <td><?=$categoria['nombre']?></td>
                <td> <?=$categoria['id_categoria']?></td>
                <td> <?=$categoria['imagen']?></td>
               </tr>
            </tbody>
            <?= $categoria["nombre"] ?>
        <?php endforeach; ?>
    <?php elseif ($action == 'delete'): ?>
        <?php foreach ($categorias as $categoria): ?>
            <p><?= $categoria["nombre"] ?></p>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>