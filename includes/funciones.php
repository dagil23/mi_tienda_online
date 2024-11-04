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
function verifyImage($archivo, $tiposPermitidos = ["image/png", "image/jpeg"])
{

    if (!empty($archivo)) {
        $tipoArchivo = $archivo["type"];
        if (in_array($tipoArchivo, $tiposPermitidos)) {
            return true;
        }
    }
    return false;
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

function getInfoUser($email = null)
{
    $conexion = connectDB();
    if ($email) {
        $query = " SELECT * FROM USUARIOS WHERE email = ? ";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("s", $email);
    } else {
        $query = " SELECT * FROM USUARIOS ORDER BY id_usuario ASC ";
        $stmt = $conexion->prepare($query);
    }

    $stmt->execute();
    $usuarios = array();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = [
                'id_usuario' => $row['id_usuario'],
                'nombre' => $row['nombre'],
                'apellido' => $row['apellido'],
                'email' => $row['email'],
                'dni' => $row['dni'],
                'fecha_registro' => $row['fecha_registro'],
                'contraseña' => $row['contraseña'],
                'direccion' => $row['direccion'],
                'telefono' => $row['telefono'],
                'rol' => $row['rol']
            ];
        }
        return $email ? $usuarios[0] : $usuarios;
        $conexion->close();
        $stmt->close();
    }
}
function getProductos($id_producto = null)
{
    $conexion = connectDB();

    if ($id_producto) {
        $query = "SELECT * FROM PRODUCTO WHERE id_producto = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("i", $id_producto);
    } else {

        $query = "SELECT * FROM PRODUCTO ORDER BY id_producto ASC;";
        $stmt = $conexion->prepare($query);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $productos = array();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $productos[] = [
                'id_producto' => $row['id_producto'],
                'id_categoria' => $row['id_categoria'],
                'precio' => $row['precio'],
                'color' => $row['color'],
                'imagen' => $row['imagen'],
                'descripcion' => $row['descripcion'],
                'nombre_producto' => $row['nombre_producto'],
                'cantidad_stock' => $row['cantidad_stock'],
            ];
        }
        return $id_producto ? $productos[0] : $productos;
        $conexion->close();
        $stmt->close();
    }
}

function updateProducto(
    $id_producto,
    $nombre,
    $precio,
    $cantidad,
    $color = null,
    $descripcion = null,
    $imagen = null,
    $id_categoria = null
) {

    $conexion = connectDB();
    $query = " UPDATE PRODUCTO SET ";
    $params = array();
    $types = "";

    if (!empty($nombre)) {

        $query .= " nombre_producto = ?, ";
        $params[] = $nombre;
        $types .= "s";
    }

    if (!empty($precio)) {

        $query .= " precio = ?, ";
        $params[] = $precio;
        $types .= "d";
    }

    if (!empty($cantidad)) {

        $query .= " cantidad_stock = ?, ";
        $params[] = $cantidad;
        $types .= "i";
    }

    if (!empty($color)) {

        $query .= " color = ?, ";
        $params[] = $color;
        $types .= "s";
    };

    if (!empty($descripcion)) {

        $query .= " descripcion = ?, ";
        $params[] = $descripcion;
        $types .= "s";
    }

    if (!empty($imagen)) {

        $query .= " imagen = ?, ";
        $params[] = $imagen;
        $types .= "s";
    }

    if (!empty($id_categoria)) {

        $query .= " id_categoria = ?, ";
        $params[] = $id_categoria;
        $types .= "i";
    }

    $query = rtrim($query, ", ") . " WHERE id_producto = ? ";
    $params[] = $id_producto;
    $types .= "i";

    $stmt = $conexion->prepare($query);
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conexion->error);
    }

    if (!empty($params)) {

        $stmt->bind_param($types, ...$params);
    }

    if ($stmt->execute()) {
        return true;
    } else {
        die("Error al ejecutar la consulta: " . $stmt->error);
    }

    $conexion->close();
    $stmt->close();
}

function deleteProduct($id_producto)
{

    $conexion = connectDB();
    $stmt =  $conexion->prepare("DELETE FROM PRODUCTO WHERE id_producto = ? ");
    if (!$stmt) {
        die("Error al preparar la consulta " . $conexion->error);
    }

    $stmt->bind_param("s", $id_producto);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function addCategoria($nombre, $descripcion, $imagen)
{

    $conexion = connectDB();
    $stmt = $conexion->prepare("INSERT INTO CATEGORIA(nombre,descripcion,imagen)VALUES(? , ? , ? )");
    if ($stmt === false) {
        die("Error en la preparacion de la consulta" . $conexion->error);
    }
    $stmt->bind_param("sss", $nombre, $descripcion, $imagen);
    if ($stmt->execute()) {
        return "Categoria agregadoa con exito";
    } else {
        return "Error al insertar la categoria" . $stmt->error;
    }
    $conexion->close();
    $stmt->close();
}
function getCategorias($id_categoria = null)
{
    $conexion = connectDB();
    $categorias = array();

    if ($id_categoria) {
        $query = "SELECT * FROM CATEGORIA WHERE id_categoria = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("i", $id_categoria);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $query = "SELECT * FROM CATEGORIA ORDER BY id_categoria ASC;";
        $result = $conexion->query($query);
    }

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categorias[] = [
                'id_categoria' => $row['id_categoria'],
                'nombre' => $row['nombre'],
                'descripcion' => $row['descripcion'],
                'imagen' => $row['imagen']
            ];
        }
    }

    if (isset($stmt)) {
        $stmt->close();
    }
    $conexion->close();

    return $id_categoria ? $categorias[0] : $categorias;
}


function updateCategoria($id_categoria, $nombre, $descripcion, $imagen)
{

    $conexion = connectDB();
    $query = " UPDATE CATEGORIA SET ";
    $params = array();
    $types = "";


    if (!empty($nombre)) {
        $query .= " nombre = ?, ";
        $params[] = $nombre;
        $types .= "s";
    }
    if (!empty($descripcion)) {
        $query .= " descripcion = ?, ";
        $params[] = $descripcion;
        $types .= "s";
    }
    if (!empty($imagen)) {
        $query .= " imagen = ?, ";
        $params[] = $imagen;
        $types .= "s";
    }
    $query = rtrim($query, ", ") . " WHERE id_categoria = ? ";
    $params[] = $id_categoria;
    $types .= "i";

    $stmt = $conexion->prepare($query);
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conexion->error);
    }

    if (!empty($params)) {

        $stmt->bind_param($types, ...$params);
    }

    if ($stmt->execute()) {
        
        return true;
    } else {
        die("Error al ejecutar la consulta: " . $stmt->error);
    }

    $conexion->close();
    $stmt->close();
}

function deleteCategoria($id_categoria)
{
    $conexion = connectDB();
    $query = "DELETE FROM CATEGORIA WHERE id_categoria = ?";

    $stmt = $conexion->prepare($query);
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conexion->error);
    }

    $stmt->bind_param("i", $id_categoria);
    $resultado = $stmt->execute();

    $stmt->close();
    $conexion->close();

    return $resultado;
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
    $conexion->close();
}


function addProduct($id_categoria, $nombre, $precio, $color, $descripcion, $imagen, $cantidad)
{

    $conexion = connectDB();
    $stmt = $conexion->prepare("INSERT INTO PRODUCTO(id_categoria,precio,color,imagen,descripcion,nombre_producto,cantidad_stock)VALUES(?, ? , ? , ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Error en la preparacion de la consulta" . $conexion->error);
    }
    $stmt->bind_param("ddssssd", $id_categoria, $precio, $color, $imagen, $descripcion, $nombre, $cantidad);
    if ($stmt->execute()) {
        return "Producto agregado con exito";
    } else {
        return "Error al insertar el producto" . $stmt->error;
    }
    $conexion->close();
    $stmt->close();
}

function existsOrderCart($id_usuario)
{

    $conexion = connectDB();
    $id_pedido = null;
    $query = "SELECT id_pedido FROM PEDIDOS WHERE pedido_usuario = ? AND estado = 'carrito' ";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows>0){
        $row = $result->fetch_assoc();
        $id_pedido = $row["id_pedido"];
    }
    return $id_pedido ? $id_pedido : false;
    $conexion->close();
    $stmt->close();
    
}

function addOrder($id_usuario, $dni, $precio_total, $nombre, $apellidos, $estado, $direccion)
{

    $conexion = connectDB();
    $stmt = $conexion->prepare("INSERT INTO PEDIDOS(pedido_usuario,dni, precio_total,nombre,apellidos,estado,direccion) VALUES(?, ?, ?, ?, ?, ?, ?) ");
    if (!$stmt) {
        die("Error en la preparacion de la consulta " . $conexion->error);
    }
    $stmt->bind_param("isdssss", $id_usuario, $dni, $precio_total, $nombre, $apellidos, $estado, $direccion);
    $stmt->execute();
    $id_pedido = $stmt->insert_id;
    
    $stmt->close();
    $conexion->close();
    return $id_pedido;
}

function updateOrder($id_pedido, $precio_total = null, $estado = null, $direccion = null)
{

    $conexion = connectDB();

    $query = "UPDATE PEDIDOS SET";
    $params = array();
    $types = "";

    if (!empty($precio_total)) {
        $query .= " precio_total = ?, ";
        $params[] = $precio_total;
        $types .= "d";
    }

    if (!empty($estado)) {

        $query .= " estado = ?, ";
        $params [] = $estado;
        $types .= "s";
    }

    if(!empty($direccion)){

        $query .= " direccion = ?, ";
        $params [] = $direccion;
        $types .= "s";
    }

    $query = rtrim($query, ", ") . " WHERE id_pedido = ?";
    $params [] = $id_pedido;
    $types .= "i";

    if(!empty($params)){
        $stmt = $conexion->prepare($query);
        $stmt->bind_param($types,...$params);
    }
    $result = $stmt->execute();
    $stmt->close();
    $conexion->close();
    return $result;


    
}

function addOrderLine($id_pedido, $id_producto,$talla, $precio_unitario, $cantidad){

    $conexion = connectDB();
    $stmt = $conexion->prepare("INSERT INTO LINEA_PEDIDO(id_pedido,id_producto,talla,precio_unitario,cantidad) VALUES(?, ?, ?, ?, ?)");

    if(!$stmt){
        die("Error al preparar la consulta" . $conexion->error);
    }

    $stmt->bind_param("iisdi",$id_pedido, $id_producto,$talla, $precio_unitario, $cantidad);
    if($stmt->execute()){
        return true;
    }else{
        return false;
    }
    $conexion->close();
    $stmt->close();
}

function updateOrderLine($id_linea_pedido,$cantidad){
    $conexion = connectDB();
    $query = "UPDATE LINEA_PEDIDO SET cantidad = ? WHERE id_linea_pedido = ? ";
    $stmt = $conexion->prepare($query);

    if(!$stmt){
        die("Error al preparar la consulta" . $conexion->error);
    }

    $stmt->bind_param("ii",$cantidad,$id_linea_pedido);

    if($stmt->execute()){
        return true;
    }else{
        return false;
    }
    $conexion->close();
    $stmt->close();
}
function deleteOrderLine($id_linea_pedido){

    $conexion = connectDB();
    $query = "DELETE FROM LINEA_PEDIDO WHERE linea_pedido.id_linea_pedido = ?";
    $stmt = $conexion->prepare($query);

    if(!$stmt){
        die("Error al preparar la consulta" . $conexion->error);
    }

    $stmt->bind_param("i",$id_linea_pedido);
    if($stmt->execute()){

        return "Se ha eliminado del carrito";
    }
    $stmt->close();
    $conexion->close();

}
function getOrderLineId($id_pedido, $id_producto){

    $conexion = connectDB();
    $id_linea_pedido = null;
    $query = "SELECT id_linea_pedido  FROM LINEA_PEDIDO WHERE id_pedido = ? AND id_producto = ?";
    $stmt = $conexion->prepare($query);
    
    if(!$stmt){
        die("Error al preparar la consulta" . $conexion->error);
    }

    $stmt->bind_param("ii",$id_pedido, $id_producto);

    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $id_linea_pedido = $row["id_linea_pedido"];
    }

    $conexion->close();
    $stmt->close();

    return $id_linea_pedido;
}

function getUserOrders($id_pedido){

    $conexion = connectDB();

    $query = "SELECT talla, precio_unitario, cantidad,imagen,producto.id_producto
	FROM LINEA_PEDIDO INNER JOIN pedidos
    ON linea_pedido.id_pedido = pedidos.id_pedido 
    INNER JOIN producto ON linea_pedido.id_producto = producto.id_producto
    WHERE pedidos.id_pedido = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i",$id_pedido);
    $stmt->execute();

    if(!$stmt){
        die("Error al preparar la consulta " . $conexion->error);
    }
    $result = $stmt->get_result();
    $orders = array();

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $orders [] = [
                "talla" => $row["talla"],
                "precio_unitario" => $row["precio_unitario"],
                "cantidad" => $row["cantidad"],
                "imagen" => $row["imagen"],
                "id_producto" => $row["id_producto"],
            ];
        }
    }
    return $orders;
    $stmt->close();
    $conexion->close();

}
function sumOrdersUser ($id_pedido){

        $conexion = connectDB();
        $query = "SELECT SUM(cantidad * precio_unitario) AS total
                    FROM linea_pedido WHERE id_pedido = ?";
        $stmt = $conexion->prepare($query);

        if(!$stmt){
            die("Error al ejecutar la consulta" . $conexion->error);
        }
        $stmt->bind_param("i",$id_pedido);
        $stmt->execute();
        $result = $stmt->get_result();
        $total = null;

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $total = $row["total"];
            }
        }

        return $total ? $total : 0;
        

}

function checkOrderLine($id_pedido, $id_producto,$talla){
    $conexion = connectDB();
    $query = "SELECT * FROM LINEA_PEDIDO WHERE linea_pedido.id_pedido = ?
     AND linea_pedido.id_producto = ? AND talla = ? ";
    $stmt = $conexion->prepare($query);

    if(!$stmt){
        die("Error al ejecutar la consulta " . $conexion->error);
    }

    $stmt->bind_param("iis",$id_pedido,$id_producto,$talla);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        return $result->fetch_assoc();
    }else{
        return null;
    }
}