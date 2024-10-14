<?php
include_once '../config/database.php';

function verifyUser($email, $password)
{
    $conexion = connectDB();
    $userValidation = $conexion->prepare("SELECT * FROM USUARIOS WHERE email = ? AND contraseña = ?");
    $userValidation->bind_param('ss', $email, $password);
    $userValidation->execute();
    $userValidation->store_result();

    $status = ($userValidation->num_rows > 0) ? true : false;
    $conexion->close();
    $userValidation->close();
    return $status;
}

function isAdmin($email)
{

    $conexion = connectDB();
    $admin = "admin";
    $adminValidation = $conexion->prepare("SELECT * FROM USUARIOS WHERE email = ? AND rol = ?");
    $adminValidation->bind_param("ss", $email, $admin);
    $adminValidation->execute();
    $adminValidation->store_result();

    $status = ($adminValidation->num_rows > 0) ? true : false;
    $conexion->close();
    $adminValidation->close();
    return $status;

}

function verifyDNI($dni)
{
    $regex = "/^[0-9]{8}[A-Za-z]$/";
    $isValid = preg_match($regex, $dni) ? true : false;
    return $isValid;

}
function verifyEmail($email)
{
    $isValid = filter_var($email, FILTER_VALIDATE_EMAIL) ? true : false;
    return $isValid;
}

function addUser($usuario, $apellido, $email, $dni, $pwd, $direccion, $telefono)
{
    $conexion = connectDB();

    $query = $conexion->prepare("INSERT INTO USUARIOS(nombre, apellido, email, dni, contraseña, direccion, telefono) VALUES (?, ?, ?, ?, ?, ?, ?)");

    if (!$query) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }


    $query->bind_param("sssssss", $usuario, $apellido, $email, $dni, $pwd, $direccion, $telefono);

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

function searchProduct($terminoBusqueda = null, $tipoPrenda = null, $color = null, $precio_min = null, $precio_max = null)
{
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

    if (!empty($precio_min)) {
        $query .= " AND precio >= ? ";
        $params[] = $precio_min;
        $types .= "d";
    }

    if (!empty($precio_max)) {
        $query .= " AND precio <= ? ";
        $params[] = $precio_max;
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

function getCategorias()
{
    $conexion = connectDB();

    $query = "SELECT * FROM CATEGORIA";
    $result = $conexion->query($query);
    $categorias = array();
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categorias[] = [
                'id_categoria' => $row['id_categoria'],
                'nombre' => $row['nombre']
            ];
        }
        return $categorias;
    }
    $conexion->close();
    return $categorias;
}

function getColors()
{
    $conexion = connectDB();
    $query = "SELECT DISTINCT color FROM PRODUCTO ORDER BY color;";
    $result = $conexion->query($query);
    $colores = array();
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $colores[] = $row["color"];
        }
    }
    return $colores;
}


function addProduct($id_categoria,$nombre,$precio,$color,$descripcion,$imagen,$cantidad)
{

    $conexion = connectDB();
    $stmt = $conexion->prepare("INSERT INTO PRODUCTO(id_categoria,precio,color,imagen,descripcion,nombre_producto,cantidad_stock)VALUES(?, ? , ? , ?, ?, ?, ?)");
    if($stmt === false){
        die("Error en la preparacion de la consulta" . $conexion->error);
    }
    $stmt->bind_param("ddssssd",$id_categoria,$precio,$color,$imagen,$descripcion,$nombre,$cantidad);
    if($stmt->execute()){
        return "Producto agregado con exito";
    }else{
        return "Error al insertar el producto" . $stmt->error;
    }

}


