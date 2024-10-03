<?php
include_once '../config/database.php';

    function verifyUser($email, $password){
        $conexion = connectDB();
        $userValidation = $conexion->prepare("SELECT * FROM USUARIOS WHERE email = ? AND contraseña = ?");
        $userValidation->bind_param('ss',$email,$password);
        $userValidation->execute();
        $userValidation->store_result();

            if($userValidation->num_rows > 0){
                return true;
            }else{
                return false;
            }
    }

    function isAdmin($email){

        $conexion = connectDB();
        $admin = "admin";
        $adminValidation = $conexion->prepare("SELECT * FROM USUARIOS WHERE email = ? AND rol = ?");
        $adminValidation->bind_param("ss",$email,$admin);
        $adminValidation->execute();
        $adminValidation->store_result();

            if($adminValidation->num_rows > 0){
                return true;
            }else{
                return false;
            }

    }
?>