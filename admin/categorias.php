<?php
include '../config/database.php';
include '../includes/funciones.php';
$action
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
    <link rel="stylesheet" href="../assets/css/productos.css">
    <title>Categorias</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="?action=add"></a>Agregar</li>
                <li><a href="?action=edit"></a>Modificar</li>
                <li><a href="?action=delete"></a>Eliminar</li>
            </ul>
        </nav>
    </header>
    <?php if() ?>
    <h1>Categorias</h1>
    <form action="" method="post">
    <label for="nombre">Nombre</label>
    <input type="text" name ="nombre" id="nombre">
    <label for="descripcion">Descripcion del producto</label>
    <textarea name="descripcion" id="descripcion"></textarea>
    </form>
</body>
</html>