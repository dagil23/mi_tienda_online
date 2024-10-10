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

    function verifyDNI($dni){
        $regex = "/^[0-9]{8}[A-Za-z]$/";
        $isValid = preg_match($regex,$dni) ? true : false;
        return $isValid;

    }
    function verifyEmail($email){
        $isValid = filter_var($email,FILTER_VALIDATE_EMAIL) ? true : false;
        return $isValid;
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
        $query->close();
        $conexion->close();
        return $mensaje;
    }

        function searchProduct($terminoBusqueda = null, $tipoPrenda = null, $color = null, $precio = null) {
            $conexion = connectDB();
            $query = "SELECT * FROM PRODUCTO WHERE 1=1 ";
            $params = [];
            $types = "";
        
            if (!empty($terminoBusqueda)) {
                $query .= " AND nombre_producto LIKE ? ";
                $params[] = "%" . $terminoBusqueda . "%";
                $types .= "s";
            }
        
            if (!empty($tipoPrenda)) {
                $query .= " AND id_categoria = (SELECT id_categoria FROM CATEGORIA WHERE nombre = ?) ";
                $params[] = $tipoPrenda;
                $types .= "s";
            }
        
            if (!empty($color)) {
                $query .= " AND color = ? ";
                $params[] = $color;
                $types .= "s";
            }
        
            if (!empty($precio)) {
                $query .= " AND precio = ? ";
                $params[] = $precio;
                $types .= "d";
            }
        
            $stmt = $conexion->prepare($query);
            if (!$stmt) {
                die("Error al preparar la consulta: " . $conexion->error);
            }
        
            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }
        
            if ($stmt->execute()) {
                return $stmt->get_result();
            } else {
                die("Error al ejecutar la consulta: " . $stmt->error);
            }
            
        $conexion->close();
        $stmt->close();
        }
        
    