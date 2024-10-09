<?php
include_once '../config/database.php';

    function verifyUser($email, $password){
        $conexion = connectDB();
        $userValidation = $conexion->prepare("SELECT * FROM USUARIOS WHERE email = ? AND contraseña = ?");
        $userValidation->bind_param('ss',$email,$password);
        $userValidation->execute();
        $userValidation->store_result();

        $status = ($userValidation->num_rows > 0) ? true : false;
        $conexion->close();
        $userValidation->close();
        return $status;
    }

    function isAdmin($email){

        $conexion = connectDB();
        $admin = "admin";
        $adminValidation = $conexion->prepare("SELECT * FROM USUARIOS WHERE email = ? AND rol = ?");
        $adminValidation->bind_param("ss",$email,$admin);
        $adminValidation->execute();
        $adminValidation->store_result();

        $status = ($adminValidation->num_rows > 0) ? true : false;
        $conexion->close();
        $adminValidation->close();
        return $status;
            
    }

    function addUser($usuario,$apellido,$email,$dni,$pwd,$direccion,$telefono) {
        $conexion = connectDB();
        
        $query = $conexion->prepare("INSERT INTO USUARIOS(nombre, apellido, email, dni, contraseña, direccion, telefono) VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        if (!$query) {
            die("Error en la preparación de la consulta: " . $conexion->error);
        }
        
        
        $query->bind_param("sssssss",$usuario,$apellido,$email,$dni,$pwd,$direccion,$telefono);
        
        $mensaje = "";
        if ($query->execute()) {
             $mensaje = "Usuario $usuario insertado con éxito";
        } else {
            $mensaje = "Error al insertar el usuario: " . $query->error;
        }
        return $mensaje;
        $query->close();
        $conexion->close();
    }
    
