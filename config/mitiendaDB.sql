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
CREATE TABLE IF NOT EXISTS LINEA_PEDIDO(
    id_linea_pedido INTEGER AUTO_INCREMENT PRIMARY KEY,
    id_pedido INTEGER NOT NULL,
    id_producto INTEGER NOT NULL,
    talla SET ("S","M","L","XXL") NOT NULL,
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



INSERT INTO PRODUCTO (id_categoria, precio, color, imagen, descripcion, nombre_producto, cantidad_stock) VALUES
(1, 24.99, 'Azul', 'Camiseta-Azul.jpg', 'Camiseta básica de algodón', 'Camiseta Azul', 50),
(1, 29.99, 'Azul', 'Camiseta-Azul-Manga-larga.png', 'Camiseta de manga larga', 'Camiseta Azul Manga Larga', 40),
(1, 24.99, 'Beige', 'camiseta-beige.png', 'Camiseta básica de algodón', 'Camiseta Beige', 30),
(1, 29.99, 'Beige', 'camiseta-beige-manga-larga.png', 'Camiseta de manga larga', 'Camiseta Beige Manga Larga', 35),
(1, 24.99, 'Negro', 'camiseta-negra.png', 'Camiseta básica de algodón', 'Camiseta Negra', 30),
(2, 39.99, 'Negro', 'pantalon-negro.png', 'Pantalón negro de vestir', 'Pantalón Negro', 30),
(2, 39.99, 'Gris', 'pantalon-gris.png', 'Pantalón gris casual', 'Pantalón Gris', 25),
(3, 49.99, 'Azul', 'chaqueta-azul.png', 'Sudadera azul', 'Sudadera Azul', 25),
(3, 49.99, 'Marrón', 'chaqueta-marron.png', 'Sudadera marrón', 'Sudadera Marrón', 20),
(3, 49.99, 'Negro', 'chaqueta-negra.png', 'Sudadera negra', 'Sudadera Negra', 18),
(4, 24.99, 'Beige', 'short-beige-2.png', 'Short clásico beige', 'Short Beige Modelo 2', 20),
(4, 24.99, 'Beige', 'short-beige.png', 'Short clásico beige', 'Short Beige', 25),
(5, 19.99, 'Azul', 'gorra-azul.png', 'Gorra deportiva azul', 'Gorra Azul', 50),
(5, 19.99, 'Negro', 'gorra-negra.png', 'Gorra deportiva negra', 'Gorra Negra', 40),
(6, 49.99, 'Azul', 'chaqueta-azul.png', 'Chaqueta acolchada azul', 'Chaqueta Azul', 25),
(6, 49.99, 'Marrón', 'chaqueta-marron.png', 'Chaqueta acolchada marrón', 'Chaqueta Marrón', 20),
(6, 49.99, 'Negro', 'chaqueta-negra.png', 'Chaqueta acolchada negra', 'Chaqueta Negra', 18),
(7, 34.99, 'Beige', 'polo-beige.png', 'Polo de algodón beige', 'Polo Beige', 35),
(7, 34.99, 'Negro', 'polo-black.png', 'Polo de algodón negro', 'Polo Negro', 40),
(7, 34.99, 'Marrón', 'polo-browndark.png', 'Polo marrón oscuro', 'Polo Marrón Oscuro', 25),
(7, 34.99, 'Verde', 'polo-verde.png', 'Polo de algodón verde', 'Polo Verde', 30),
(8, 14.99, 'Gris', 'gloves-grey.png', 'Guantes de lana grises', 'Guantes Grises', 30),
(8, 14.99, 'Negro', 'gloves-black.png', 'Guantes de lana negros', 'Guantes Negros', 25),
(8, 14.99, 'Marrón', 'gloves-brown.png', 'Guantes de lana marrones', 'Guantes Marrones', 20),
(9, 59.99, 'Blanco', 'zapatillas-blancas.png', 'Zapatillas deportivas blancas', 'Zapatillas Blancas', 20),
(9, 59.99, 'Negro', 'zapatillas-negras.png', 'Zapatillas deportivas negras', 'Zapatillas Negras', 25),
(9, 49.99, 'Marrón', 'zapato.png', 'Zapatos de vestir marrones', 'Zapatos Marrones', 15),
(1, 19.99, 'Negro', 't-shirt-black.png', 'Camiseta básica negra', 'Camiseta Negra', 50);









