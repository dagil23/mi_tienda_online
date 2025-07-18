<?php
include '../includes/funciones.php';
session_start();
if(!isset($_SESSION["email"]) || !isAdmin($_SESSION["email"])){
    header("Location: ../public/index.php");
    exit;
}
$id_categoria = isset($_GET["id"]) ? $_GET["id"] :  null;
$categorias = getCategorias($id_categoria);
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = !empty($_POST["nombre"]) ? $_POST["nombre"] : $categorias["nombre"];
    $descripcion = !empty($_POST["descripcion"]) ? $_POST["descripcion"] : $categorias["descripcion"];

    if (!empty($_FILES["imagen"]["name"])) {
        if(verifyImage($_FILES["imagen"])){
            $pathImages = "../assets/images-categorias/" . basename($_FILES["imagen"]["name"]);
            move_uploaded_file($_FILES["imagen"]["tmp_name"],$pathImages);
            $imagen = $_FILES["imagen"]["name"];

            if(updateCategoria($id_categoria,$nombre,$descripcion,$imagen)){

                echo "Categoria actualizada";
            }else{
                echo "Error al actualizar la categoria";
            }
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
    <title>Editar Categoría</title>
</head>

<body>
   <header>
    <nav>
        <ul>
            <li><a href="../admin/index.php">Inicio</a></li>
            <li> <a href="../admin/categorias.php">Categorias</a></li>
        </ul>
    </nav>
   </header>
    <h1>Editar Categoría</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($categorias['nombre']); ?>">

        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion"><?= htmlspecialchars($categorias['descripcion']); ?></textarea>

        <label for="imagen">Imagen</label>
        <input type="file" name="imagen" id="imagen">

        <button class="btn" type="submit">Guardar Cambios</button>
    </form>
</body>

</html>