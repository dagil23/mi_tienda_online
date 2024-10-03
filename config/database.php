<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mitiendaDB";

function connectDB(){

    global $servername,$username,$password,$dbname;
    $conexion = new mysqli($servername,$username,$password,$dbname);
    if($conexion->connect_error){
        die("Connexion fallida: " . $conexion->connect_error);
    }

    return $conexion;
}
