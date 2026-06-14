-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS tienda;
USE tienda;

-- Tabla de roles
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,       -- Nombre del rol (admin, editor, cliente)
    descripcion TEXT                   -- Descripción del rol
);

-- Insertar roles básicos
INSERT INTO roles (nombre, descripcion) VALUES
('admin', 'Administrador con acceso total al sistema'),
('editor', 'Editor con permisos para gestionar contenido y productos'),
('cliente', 'Cliente estándar con acceso a la tienda y realizar compras');

-- Tabla de usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,      -- Nombre del usuario
    email VARCHAR(100) NOT NULL UNIQUE,-- Correo electrónico único
    password VARCHAR(255) NOT NULL,    -- Contraseña
    rol_id INT DEFAULT 3,              -- Rol del usuario (por defecto es cliente)
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Fecha de registro
    FOREIGN KEY (rol_id) REFERENCES roles(id)           -- Relación con la tabla de roles
);

-- Insertar usuarios de ejemplo
INSERT INTO usuarios (nombre, email, password, rol_id) VALUES
('Juan Pérez', 'juan.admin@example.com', 'hashedpassword1', 1), -- Admin
('Ana García', 'ana.editor@example.com', 'hashedpassword2', 2), -- Editor
('Carlos López', 'carlos.cliente@example.com', 'hashedpassword3', 3); -- Cliente

-- Tabla de categorías
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,       -- Nombre de la categoría
    descripcion TEXT                    -- Descripción de la categoría
);

-- Insertar categorías de ejemplo
INSERT INTO categorias (nombre, descripcion) VALUES
('Electrónica', 'Productos electrónicos como teléfonos, tablets, etc.'),
('Ropa', 'Ropa para todas las edades y géneros'),
('Hogar', 'Artículos para el hogar y muebles'),
('Libros', 'Libros de todas las categorías y géneros'),
('Deportes', 'Productos relacionados con deportes y fitness');

-- Tabla de productos
-- Crear tabla de productos con el campo imagen
CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,       -- Nombre del producto
    descripcion TEXT,                   -- Descripción del producto
    imagen VARCHAR(255),                -- Ruta de la imagen del producto
    precio DECIMAL(10, 2) NOT NULL,     -- Precio del producto
    categoria_id INT,                   -- Categoría a la que pertenece el producto
    stock INT DEFAULT 0,                -- Stock disponible
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Fecha de creación del producto
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) -- Relación con la tabla de categorías
);

-- Insertar productos con imágenes
INSERT INTO productos (nombre, descripcion, imagen, precio, categoria_id, stock) VALUES
('iPhone 13', 'Teléfono inteligente de última generación con 128GB de almacenamiento.', 'imagenes/iphone13.jpg', 999.99, 1, 10),
('Laptop Dell XPS 13', 'Laptop ligera con procesador Intel Core i7 y 16GB de RAM.', 'imagenes/dellxps13.jpg', 1299.99, 1, 5),
('Camiseta de algodón', 'Camiseta cómoda y suave disponible en varios colores.', 'imagenes/camiseta.jpg', 19.99, 2, 50),
('Sofá moderno', 'Sofá de tres plazas con diseño moderno para la sala.', 'imagenes/sofa_moderno.jpg', 399.99, 3, 3),
('El Quijote', 'Edición especial del clásico de Cervantes.', 'imagenes/elquijote.jpg', 14.99, 4, 100),
('Bicicleta de montaña', 'Bicicleta todo terreno con suspensión y frenos de disco.', 'imagenes/bicicleta_montana.jpg', 499.99, 5, 7);

-- Tabla de compras
CREATE TABLE compras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,                    -- ID del usuario que realizó la compra
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Fecha de la compra
    total DECIMAL(10, 2) NOT NULL,     -- Total de la compra
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)  -- Relación con la tabla de usuarios
);

-- Tabla de detalle de compras
CREATE TABLE detalle_compras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    compra_id INT,                     -- ID de la compra (referencia a la tabla de compras)
    producto_id INT,                   -- ID del producto adquirido
    cantidad INT NOT NULL,             -- Cantidad comprada del producto
    precio DECIMAL(10, 2) NOT NULL,    -- Precio del producto en el momento de la compra
    FOREIGN KEY (compra_id) REFERENCES compras(id) ON DELETE CASCADE,  -- Relación con la tabla de compras
    FOREIGN KEY (producto_id) REFERENCES productos(id)                 -- Relación con la tabla de productos
);

