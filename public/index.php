<?php
include '../config/database.php';
include '../includes/funciones.php';
session_start();

$productos = null;
$categorias = getCategorias();
$colores = getColors();

if (isset($_GET["busqueda"]) || isset($_GET["tipo_prenda"])  || isset($_GET["color"]) || isset($_GET["precio_min"]) || isset($_GET["precio_max"])) {
    $terminoBusqueda = !empty($_GET["busqueda"]) ? $_GET["busqueda"] : null;
    $tipo_prenda = !empty($_GET["tipo_prenda"]) ? $_GET["tipo_prenda"] : null;
    $precio = !empty($_GET["precio"]) ? $_GET["precio"] : null;
    $color = !empty($_GET["color"]) ? $_GET["color"] : null;
    $precio_min = !empty($_GET["precio_min"]) ? $_GET["precio_min"] : null;
    $precio_max = !empty($_GET["precio_max"]) ? $_GET["precio_max"] : null;

    $productos = searchProduct($terminoBusqueda, $tipo_prenda, $color, $precio_min, $precio_max);

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

    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get">
        <input type="text" placeholder="Buscar..." name="busqueda" value="<?= isset($_GET['busqueda']) ? htmlspecialchars($_GET['busqueda']) : '' ?>">
        <label for="tipo_prenda">Tipo de Prenda: </label>
        <select name="tipo_prenda" id="tipo_prenda">
            <option value="">Todas</option>
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?= htmlspecialchars($categoria["nombre"]) ?>"><?= htmlspecialchars($categoria["nombre"]) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="color">Color</label>
        <select name="color" id="color">
            <option value="">Todos</option>
            <?php foreach ($colores as $color): ?>
                <option value="<?= htmlspecialchars($color) ?>"> <?= htmlspecialchars($color) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="precio">Precio minimo</label>
        <input type="number" step="0.1" name="precio_min" id="precio_min" placeholder="Precio" value="<?= isset($_GET['precio_min']) ? htmlspecialchars($_GET['precio_min']) : '' ?>">
        <label for="precio">Precio maximo</label>
        <input type="number" step="0.1" name="precio_max" id="precio_max" placeholder="Precio" value="<?= isset($_GET['precio_max']) ? htmlspecialchars($_GET['precio_max']) : '' ?>">

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
            <?php elseif (isset($_GET["busqueda"])): ?>
                <p>No se encontraron productos con el término de búsqueda</p>
                <?= var_dump($_GET["busqueda"]) ."<br>" ?>
                <?= print_r($productos) ?>


            <?php else: ?>
                <p>Bienvenido a Clarity</p>
                <h2>Productos destacados</h2>
            <?php endif; ?>
        </section>
    </main>

    <footer>
    </footer>
</body>

</html>