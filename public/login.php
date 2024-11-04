<?php
include '../config/database.php';
include '../includes/header.php';
$message = "";
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if (verifyUser($_POST["email"],$_POST["password"])){
        $user = getInfoUser($_POST["email"]);
        $_SESSION["id_usuario"] = $user["id_usurio"];
        $_SESSION["nombre"] = $user["nombre"];
        $_SESSION["apellido"] = $user["apellido"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["dni"] = $user["dni"];
        $_SESSION["direccion"] = $user["direccion"];
        $_SESSION["telefono"] = $user["telefono"];
        echo var_dump($user);
        header("Location: ../public/index.php");
    } else {
        $message = "<p id='error-message'>Usuario o contraseña incorrecto</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/login.css">
    <title>Login</title>
</head>
<body id="login-page">
    <main id="login-container">
        <section>
                <h2>Inicio de Sesión</h2>
                <form id="login-form" action="" method="post">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" required>
                    <button type="submit">Login</button>
                    <button class="create-account"><a href="../public/registro.php">Crear Cuenta</a></button>
                    <?php echo $message;?>
                </form>
        </section>
    </main>
    <?php include '../includes/footer.php';?>
</body>
</html>
