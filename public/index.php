<?php
include '../config/database.php';
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/indexStyle.css">
    <title>Pagina Principal</title>
</head>
<body>
<header>
    <h1>Clarity</h1>
</header>
    <form action="">
        <input type="text" placeholder="Buscar..." value = "busquedad">
        <button type="submit">Buscar</button>
    </form>
    <nav>
        <ul>
            <li><a href="../admin/index.php">Zona Admin</a></li>
            <li><a href="../public/carrito.php">Carrito</a></li>
            <li><a href="../public/wishlist.php">Wishlist</a></li>
            <li><a href="../public/registro.php">Sing Up</a></li>
        </ul>
    </nav>
    
        <main>
                <section>
        <img src="../assets/images/camiseta-beige.png" alt="camiseta-beige">
        <img src="../assets/images/gloves-black.png" alt="gloves-black">
        <img src="../assets/images/polo-beige.png" alt="polo-beige">
        <img src="../assets/images/short-beige.png" alt="short-beige">
                </section>
        </main>
        <footer>

        </footer>
</body>
</html>