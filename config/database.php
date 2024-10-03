<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mitiendaDB";

$conexion = new mysqli($servername,$username,$password,$dbname);

    if($conexion->connect_error){
        die("Connexion fallida: " . $conexion->connect_error);
    }else{
        echo "<p>Conexion exitosa</p>";
    }