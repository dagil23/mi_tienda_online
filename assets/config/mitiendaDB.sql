CREATE DATABASE IF NOT EXISTS mitiendaDB;
USE mitiendaDB;

CREATE TABLE IF NOT EXISTS USUARIOS(

    id_usuario INTEGER AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    apellido VARCHAR(100),
    email VARCHAR(100),
    fecha_registro DATE,
    contraseña  VARCHAR(100),
    direccion VARCHAR(255),
    telefono VARCHAR(100)

);
CREATE TABLE IF NOT EXISTS PEDIDOS(

    id_pedido INTEGER AUTO_INCREMENT PRIMARY KEY,
    pedido_usuario INT NOT NULL,
    dni VARCHAR(9),
    precio_total DECIMAL(10,2),
    nombre VARCHAR(100),
    apellidos VARCHAR(100),
    fecha_pedido DATE,
    estado VARCHAR(50),
    direccion VARCHAR(255),
    FOREIGN KEY pedido_usuario REFERENCES USUARIOS (id_usuario)

);
CREATE TABLE IF NOT EXISTS CATEGORIA(

    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    descripcion VARCHAR (255),
    nombre VARCHAR (100)
    
);


CREATE TABLE IF NOT EXISTS WISHLIST(

    id_wishlist INTEGER AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    fecha_creacion DATE
);
CREATE TABLE IF NOT EXISTS PRODUCTO(

    id_producto INTEGER AUTO_INCREMENT PRIMARY KEY,
    id_categoria INTEGER AUTO_INCREMENT,
    precio DECIMAL(10,2),
    imagen VARCHAR(255),
    descripcion VARCHAR(255),
    nombre_producto VARCHAR(100),
    cantidad_stock INT,
    FOREIGN KEY id_categoria REFERENCES CATEGORIA (id_categoria)

);
CREATE TABLE IF NOT EXISTS RESEÑAS(
    id_reseña INTEGER AUTO_INCREMENT PRIMARY KEY,
    id_usuario INTEGER AUTO_INCREMENT,
    calificacion VARCHAR(100),
    fecha_reseña DATE,
    contenido VARCHAR(255),
    FOREIGN KEY id_usuario REFERENCES USUARIOS (id_usuario)
);
CREATE TABLE IF NOT EXISTS LENEA_PEDIDO(
    id_linea_pedido INTEGER AUTO_INCREMENT PRIMARY KEY,
    id_pedido INTEGER AUTO_INCREMENT,
    id_producto INTEGER AUTO_INCREMENT,
    precio_total DECIMAL (10,2),
    cantidad INT,
    FOREIGN KEY id_pedido REFERENCES PEDIDOS (id_pedido),
    FOREIGN KEY id_producto REFERENCES PRODUCTO (id_producto)
);

CREATE TABLE IF NOT EXISTS WISHLIST_PRODUCT(
    id_producto INTEGER AUTO_INCREMENT,
    id_wishlist INTEGER AUTO_INCREMENT,
    PRIMARY KEY (id_producto,id_wishlist)
);