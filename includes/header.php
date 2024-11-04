<?php
include '../includes/funciones.php';
session_start();
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Rozha+One&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/header.css">
<header>
    <div>
        <a href="../public/index.php">
            <h1>Clarity</h1>
        </a>
    </div>
    <nav>
        <?php if (isset($_SESSION['email'])): ?>
            <?php if (isAdmin($_SESSION['email'])): ?>
                <a href="../admin/index.php" class="admin-button">Zona Admin</a>
            <?php endif; ?>
            <a href="../public/carrito.php" class="cart-icon" data-count="3">Carrito 🛒</a>
            <a href="../public/logout.php" class="logout-button">Logout</a>
        <?php else: ?>
            <a href="../public/login.php" class="login-button">Login</a>
            <a href="../public/carrito.php" class="cart-icon" data-count="3">Carrito 🛒</a>
        <?php endif; ?>
    </nav>
</header>