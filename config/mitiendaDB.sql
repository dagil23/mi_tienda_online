DROP DATABASE IF EXISTS mitiendaDB;
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
    nombre VARCHAR (100) UNIQUE KEY NOT NULL, 
    imagen VARCHAR (100) NOT NULL
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
    color VARCHAR(15) NOT NULL,
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

INSERT INTO USUARIOS (nombre, apellido, email, dni, contraseña, direccion, telefono, rol) VALUES
('Daniel', 'Martínez', 'daniel@example.com','12345678A', 'contraseñaSegura1', 'Calle Falsa 123', '123456789', 'admin'),
('Laura', 'González', 'laura@example.com','87654321B', 'contraseñaSegura2', 'Avenida Siempre Viva 456', '987654321', 'user'),
('Pedro', 'López', 'pedro@example.com', '23456789C','contraseñaSegura3', 'Calle Verde 789', '123456789', 'user'),
('Ana', 'Sánchez', 'ana@example.com', '34567890D','contraseñaSegura4', 'Calle Azul 321', '321654987', 'user'),
('Carlos', 'Ramírez', 'carlos@example.com', '45678901E','contraseñaSegura5', 'Avenida del Sol 654', '654321987', 'user');

INSERT INTO PEDIDOS (pedido_usuario, dni, precio_total, nombre, apellidos, tallas_disponibles, estado, direccion) VALUES
(1, '12345678A', 49.99, 'Daniel', 'Martínez', 'M', 'entregado', 'Calle Falsa 123'),
(2, '87654321B', 29.99, 'Laura', 'González', 'S', 'pendiente', 'Avenida Siempre Viva 456'),
(3, '23456789C', 89.99, 'Pedro', 'López', 'L', 'procesado', 'Calle Verde 789'),
(4, '34567890D', 59.99, 'Ana', 'Sánchez', 'XXL', 'enviado', 'Calle Azul 321'),
(5, '45678901E', 39.99, 'Carlos', 'Ramírez', 'M', 'carrito', 'Avenida del Sol 654');

INSERT INTO CATEGORIA (nombre, descripcion, imagen) VALUES
('Camisetas', 'Ropa de vestir para la parte superior del cuerpo, generalmente casual.', 'camisa.png'),
('Pantalones', 'Ropa para la parte inferior del cuerpo, generalmente cubriendo ambas piernas.', 'pantalones.png'),
('Sudaderas', 'Prendas cómodas para el torso, con o sin capucha.', 'sudadera.png'),
('Shorts', 'Prendas cortas para la parte inferior del cuerpo, ideales para el clima cálido.', 'short.png'),
('Gorras', 'Accesorios para la cabeza, comúnmente utilizados para el sol o estilo.', 'gorra.png'),
('Chaquetas', 'Prendas exteriores que protegen contra el frío o el clima.', 'chaqueta.png'),
('Polos', 'Camisas con cuello y botones, normalmente de algodón.', 'polos.png'),
('Guantes', 'Prendas que cubren las manos y protegen contra el frío.', 'guantes.png'),
('Zapatos', 'Calzado para proteger los pies y proporcionar confort.', 'zapatos.png');


INSERT INTO WISHLIST (id_usuario, nombre) VALUES
(1, 'Wishlist de Daniel'),
(2, 'Wishlist de Laura'),
(3, 'Wishlist de Pedro'),
(4, 'Wishlist de Ana'),
(5, 'Wishlist de Carlos');


INSERT INTO PRODUCTO (id_categoria, precio, color, imagen, descripcion, nombre_producto, cantidad_stock) VALUES
(1, 30.00, 'Beige', 'camiseta-beige.png', 'Camiseta de algodón', 'Camiseta Básica Beige', 50),
(1, 30.00, 'Negro', 'camiseta-negra.png', 'Camiseta de algodón', 'Camiseta Básica Negra', 30),
(3, 34.00, 'Beige', 'polo-beige.png', 'Polo de algodón beige', 'Polo Beige', 40),
(3, 34.99, 'Beige', 'polo-beige-back.png', 'Polo de algodón beige (vista trasera)', 'Polo Beige Vista Trasera', 40),
(3, 34.99, 'Negro', 'polo-black.png', 'Polo de algodón negro', 'Polo Negro', 35),
(3, 34.99, 'Marrón', 'polo-browndark.png', 'Polo marrón oscuro', 'Polo Marrón Oscuro', 25),
(4, 24.99, 'Beige', 'short-beige-2.png', 'Short clásico beige', 'Short Beige Modelo 2', 20),
(4, 24.99, 'Beige', 'short-beige.png', 'Short clásico beige', 'Short Beige', 30),
(4, 24.99, 'Negro', 'short-black-2.png', 'Short clásico negro', 'Short Negro Modelo 2', 15),
(4, 24.99, 'Negro', 'short-black.png', 'Short clásico negro', 'Short Negro', 25),
(1, 29.99, 'Negro', 't-shirt-black.png', 'Camiseta básica negra', 'Camiseta Negra', 40),
(1, 29.99, 'Blanco', 'camiseta-blanca.png', 'Camiseta de algodón', 'Camiseta Básica Blanca', 50),
(2, 39.99, 'Azul', 'pantalon-azul.png', 'Pantalón vaquero azul', 'Pantalón Azul', 30),
(3, 25.99, 'Negro', 'sudadera-negra.png', 'Sudadera de algodón', 'Sudadera Negra', 40),
(4, 19.99, 'Marrón', 'short-marron.png', 'Short casual de algodón', 'Short Marrón', 25),
(5, 15.99, 'Negro', 'gorra-negra.png', 'Gorra clásica negra', 'Gorra Negra', 60),
(6, 49.99, 'Verde', 'chaqueta-verde.png', 'Chaqueta casual', 'Chaqueta Verde', 20),
(7, 29.99, 'Blanco', 'polo-blanco.png', 'Polo blanco de algodón', 'Polo Blanco', 35);


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


