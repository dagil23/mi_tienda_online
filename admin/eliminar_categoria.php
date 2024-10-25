<?php
session_start();
include '../includes/funciones.php';
if(!isset($_SESSION["email"]) || !isAdmin($_SESSION["email"])){
    header("Location: ../public/index.php");
    exit;
}
$id_categoria = isset($_GET["id"]) ? (int)$_GET["id"] : null;
$confirmar = "confirmacion";
$mensaje = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["confirmacion"]) && $_POST["confirmacion"] == $confirmar){
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
    <header>
        <nav>
            <ul>
                <li> <a href="../admin/index.php">Inicio</a></li>
            </ul>
        </nav>
    </header>
    <div class="eliminar_categoria">
    <p>Escribe la palabra <strong>confirmacion</strong>  para eliminar la categoria</p>
    <form action="<?= $_SERVER["PHP_SELF"]  . "?id=" . $_GET["id"] ?>" method="post">
    <label for="confirmacion"></label>
    <input type="text" name="confirmacion" id="confirmacion">
    <button type="submit">Eliminar</button>
    </form>
    <?php if(!empty($mensaje)):?>
        <p id="mensaje_eliminacion"><?=$mensaje?></p>
        <?php endif;?>
</div>
</body>
</html>