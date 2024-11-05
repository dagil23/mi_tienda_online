<?php
include '../config/database.php';
include '../includes/funciones.php';
session_start();
if(!isset($_SESSION["email"]) || !isAdmin($_SESSION["email"])){
    header("Location: ../public/index.php");
    exit;
}
$action = isset($_GET['action']) ? $_GET['action'] : 'add';
$categorias = getCategorias();
$errores = array();
$mensaje = array();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $campos = [
        'nombre' => "Nombre de la categoria",
        'descripcion' => "Descripcion",
    ];

    foreach ($campos as $campo => $nombreCampo) {
        if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
            $errores[] = "El campo $nombreCampo no puede estar vacio";
        }
    }
    if (verifyImage($_FILES["imagen"])) {
        $pathImages = "../assets/images-categorias/" .  basename($_FILES["imagen"]["name"]);
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $pathImages)) {
            $imagen = $_FILES["imagen"]["name"];
            $nombre = $_POST["nombre"];
            $descripcion = $_POST["descripcion"];
            if (addCategoria($nombre, $descripcion, $imagen)) {
                $mensaje[] = "Categoria $nombre añadida con exito";
            } else {
                $errores[] = "Error al añadir la categoria $nombre";
            }
        } else {
                $errores[] = "Error al subir la imagen";
        }
    } 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/categoria.css">
    <title>Categorias</title>
</head>
<body>
<header>
        <nav class="barra-navegacion">
            <ul>
                <li><a href="../admin/index.php">Inicio</a></li>
                <li><a href="?action=add">Agregar</a></li>
                <li><a href="?action=edit">Modificar</a></li>
            </ul>
        </nav>
    </header>
    <h1>Categorias</h1>
    <?php if ($action == 'add'): ?>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre">
            <label for="imagen">Imagen</label>
            <input type="file" name="imagen" id="imagen">
            <label for="descripcion">Descripcion del producto</label>
            <textarea name="descripcion" id="descripcion"></textarea>
            <button class="btn" type="submit">Agregar</button>
        <?php if (!empty($errores)): ?>
            <div class="mensaje-error">
                <ul>
                    <?php foreach ($errores as $error): ?>
                        <li> <?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php elseif (!empty($mensaje)): ?>
            <div class="mensaje-exito">
                <ul>
                    <?php foreach ($mensaje as $msg): ?>
                        <li> <?= $msg ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        </form>
    <?php elseif ($action == 'edit' || $action == 'delete'): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Id</th>
                    <th>Imagen</th>
                    <th>Editar</th>
                    <th>Eliminar</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorias as $categoria): ?>
                    <tr>
                        <td><?= htmlspecialchars($categoria["nombre"]); ?></td>
                        <td><?= htmlspecialchars($categoria["id_categoria"]); ?></td>
                        <td><img src="../assets/images-categorias/<?= htmlspecialchars($categoria['imagen']); ?>" alt="Imagen de la categoría"></td>
                        <td><a href="../admin/editar_categoria.php?id=<?= $categoria['id_categoria']; ?>" class="btn">Editar</a></td>
                        <td><a href="../admin/eliminar_categoria.php?id=<?= $categoria['id_categoria']; ?>" class="btn">Eliminar</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>

</html>