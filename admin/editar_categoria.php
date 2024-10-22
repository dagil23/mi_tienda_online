<?php
include '../includes/funciones.php';
$id_categoria = isset($_GET["id"]) ? $_GET["id"] :  null;
$categorias = getCategorias($id_categoria);
echo var_dump($categorias);
echo var_dump($_FILES["imagen"]);
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = !empty($_POST["nombre"]) ? $_POST["nombre"] : $categorias["nombre"];
    $descripcion = !empty($_POST["descripcion"]) ? $_POST["descripcion"] : $categorias["descripcion"];

    if (!empty($_FILES["imagen"]["name"])) {
        $isValid = verifyImage($_FILES["imagen"], "../assets/images-categorias/");
        if($isValid){
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