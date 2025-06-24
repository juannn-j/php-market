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
('Juan Pérez', 'juan@example.com', '1234', 'C'), -- C = Cliente
('Admin General', 'admin@example.com', 'admin123', 'A'); -- A = Administrador

INSERT INTO articulos (nombre, marca, descripcion, precio, stock, imagen_url)
VALUES 
('Lenovo IdeaPad 3', 'Lenovo', 'Laptop básica con procesador AMD Ryzen 5, 8GB RAM, SSD 256GB.', 1899.99, 10, '"https://p1-ofp.static.pub/medias/bWFzdGVyfHJvb3R8MjY5MjEzfGltYWdlL3BuZ3xoODYvaDUzLzE0MTg2OTE5NTkxOTY2LnBuZ3w2ODgwOTdhZDhlODAwNTYzZmVlNDcwNzE5MGI3MzEzMWNiMTIxYmY5NWE3MzcxZDA1NzM2MzkwNWRlYzQ0MDU3/lenovo-laptop-ideapad-3-14-intel-subseries-hero.png"'),
('HP Pavilion x360', 'HP', 'Laptop convertible 2 en 1 con pantalla táctil, 16GB RAM, Intel i5.', 2799.00, 5, '"https://media.falabella.com/falabellaPE/142585094_01/w=1500,h=1500,fit=pad"');

-- Más Inserciones de registros de la tabla articulos
INSERT INTO articulos (nombre, marca, descripcion, precio, stock, imagen_url)
VALUES 
('Asus VivoBook 15', 'Asus', 'Pantalla de 15.6", Ryzen 7, 12GB RAM, 512GB SSD, Windows 11.', 2999.50, 8, 'https://m.media-amazon.com/images/I/71SCvh0L3OL._AC_SL1500_.jpg'),
('Acer Aspire 5', 'Acer', 'Laptop liviana con Intel Core i5, 8GB RAM y 512GB SSD.', 2599.99, 6, 'https://m.media-amazon.com/images/I/71SCvh0L3OL._AC_SL1500_.jpg'),
('Apple MacBook Air M2', 'Apple', 'Ultraligera, chip M2, 8GB RAM, 256GB SSD, pantalla Retina.', 5299.00, 4, 'https://www.hoxtonmacs.co.uk/cdn/shop/files/apple-macbook-air-13-inch-macbook-air-13-inch-m2-space-grey-2022-fair-41944507318588.jpg?v=1688461351'),
('Dell XPS 13', 'Dell', 'Diseño premium, Intel Core i7, 16GB RAM, 512GB SSD.', 4899.90, 3, 'https://www.ubuy.pe/productimg/?image=aHR0cHM6Ly9tLm1lZGlhLWFtYXpvbi5jb20vaW1hZ2VzL0kvNzEwRUdKQmRJTUwuX0FDX1NMMTUwMF8uanBn.jpg'),
('MSI GF63 Thin', 'MSI', 'Laptop gamer, Intel Core i5, GTX 1650, 8GB RAM, 512GB SSD.', 3799.99, 7, 'https://rymportatiles.com.pe/cdn/shop/files/MSI-Thin-GF63-12VE-2.png?v=1741365576&width=1214'),
('Huawei MateBook D14', 'Huawei', 'Intel Core i5, 8GB RAM, 512GB SSD, diseño metálico.', 2399.00, 9, 'https://home.ripley.com.pe/Attachment/WOP_5/2004286003883/2004286003883-2.jpg'),
('Samsung Galaxy Book2', 'Samsung', 'Diseño delgado, Intel Core i5, 8GB RAM, 256GB SSD.', 2590.00, 6, 'https://oechsle.vteximg.com.br/arquivos/ids/15314142-1000-1000/image-7dc34b55c62a40e98a2ddb3a8937d085.jpg?v=638281859939000000'),
('LG Gram 16', 'LG', 'Laptop ultraligera de 16", Intel Evo i7, 16GB RAM, 1TB SSD.', 6399.99, 2, 'https://m.media-amazon.com/images/I/81RJE4fQSdL._AC_SL1500_.jpg'),
('HP Omen 16', 'HP', 'Laptop gamer con Intel i7, RTX 3060, 16GB RAM, 1TB SSD.', 6699.00, 5, 'https://oechsle.vteximg.com.br/arquivos/ids/18751959-1000-1000/image-35124f9918a54cb5afa5c4fdc8eaabf6.jpg?v=638629868710130000'),
('Asus ROG Zephyrus G14', 'Asus', 'Laptop gamer con Ryzen 9, RTX 4060, 16GB RAM, 1TB SSD.', 7499.99, 4, 'https://dlcdnwebimgs.asus.com/gain/08000E15-8711-44FD-9B43-067CAC3F3A78'),
('Lenovo Legion 5', 'Lenovo', 'Ryzen 7, RTX 3060, 16GB RAM, 512GB SSD, 165Hz display.', 6390.50, 3, 'https://p3-ofp.static.pub//fes/cms/2024/09/12/m1jnssoporjtlmma8zqy3ssoour2yj992790.png'),
('Apple MacBook Pro M3', 'Apple', 'Laptop con chip M3, 16GB RAM, 512GB SSD, pantalla Liquid Retina.', 8999.00, 2, 'https://www.peru-smart.com/wp-content/uploads/2024/09/LAMA1000GRIS-512GBSSD_0.jpg'),
('Dell Inspiron 15', 'Dell', 'Laptop para trabajo diario, Intel i5, 8GB RAM, 512GB SSD.', 2299.90, 6, 'https://laptopshop.pe/wp-content/uploads/2024/02/Dell-inspiron-15-3520-4.jpg'),
('Acer Nitro 5', 'Acer', 'Laptop gamer con Ryzen 5, GTX 1650, 16GB RAM, 512GB SSD.', 3999.00, 5, 'https://m.media-amazon.com/images/I/71s1LRpaprL._AC_SL1500_.jpg'),
('Microsoft Surface Laptop 5', 'Microsoft', 'Pantalla táctil de 13.5", Intel i5, 8GB RAM, 256GB SSD.', 4799.00, 3, 'https://oechsle.vteximg.com.br/arquivos/ids/15313790-1000-1000/image-0ec066b644db477abfa421d9a99009f7.jpg?v=638281851981370000'),
('Samsung Galaxy Book3 Pro', 'Samsung', 'Pantalla AMOLED 3K, Intel i7, 16GB RAM, 512GB SSD.', 6490.00, 2, 'https://oechsle.vteximg.com.br/arquivos/ids/15312394-1000-1000/image-b53f23081da742399c4840662e692618.jpg?v=638281818215870000'),
('MSI Katana GF66', 'MSI', 'Laptop gamer con Intel i7, RTX 3050, 16GB RAM, 512GB SSD.', 4599.99, 4, 'https://asset.msi.com/resize/image/global/product/product_1619086146fdfbc8b34331ebecbf18cb444480b7d1.png62405b38c58fe0f07fcef2367d8a9ba1/600.png'),
('Gigabyte Aorus 15P', 'Gigabyte', 'Laptop gamer de alto rendimiento con i7, RTX 3070, 32GB RAM.', 7499.00, 2, 'https://www.kabifperu.com/imagenes/prod-24022021204746-laptop-gigabyte-aorus-15p-xc-i7-10870h-xc-8la2430sh-gaming-15-6-i7-512-ssd-32gb-rtx3070-8g-w10-deta.png');