<?php
include '../config/database.php';
include '../includes/header.php';

$productos = null;
$categorias = getCategorias();
$colores = getColors();
$productosDestacados = getProducts(); // Obtener los productos destacados de la base de datos

if (isset($_GET["busqueda"]) || isset($_GET["tipo_prenda"]) || isset($_GET["color"]) || isset($_GET["precio_min"]) || isset($_GET["precio_max"])) {
    $terminoBusqueda = !empty($_GET["busqueda"]) ? $_GET["busqueda"] : null;
    $tipo_prenda = !empty($_GET["tipo_prenda"]) ? $_GET["tipo_prenda"] : null;
    $precio = !empty($_GET["precio"]) ? $_GET["precio"] : null;
    $color = !empty($_GET["color"]) ? $_GET["color"] : null;
    $precio_min = !empty($_GET["precio_min"]) ? $_GET["precio_min"] : null;
    $precio_max = !empty($_GET["precio_max"]) ? $_GET["precio_max"] : null;

    $productos = searchProduct($terminoBusqueda, $tipo_prenda, $color, $precio_min, $precio_max);

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/index.css">
    <title>Página Principal</title>
</head>

<body>
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get" class="formulario-busqueda">
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

        <label for="precio">Precio mínimo</label>
        <input type="number" step="0.1" name="precio_min" id="precio_min" placeholder="Precio" value="<?= isset($_GET['precio_min']) ? htmlspecialchars($_GET['precio_min']) : '' ?>">
        <label for="precio">Precio máximo</label>
        <input type="number" step="0.1" name="precio_max" id="precio_max" placeholder="Precio" value="<?= isset($_GET['precio_max']) ? htmlspecialchars($_GET['precio_max']) : '' ?>">

        <button type="submit" class="btn">Buscar</button>
    </form>
    <main>
        <section>
            <?php if ($productos && $productos->num_rows > 0): ?>
                <section class="productos-encontrados">
                    <div class="productos-encontrados-lista">
                        <?php while ($producto = $productos->fetch_assoc()): ?>
                            <div class='producto'>
                                <img src='../assets/images/<?= htmlspecialchars($producto["imagen"]) ?>' alt='<?= htmlspecialchars($producto["nombre_producto"]) ?>'>
                                <h2><?= htmlspecialchars($producto["nombre_producto"]) ?></h2>
                                <p>Precio: <?= htmlspecialchars($producto["precio"]) ?></p>
                                <a href="../public/agregar_carrito.php?id=<?=htmlspecialchars($producto["id_producto"])?>" class="btn">Add to Cart</a>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </section>
            <?php elseif (isset($_GET["busqueda"])): ?>
                <p>No se encontraron productos con el término de búsqueda</p>
            <?php else: ?>
                <h2>Productos destacados</h2>
                <section class="galeria">
                    <div class="galeria-imagenes">
                        <?php if ($productosDestacados && count($productosDestacados) > 0): ?>
                            <?php foreach ($productosDestacados as $producto): ?>
                                <div class="galeria-item">
                                    <img src="../assets/images/<?= htmlspecialchars($producto["imagen"]) ?>" alt="<?= htmlspecialchars($producto["nombre_producto"]) ?>">
                                    <p><?= htmlspecialchars($producto["nombre_producto"]) ?></p>
                                <a href="../public/agregar_carrito.php?id=<?=htmlspecialchars($producto["id_producto"])?>" class="btn">Add to Cart</a>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No hay productos destacados disponibles en este momento.</p>
                        <?php endif; ?>
                    </div>
                </section>
            <?php endif; ?>
        </section>
    </main>
    <?php include '../includes/footer.php';?>
</body>

</html>
