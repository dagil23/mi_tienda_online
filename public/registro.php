<?php
include '../includes/header.php';
$mensaje = "";
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        if(isset($_POST["usuario"]) && isset($_POST["apellido"]) && isset($_POST["email"]) && isset($_POST["direccion"]) && isset($_POST["telefono"]) && isset($_POST["dni"]) && isset($_POST["password"])){

            $email =  $_POST["email"];
            $pwd = $_POST["password"];
            $usuario = $_POST["usuario"];
            $apellido = $_POST["apellido"];
            $direccion = $_POST["direccion"];
            $telefono = $_POST["telefono"];
            $dni = $_POST["dni"];
            if(!verifyDNI($dni)){
                $mensaje = "Formato de DNI incorrecto";
            }elseif(!verifyEmail($email)){
                $mensaje = "Formato de email invalido";
            }else{

                addUser($usuario,$apellido,$email,$dni,$pwd,$direccion,$telefono);
                header("Location: ../public/index.php");
            }
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
    <link rel="stylesheet" href="../assets/css/registro.css">
    <title>Crear Cuenta</title>
</head>
<body>
            <main>
        <section>
            <fieldset>
        <h2>Crear Cuenta</h2>
                <form action="" method="post">
                    <label for="name">Nombre</label>
                    <input type="text" name="usuario" id="name" required>
                    <label for="apellido">Apellido</label>
                    <input type="text" name="apellido" id="name" required>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" required>
                    <label for="direccion">Direccion</label>
                    <input type="text" name="direccion" id="direccion" required>
                    <label for="telefono">Numero</label>
                    <input type="tel" name="telefono" id="telefono" required>
                    <label for="dni">DNI</label>
                    <input type="text" name="dni" id="dni" required>
                    <button type="submit">Crear Cuenta</button>
                    <button><a href="../public/login.php">Iniciar Sesion</a></button>
                </form>
            </fieldset>
        </section>
            <main>
            <?php include '../includes/footer.php';?>
</body>
</html>