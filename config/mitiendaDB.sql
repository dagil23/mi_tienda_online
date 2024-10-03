CREATE DATABASE IF NOT EXISTS mitiendaDB;
USE mitiendaDB;

CREATE TABLE IF NOT EXISTS USUARIOS(

    id_usuario INTEGER AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE KEY,
    fecha_registro DATE DEFAULT CURDATE(),
    contraseña  VARCHAR(100) NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    telefono VARCHAR(100) NOT NULL,
    rol ENUM("admin", "user") NOT NULL
    

);
CREATE TABLE IF NOT EXISTS PEDIDOS(

    id_pedido INTEGER AUTO_INCREMENT PRIMARY KEY,
    pedido_usuario INT NOT NULL,
    dni VARCHAR(9) NOT NULL,
    precio_total DECIMAL(10,2) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    tallas_disponibles SET ("S","M","L","XXL") NOT NULL,
    fecha_pedido DATE DEFAULT CURDATE(),
    estado ENUM("entregado","pendiente","procesado","enviado","carrito") NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    FOREIGN KEY (pedido_usuario )REFERENCES USUARIOS (id_usuario)

);
CREATE TABLE IF NOT EXISTS CATEGORIA(

    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    descripcion VARCHAR (255) NOT NULL,
    nombre VARCHAR (100) NOT NULL
);


CREATE TABLE IF NOT EXISTS WISHLIST(

    id_wishlist INTEGER AUTO_INCREMENT PRIMARY KEY,
    id_usuario INTEGER NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    fecha_creacion DATE DEFAULT CURDATE(),
    FOREIGN KEY (id_usuario) REFERENCES USUARIOS (id_usuario)
);
CREATE TABLE IF NOT EXISTS PRODUCTO(

    id_producto INTEGER AUTO_INCREMENT PRIMARY KEY,
    id_categoria INTEGER,
    precio DECIMAL(10,2) NOT NULL,
    imagen VARCHAR(255),
    descripcion VARCHAR(255) NOT NULL,
    nombre_producto VARCHAR(100) NOT NULL,
    cantidad_stock INT NOT NULL,
    FOREIGN KEY (id_categoria) REFERENCES CATEGORIA (id_categoria)

);
CREATE TABLE IF NOT EXISTS RESEÑAS(
    id_reseña INTEGER AUTO_INCREMENT PRIMARY KEY,
    id_usuario INTEGER,
    calificacion VARCHAR(100),
    fecha_reseña DATE DEFAULT CURDATE(),
    contenido VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES USUARIOS (id_usuario)
);
CREATE TABLE IF NOT EXISTS LENEA_PEDIDO(
    id_linea_pedido INTEGER AUTO_INCREMENT PRIMARY KEY,
    id_pedido INTEGER NOT NULL,
    id_producto INTEGER NOT NULL,
    precio_unitario DECIMAL (10,2) NOT NULL,
    cantidad INT NOT NULL,
    FOREIGN KEY (id_pedido) REFERENCES PEDIDOS (id_pedido),
    FOREIGN KEY (id_producto) REFERENCES PRODUCTO (id_producto)
);

CREATE TABLE IF NOT EXISTS WISHLIST_PRODUCT(
    id_producto INTEGER ,
    id_wishlist INTEGER ,
    fecha_agregado DATE DEFAULT CURDATE(),
    PRIMARY KEY (id_producto,id_wishlist),
    FOREIGN KEY (id_producto) REFERENCES PRODUCTO (id_producto),
    FOREIGN KEY (id_wishlist) REFERENCES WISHLIST (id_wishlist)

);




