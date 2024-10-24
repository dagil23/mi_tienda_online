<?php 
include '../config/database.php';
include '../includes/funciones.php';
session_start();
if(!isset($_SESSION["email"]) || !isAdmin($_SESSION["email"])){
    header("Location: ../public/index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <title>Zona Admin</title>
</head>
<body>
    <header class="admin-header">
        <h1>Zona Admin</h1>
        <nav>
            <ul class="admin-nav">
                <li><a href="../admin/productos.php">Productos</a></li>
                <li><a href="../admin/categorias.php">Categorías</a></li>
            </ul>
        </nav>
    </header>
    <main class="admin-main">
        <section class="welcome-section">
            <h2>Bienvenido a la Zona Administrativa</h2>
            <p>Aquí puedes gestionar los productos y las categorías de la tienda.</p>
        </section>
    </main>
</body>
</html>