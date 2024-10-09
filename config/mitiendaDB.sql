DROP DATABASE IF EXISTS;
CREATE DATABASE IF NOT EXISTS mitiendaDB;
USE mitiendaDB;

CREATE TABLE IF NOT EXISTS USUARIOS(

    id_usuario INTEGER AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE KEY,
    dni VARCHAR(9) UNIQUE KEY,
    fecha_registro DATE DEFAULT CURDATE(),
    contraseña  VARCHAR(100) NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    telefono VARCHAR(100) NOT NULL,
    rol ENUM("admin", "user") NOT NULL DEFAULT "user"
    

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


INSERT INTO USUARIOS (nombre, apellido, email, contraseña, direccion, telefono, rol) VALUES
('Daniel', 'Martínez', 'daniel@example.com', 'contraseñaSegura1', 'Calle Falsa 123', '123456789', 'admin'),
('Laura', 'González', 'laura@example.com', 'contraseñaSegura2', 'Avenida Siempre Viva 456', '987654321', 'user'),
('Pedro', 'López', 'pedro@example.com', 'contraseñaSegura3', 'Calle Verde 789', '123456789', 'user'),
('Ana', 'Sánchez', 'ana@example.com', 'contraseñaSegura4', 'Calle Azul 321', '321654987', 'user'),
('Carlos', 'Ramírez', 'carlos@example.com', 'contraseñaSegura5', 'Avenida del Sol 654', '654321987', 'user');

INSERT INTO PEDIDOS (pedido_usuario, dni, precio_total, nombre, apellidos, tallas_disponibles, estado, direccion) VALUES
(1, '12345678A', 49.99, 'Daniel', 'Martínez', 'M', 'entregado', 'Calle Falsa 123'),
(2, '87654321B', 29.99, 'Laura', 'González', 'S', 'pendiente', 'Avenida Siempre Viva 456'),
(3, '23456789C', 89.99, 'Pedro', 'López', 'L', 'procesado', 'Calle Verde 789'),
(4, '34567890D', 59.99, 'Ana', 'Sánchez', 'XXL', 'enviado', 'Calle Azul 321'),
(5, '45678901E', 39.99, 'Carlos', 'Ramírez', 'M', 'carrito', 'Avenida del Sol 654');

INSERT INTO CATEGORIA (descripcion, nombre) VALUES
('Ropa de mujer', 'Mujer'),
('Ropa de hombre', 'Hombre'),
('Accesorios', 'Accesorios'),
('Calzado', 'Calzado'),
('Complementos', 'Complementos');

INSERT INTO WISHLIST (id_usuario, nombre) VALUES
(1, 'Wishlist de Daniel'),
(2, 'Wishlist de Laura'),
(3, 'Wishlist de Pedro'),
(4, 'Wishlist de Ana'),
(5, 'Wishlist de Carlos');

INSERT INTO PRODUCTO (id_categoria, precio, imagen, descripcion, nombre_producto, cantidad_stock) VALUES
(1, 29.99, 'img1.jpg', 'Camiseta de algodón', 'Camiseta Básica', 50),
(2, 39.99, 'img2.jpg', 'Jeans de corte recto', 'Jeans Clásicos', 30),
(3, 15.99, 'img3.jpg', 'Gorra de verano', 'Gorra Trendy', 100),
(4, 49.99, 'img4.jpg', 'Zapatillas deportivas', 'Zapatillas Sport', 20),
(5, 25.99, 'img5.jpg', 'Bufanda de lana', 'Bufanda Elegante', 60);

INSERT INTO RESEÑAS (id_usuario, calificacion, contenido) VALUES
(1, '5 estrellas', 'Excelente producto, me encantó.'),
(2, '4 estrellas', 'Buena calidad, pero el tamaño no era el correcto.'),
(3, '5 estrellas', 'Me llegó rápido y en perfectas condiciones.'),
(4, '3 estrellas', 'El diseño es bonito, pero no es muy cómodo.'),
(5, '4 estrellas', 'Rápido y eficiente, volveré a comprar.');

INSERT INTO LENEA_PEDIDO (id_pedido, id_producto, precio_unitario, cantidad) VALUES
(1, 1, 29.99, 1),
(2, 2, 39.99, 1),
(3, 4, 49.99, 2),
(4, 3, 15.99, 1),
(5, 5, 25.99, 1);

INSERT INTO WISHLIST_PRODUCT (id_producto, id_wishlist) VALUES
(1, 1),
(2, 1),
(3, 2),
(4, 3),
(5, 4);


