<?php
include '../config/database.php';
include '../includes/funciones.php';
session_start();
$message = "";
if($_SERVER['REQUEST_METHOD'] == "POST"){
        if (verifyUser($_POST["email"],$_POST["password"])){
            $_SESSION['email'] = $_POST['email'];
            header("Location: ../public/index.php");
        }else{
            $message = "<p>Usuario o contraseña incorrecto</p>";
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rozha+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="http://localhost/Proyecto-DWES/mi_tienda_online/assets/css/loginStyle.css">
    <title>Login</title>
</head>
<body>
    <header>
        <h1>Clarity</h1>
        <nav>

        </nav>
        <header>
            <main>
            <section>
            <fieldset>
        <h2>Inicio de Sesión</h2>
                <form action="" method="post">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" required>
                    <button type="submit">Login</button>
                    <button><a href="../public/registro.php">Crear Cuenta</a></button>
                    <?php echo $message;?>
                </form>
            </fieldset>
        </section>
            </main>
            <footer>

            </footer>
</body>
</html>