<?php 
include '../config/database.php';
include '../includes/funciones.php';
session_start();
if(isset($_SESSION['email'])){
    $email = $_SESSION['email'];
    if(isAdmin($email)){
        echo "Tu email es $email y eres admin";
    }else {
        header("Location: ../public/index.php");
    }
}
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zona Admin</title>
</head>
<body>
    <header>
        <h1>Zona Admin<h1>
            <nav>
                <ul>
                    <li><a href="../admin/productos.php">Productos</a></li>
                    <li><a href="../admin/categorias.php">Categorias</a></li>
                </ul>
            </nav>
        </header>
</body>
</html>