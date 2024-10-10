<?php
include '../config/database.php';
include '../includes/funciones.php';
session_start();

$productos = null;

if (isset($_POST["busqueda"]) || isset($_POST["tipo_prenda"]) || isset($_POST["precio"]) || isset($_POST["color"])) {
    $terminoBusqueda = !empty($_POST["busqueda"]) ? $_POST["busqueda"] : null;
    $tipo_prenda = !empty($_POST["tipo_prenda"]) ? $_POST["tipo_prenda"] : null;
    $precio = !empty($_POST["precio"]) ? $_POST["precio"] : null;
    $color = !empty($_POST["color"]) ? $_POST["color"] : null;

    $productos = searchProduct($terminoBusqueda, $tipo_prenda, $color, $precio);

    if ($productos) {
        echo "Productos encontrados: " . $productos->num_rows; // Esto permite saber si se encontró algún producto
    } else {
        echo "Error al realizar la búsqueda o no se encontraron productos.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/indexStyle.css">
    <title>Página Principal</title>
</head>
<body>
<header>
    <h1>Clarity</h1>
</header>

<form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <input type="text" placeholder="Buscar..." name="busqueda" value="<?= isset($_POST['busqueda']) ? htmlspecialchars($_POST['busqueda']) : '' ?>">
    <label for="tipo_prenda">Tipo de Prenda: </label>
    <select name="tipo_prenda" id="tipo_prenda">
        <option value="">Todas</option>
        <option value="camisetas">Camisetas</option>
        <option value="pantalones">Pantalones</option>
        <option value="sudaderas">Sudaderas</option>
        <option value="short">Shores</option>
        <option value="Gorras">Gorras</option>
        <option value="chaquetas">Chaquetas</option>
        <option value="Polos">Polos</option>
    </select>

    <label for="color">Color</label>
    <select name="color" id="color">
        <option value="">Todos</option>
        <option value="negro">Negro</option>
        <option value="blanco">Blanco</option>
        <option value="azul">Azul</option>
        <option value="marron">Marrón</option>
    </select>

    <label for="precio">Precio</label>
    <input type="number" step="0.1" name="precio" id="precio" placeholder="Precio" value="<?= isset($_POST['precio']) ? htmlspecialchars($_POST['precio']) : '' ?>">

    <button type="submit">Buscar</button>
</form>

<nav>
    <ul>
        <li><a href="../admin/index.php">Zona Admin</a></li>
        <li><a href="../public/carrito.php">Carrito</a></li>
        <li><a href="../public/wishlist.php">Wishlist</a></li>
        <li><a href="../public/registro.php">Sign Up</a></li>
    </ul>
</nav>

<main>
    <section>
        <?php if ($productos && $productos->num_rows > 0): ?>
            <?php while ($producto = $productos->fetch_assoc()): ?>
                <div class='producto'>
                    <img src='../assets/images/<?= htmlspecialchars($producto["imagen"]) ?>' alt='<?= htmlspecialchars($producto["nombre_producto"]) ?>'>
                    <h2><?= htmlspecialchars($producto["nombre_producto"]) ?></h2>
                    <p>Precio: <?= htmlspecialchars($producto["precio"]) ?></p>
                    <button>Add to Cart</button> 
                    <button>Add to Wishlist</button> 
                </div>
            <?php endwhile; ?>
        <?php elseif (isset($_POST["busqueda"])): ?>
            <p>No se encontraron productos con el término de búsqueda</p>
        <?php else: ?>
            <p>Bienvenido a Clarity</p>
        <?php endif; ?>
    </section>
</main>

<footer>
</footer>
</body>
</html>
