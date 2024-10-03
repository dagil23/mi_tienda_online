<?php
include '../config/database.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rozha+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="http://localhost/Proyecto-DWES/mi_tienda_online/assets/css/registroStyle.css">
    <title>Crear Cuenta</title>
</head>
<body>
    <header>
        <h1>Clarity</h1>
        <nav>
            <ul>
                <li>Login</li>
                <li>Carrito</li>
                <li>Whislist</li>
            </ul>
        <nav>
        <header>
            <main>
        <section>
            <fieldset>
        <h2>Crear Cuenta</h2>
                <form action="">
                    <label for="name">Nombre</label>
                    <input type="text" name="usuario" id="name">
                    <label for="apellido">Apellido</label>
                    <input type="text" name="apellido" id="name">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password">
                    <label for="direccion">Direccion</label>
                    <input type="text" name="direccion" id="direccion">
                    <label for="telefono">Numero</label>
                    <input type="tel" name="telefono" id="telefono">
                    <button type="submit">Crear Cuenta</button>
                    <button><a href="../public/login.php">Iniciar Sesion</a></button>
                </form>
            </fieldset>
        </section>
            <main>
    <footer>

    </footer>
</body>
</html>