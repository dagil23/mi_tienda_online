<?php 
include '../config/database.php';
include '../includes/funciones.php';
session_start();
if(isset($_SESSION['email'])){

    if(isAdmin($_SESSION['email'])== false){
        header("Location: ../public/index.php");
    }else{
        echo "Eres admin";
    }
}
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zona Admin</title>
</head>
<body>
    <h1>Hola admin<h1>
</body>
</html>