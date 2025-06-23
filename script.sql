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


INSERT INTO usuarios (nombre, email, password, tipo)
VALUES 
('Juan Pérez', 'juan@example.com', '1234', 'C'),  -- C = Cliente
('Admin General', 'admin@example.com', 'admin123', 'A');  -- A = Administrador

INSERT INTO articulos (nombre, marca, descripcion, precio, stock, imagen_url)
VALUES 
('Lenovo IdeaPad 3', 'Lenovo', 'Laptop básica con procesador AMD Ryzen 5, 8GB RAM, SSD 256GB.', 1899.99, 10, 'https://example.com/lenovo.jpg'),
('HP Pavilion x360', 'HP', 'Laptop convertible 2 en 1 con pantalla táctil, 16GB RAM, Intel i5.', 2799.00, 5, 'https://example.com/hp.jpg');