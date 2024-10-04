<?php
include '../config/database.php';
include '../includes/funciones.php';
session_start();
if (isset($_SESSION['email'])) {
    if(!isAdmin($_SESSION['email'])){
        header("Location: ../public/index.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
</head>
<body>
    <h1>Productos</h1>
</body>
</html>