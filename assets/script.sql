-- Tabla de usuarios
CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100),
    email VARCHAR(100),
    password TEXT,
	tipo VARCHAR(1) -- C:cliente, A:administrador
);

-- Tabla de laptops
CREATE TABLE articulos (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(150),
	marca VARCHAR(150),
    descripcion TEXT,
    precio DECIMAL(10, 2),
    stock INTEGER,
    imagen_url TEXT
);

-- Tabla de pedidos
CREATE TABLE pedidos (
    id SERIAL PRIMARY KEY,
    usuario_id INTEGER REFERENCES usuarios(id),
    fecha TIMESTAMP,
    total DECIMAL(10, 2)
);

-- Tabla de detalles del pedido
CREATE TABLE pedido_detalles (
    id SERIAL PRIMARY KEY,
    pedido_id INTEGER REFERENCES pedidos(id) ON DELETE CASCADE,
    articulo_id INTEGER REFERENCES articulos(id),
    cantidad INTEGER,
    precio_unitario DECIMAL(10, 2)
);

-- Insertar usuarios de prueba
INSERT INTO usuarios (nombre, email, password, tipo)
VALUES 
('Juan Pérez', 'juan@example.com', '1234', 'C'), -- C = Cliente
('Admin General', 'admin@example.com', 'admin123', 'A'); -- A = Administrador

-- Insertar artículos de prueba
INSERT INTO articulos (nombre, marca, descripcion, precio, stock, imagen_url)
VALUES 
('Lenovo IdeaPad 3', 'Lenovo', 'Laptop básica con procesador AMD Ryzen 5, 8GB RAM, SSD 256GB.', 1899.99, 10, 'https://p1-ofp.static.pub/medias/bWFzdGVyfHJvb3R8MjY5MjEzfGltYWdlL3BuZ3xoODYvaDUzLzE0MTg2OTE5NTkxOTY2LnBuZ3w2ODgwOTdhZDhlODAwNTYzZmVlNDcwNzE5MGI3MzEzMWNiMTIxYmY5NWE3MzcxZDA1NzM2MzkwNWRlYzQ0MDU3/lenovo-laptop-ideapad-3-14-intel-subseries-hero.png'),
('HP Pavilion x360', 'HP', 'Laptop convertible 2 en 1 con pantalla táctil, 16GB RAM, Intel i5.', 2799.00, 5, 'https://media.falabella.com/falabellaPE/142585094_01/w=1500,h=1500,fit=pad'),
('Asus VivoBook 15', 'Asus', 'Pantalla de 15.6", Ryzen 7, 12GB RAM, 512GB SSD, Windows 11.', 2999.50, 8, 'https://m.media-amazon.com/images/I/71SCvh0L3OL._AC_SL1500_.jpg'),
('Acer Aspire 5', 'Acer', 'Laptop liviana con Intel Core i5, 8GB RAM y 512GB SSD.', 2599.99, 6, 'https://m.media-amazon.com/images/I/71SCvh0L3OL._AC_SL1500_.jpg'),
('Apple MacBook Air M2', 'Apple', 'Ultraligera, chip M2, 8GB RAM, 256GB SSD, pantalla Retina.', 5299.00, 4, 'https://www.hoxtonmacs.co.uk/cdn/shop/files/apple-macbook-air-13-inch-macbook-air-13-inch-m2-space-grey-2022-fair-41944507318588.jpg?v=1688461351');

-- Crear extensión para búsqueda por similitud
CREATE EXTENSION IF NOT EXISTS pg_trgm; 