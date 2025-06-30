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

-- Agregar más registros con variaciones de modelos usando las mismas imágenes
INSERT INTO articulos (nombre, marca, descripcion, precio, stock, imagen_url)
VALUES 
-- Variaciones de Asus VivoBook (misma imagen)
('Asus VivoBook 15 Pro', 'Asus', 'Pantalla de 15.6", Ryzen 9, 16GB RAM, 1TB SSD, Windows 11 Pro.', 3999.50, 5, 'https://m.media-amazon.com/images/I/71SCvh0L3OL._AC_SL1500_.jpg'),
('Asus VivoBook 15 Lite', 'Asus', 'Pantalla de 15.6", Ryzen 5, 8GB RAM, 256GB SSD, Windows 11 Home.', 2199.50, 12, 'https://m.media-amazon.com/images/I/71SCvh0L3OL._AC_SL1500_.jpg'),
('Asus VivoBook 15 Gaming', 'Asus', 'Pantalla de 15.6", Ryzen 7, GTX 1650, 16GB RAM, 512GB SSD.', 3499.50, 6, 'https://m.media-amazon.com/images/I/71SCvh0L3OL._AC_SL1500_.jpg'),

-- Variaciones de Acer Aspire (misma imagen)
('Acer Aspire 5 Pro', 'Acer', 'Laptop premium con Intel Core i7, 16GB RAM y 1TB SSD.', 3599.99, 4, 'https://m.media-amazon.com/images/I/71SCvh0L3OL._AC_SL1500_.jpg'),
('Acer Aspire 5 Gaming', 'Acer', 'Laptop gamer con Intel Core i5, GTX 1650, 16GB RAM y 512GB SSD.', 3299.99, 7, 'https://m.media-amazon.com/images/I/71SCvh0L3OL._AC_SL1500_.jpg'),
('Acer Aspire 5 Lite', 'Acer', 'Laptop económica con Intel Core i3, 4GB RAM y 256GB SSD.', 1799.99, 15, 'https://m.media-amazon.com/images/I/71SCvh0L3OL._AC_SL1500_.jpg'),

-- Variaciones de Apple MacBook (misma imagen)
('Apple MacBook Air M2 Pro', 'Apple', 'Ultraligera, chip M2 Pro, 16GB RAM, 512GB SSD, pantalla Retina.', 7299.00, 3, 'https://www.hoxtonmacs.co.uk/cdn/shop/files/apple-macbook-air-13-inch-macbook-air-13-inch-m2-space-grey-2022-fair-41944507318588.jpg?v=1688461351'),
('Apple MacBook Air M2 Max', 'Apple', 'Ultraligera, chip M2 Max, 32GB RAM, 1TB SSD, pantalla Retina.', 9299.00, 2, 'https://www.hoxtonmacs.co.uk/cdn/shop/files/apple-macbook-air-13-inch-macbook-air-13-inch-m2-space-grey-2022-fair-41944507318588.jpg?v=1688461351'),
('Apple MacBook Air M2 Education', 'Apple', 'Ultraligera, chip M2, 8GB RAM, 256GB SSD, pantalla Retina (Edición Educativa).', 4799.00, 8, 'https://www.hoxtonmacs.co.uk/cdn/shop/files/apple-macbook-air-13-inch-macbook-air-13-inch-m2-space-grey-2022-fair-41944507318588.jpg?v=1688461351'),

-- Variaciones de Dell XPS (misma imagen)
('Dell XPS 13 Plus', 'Dell', 'Diseño premium, Intel Core i9, 32GB RAM, 1TB SSD, pantalla 4K.', 6899.90, 2, 'https://www.ubuy.pe/productimg/?image=aHR0cHM6Ly9tLm1lZGlhLWFtYXpvbi5jb20vaW1hZ2VzL0kvNzEwRUdKQmRJTUwuX0FDX1NMMTUwMF8uanBn.jpg'),
('Dell XPS 13 Developer', 'Dell', 'Diseño premium, Intel Core i7, 16GB RAM, 512GB SSD, Ubuntu preinstalado.', 5299.90, 4, 'https://www.ubuy.pe/productimg/?image=aHR0cHM6Ly9tLm1lZGlhLWFtYXpvbi5jb20vaW1hZ2VzL0kvNzEwRUdKQmRJTUwuX0FDX1NMMTUwMF8uanBn.jpg'),
('Dell XPS 13 Business', 'Dell', 'Diseño premium, Intel Core i5, 8GB RAM, 256GB SSD, Windows 11 Pro.', 4299.90, 6, 'https://www.ubuy.pe/productimg/?image=aHR0cHM6Ly9tLm1lZGlhLWFtYXpvbi5jb20vaW1hZ2VzL0kvNzEwRUdKQmRJTUwuX0FDX1NMMTUwMF8uanBn.jpg'),

-- Variaciones de MSI GF63 (misma imagen)
('MSI GF63 Thin Pro', 'MSI', 'Laptop gamer, Intel Core i7, RTX 3060, 16GB RAM, 1TB SSD.', 4799.99, 4, 'https://rymportatiles.com.pe/cdn/shop/files/MSI-Thin-GF63-12VE-2.png?v=1741365576&width=1214'),
('MSI GF63 Thin Max', 'MSI', 'Laptop gamer, Intel Core i9, RTX 4070, 32GB RAM, 2TB SSD.', 6799.99, 2, 'https://rymportatiles.com.pe/cdn/shop/files/MSI-Thin-GF63-12VE-2.png?v=1741365576&width=1214'),
('MSI GF63 Thin Lite', 'MSI', 'Laptop gamer, Intel Core i3, GTX 1050, 8GB RAM, 256GB SSD.', 2799.99, 10, 'https://rymportatiles.com.pe/cdn/shop/files/MSI-Thin-GF63-12VE-2.png?v=1741365576&width=1214'),

-- Variaciones de Huawei MateBook (misma imagen)
('Huawei MateBook D14 Pro', 'Huawei', 'Intel Core i7, 16GB RAM, 1TB SSD, diseño metálico premium.', 3399.00, 5, 'https://home.ripley.com.pe/Attachment/WOP_5/2004286003883/2004286003883-2.jpg'),
('Huawei MateBook D14 Lite', 'Huawei', 'Intel Core i3, 4GB RAM, 256GB SSD, diseño metálico básico.', 1899.00, 12, 'https://home.ripley.com.pe/Attachment/WOP_5/2004286003883/2004286003883-2.jpg'),
('Huawei MateBook D14 Business', 'Huawei', 'Intel Core i5, 8GB RAM, 512GB SSD, diseño metálico empresarial.', 2699.00, 7, 'https://home.ripley.com.pe/Attachment/WOP_5/2004286003883/2004286003883-2.jpg'),

-- Variaciones de Samsung Galaxy Book (misma imagen)
('Samsung Galaxy Book2 Pro', 'Samsung', 'Diseño delgado premium, Intel Core i7, 16GB RAM, 1TB SSD.', 3590.00, 4, 'https://oechsle.vteximg.com.br/arquivos/ids/15314142-1000-1000/image-7dc34b55c62a40e98a2ddb3a8937d085.jpg?v=638281859939000000'),
('Samsung Galaxy Book2 Lite', 'Samsung', 'Diseño delgado básico, Intel Core i3, 4GB RAM, 128GB SSD.', 1890.00, 15, 'https://oechsle.vteximg.com.br/arquivos/ids/15314142-1000-1000/image-7dc34b55c62a40e98a2ddb3a8937d085.jpg?v=638281859939000000'),
('Samsung Galaxy Book2 Business', 'Samsung', 'Diseño delgado empresarial, Intel Core i5, 8GB RAM, 512GB SSD.', 2890.00, 8, 'https://oechsle.vteximg.com.br/arquivos/ids/15314142-1000-1000/image-7dc34b55c62a40e98a2ddb3a8937d085.jpg?v=638281859939000000'),

-- Variaciones de LG Gram (misma imagen)
('LG Gram 16 Pro', 'LG', 'Laptop ultraligera de 16", Intel Evo i9, 32GB RAM, 2TB SSD.', 7399.99, 1, 'https://m.media-amazon.com/images/I/81RJE4fQSdL._AC_SL1500_.jpg'),
('LG Gram 16 Lite', 'LG', 'Laptop ultraligera de 16", Intel Evo i5, 8GB RAM, 512GB SSD.', 5399.99, 4, 'https://m.media-amazon.com/images/I/81RJE4fQSdL._AC_SL1500_.jpg'),
('LG Gram 16 Business', 'LG', 'Laptop ultraligera de 16", Intel Evo i7, 16GB RAM, 1TB SSD, Windows 11 Pro.', 6399.99, 3, 'https://m.media-amazon.com/images/I/81RJE4fQSdL._AC_SL1500_.jpg'),

-- Variaciones de HP Omen (misma imagen)
('HP Omen 16 Pro', 'HP', 'Laptop gamer con Intel i9, RTX 4080, 32GB RAM, 2TB SSD.', 8699.00, 2, 'https://oechsle.vteximg.com.br/arquivos/ids/18751959-1000-1000/image-35124f9918a54cb5afa5c4fdc8eaabf6.jpg?v=638629868710130000'),
('HP Omen 16 Lite', 'HP', 'Laptop gamer con Intel i5, RTX 3050, 8GB RAM, 512GB SSD.', 4699.00, 8, 'https://oechsle.vteximg.com.br/arquivos/ids/18751959-1000-1000/image-35124f9918a54cb5afa5c4fdc8eaabf6.jpg?v=638629868710130000'),
('HP Omen 16 Studio', 'HP', 'Laptop gamer con Intel i7, RTX 3070, 16GB RAM, 1TB SSD, pantalla 4K.', 7699.00, 3, 'https://oechsle.vteximg.com.br/arquivos/ids/18751959-1000-1000/image-35124f9918a54cb5afa5c4fdc8eaabf6.jpg?v=638629868710130000'),

-- Variaciones de Asus ROG (misma imagen)
('Asus ROG Zephyrus G14 Pro', 'Asus', 'Laptop gamer con Ryzen 9, RTX 4080, 32GB RAM, 2TB SSD.', 9499.99, 2, 'https://dlcdnwebimgs.asus.com/gain/08000E15-8711-44FD-9B43-067CAC3F3A78'),
('Asus ROG Zephyrus G14 Lite', 'Asus', 'Laptop gamer con Ryzen 7, RTX 3060, 16GB RAM, 512GB SSD.', 6499.99, 6, 'https://dlcdnwebimgs.asus.com/gain/08000E15-8711-44FD-9B43-067CAC3F3A78'),
('Asus ROG Zephyrus G14 Studio', 'Asus', 'Laptop gamer con Ryzen 9, RTX 4070, 16GB RAM, 1TB SSD, pantalla QHD.', 8499.99, 3, 'https://dlcdnwebimgs.asus.com/gain/08000E15-8711-44FD-9B43-067CAC3F3A78'),

-- Variaciones de Lenovo Legion (misma imagen)
('Lenovo Legion 5 Pro', 'Lenovo', 'Ryzen 9, RTX 4080, 32GB RAM, 1TB SSD, 240Hz display.', 8390.50, 2, 'https://p3-ofp.static.pub//fes/cms/2024/09/12/m1jnssoporjtlmma8zqy3ssoour2yj992790.png'),
('Lenovo Legion 5 Lite', 'Lenovo', 'Ryzen 5, RTX 3050, 8GB RAM, 256GB SSD, 144Hz display.', 4390.50, 8, 'https://p3-ofp.static.pub//fes/cms/2024/09/12/m1jnssoporjtlmma8zqy3ssoour2yj992790.png'),
('Lenovo Legion 5 Studio', 'Lenovo', 'Ryzen 7, RTX 3070, 16GB RAM, 1TB SSD, 165Hz display QHD.', 7390.50, 4, 'https://p3-ofp.static.pub//fes/cms/2024/09/12/m1jnssoporjtlmma8zqy3ssoour2yj992790.png'),

-- Variaciones de Apple MacBook Pro (misma imagen)
('Apple MacBook Pro M3 Pro', 'Apple', 'Laptop con chip M3 Pro, 32GB RAM, 1TB SSD, pantalla Liquid Retina XDR.', 11999.00, 1, 'https://www.peru-smart.com/wp-content/uploads/2024/09/LAMA1000GRIS-512GBSSD_0.jpg'),
('Apple MacBook Pro M3 Max', 'Apple', 'Laptop con chip M3 Max, 64GB RAM, 2TB SSD, pantalla Liquid Retina XDR.', 15999.00, 1, 'https://www.peru-smart.com/wp-content/uploads/2024/09/LAMA1000GRIS-512GBSSD_0.jpg'),
('Apple MacBook Pro M3 Education', 'Apple', 'Laptop con chip M3, 16GB RAM, 512GB SSD, pantalla Liquid Retina (Edición Educativa).', 7999.00, 5, 'https://www.peru-smart.com/wp-content/uploads/2024/09/LAMA1000GRIS-512GBSSD_0.jpg'),

-- Variaciones de Dell Inspiron (misma imagen)
('Dell Inspiron 15 Pro', 'Dell', 'Laptop para trabajo profesional, Intel i7, 16GB RAM, 1TB SSD.', 3299.90, 4, 'https://laptopshop.pe/wp-content/uploads/2024/02/Dell-inspiron-15-3520-4.jpg'),
('Dell Inspiron 15 Lite', 'Dell', 'Laptop para trabajo básico, Intel i3, 4GB RAM, 256GB SSD.', 1599.90, 12, 'https://laptopshop.pe/wp-content/uploads/2024/02/Dell-inspiron-15-3520-4.jpg'),
('Dell Inspiron 15 Business', 'Dell', 'Laptop para trabajo empresarial, Intel i5, 8GB RAM, 512GB SSD, Windows 11 Pro.', 2599.90, 8, 'https://laptopshop.pe/wp-content/uploads/2024/02/Dell-inspiron-15-3520-4.jpg'),

-- Variaciones de Acer Nitro (misma imagen)
('Acer Nitro 5 Pro', 'Acer', 'Laptop gamer con Ryzen 7, RTX 3060, 16GB RAM, 1TB SSD.', 4999.00, 3, 'https://m.media-amazon.com/images/I/71s1LRpaprL._AC_SL1500_.jpg'),
('Acer Nitro 5 Lite', 'Acer', 'Laptop gamer con Ryzen 3, GTX 1050, 8GB RAM, 256GB SSD.', 2999.00, 10, 'https://m.media-amazon.com/images/I/71s1LRpaprL._AC_SL1500_.jpg'),
('Acer Nitro 5 Studio', 'Acer', 'Laptop gamer con Ryzen 9, RTX 4070, 32GB RAM, 2TB SSD.', 6999.00, 2, 'https://m.media-amazon.com/images/I/71s1LRpaprL._AC_SL1500_.jpg'),

-- Variaciones de Microsoft Surface (misma imagen)
('Microsoft Surface Laptop 5 Pro', 'Microsoft', 'Pantalla táctil de 13.5", Intel i7, 16GB RAM, 512GB SSD.', 5799.00, 2, 'https://oechsle.vteximg.com.br/arquivos/ids/15313790-1000-1000/image-0ec066b644db477abfa421d9a99009f7.jpg?v=638281851981370000'),
('Microsoft Surface Laptop 5 Lite', 'Microsoft', 'Pantalla táctil de 13.5", Intel i3, 4GB RAM, 128GB SSD.', 3799.00, 8, 'https://oechsle.vteximg.com.br/arquivos/ids/15313790-1000-1000/image-0ec066b644db477abfa421d9a99009f7.jpg?v=638281851981370000'),
('Microsoft Surface Laptop 5 Business', 'Microsoft', 'Pantalla táctil de 13.5", Intel i5, 8GB RAM, 256GB SSD, Windows 11 Pro.', 4799.00, 5, 'https://oechsle.vteximg.com.br/arquivos/ids/15313790-1000-1000/image-0ec066b644db477abfa421d9a99009f7.jpg?v=638281851981370000'),

-- Variaciones de Samsung Galaxy Book3 (misma imagen)
('Samsung Galaxy Book3 Pro Max', 'Samsung', 'Pantalla AMOLED 3K, Intel i9, 32GB RAM, 2TB SSD.', 8490.00, 1, 'https://oechsle.vteximg.com.br/arquivos/ids/15312394-1000-1000/image-b53f23081da742399c4840662e692618.jpg?v=638281818215870000'),
('Samsung Galaxy Book3 Pro Lite', 'Samsung', 'Pantalla AMOLED 3K, Intel i5, 8GB RAM, 256GB SSD.', 4490.00, 8, 'https://oechsle.vteximg.com.br/arquivos/ids/15312394-1000-1000/image-b53f23081da742399c4840662e692618.jpg?v=638281818215870000'),
('Samsung Galaxy Book3 Pro Business', 'Samsung', 'Pantalla AMOLED 3K, Intel i7, 16GB RAM, 1TB SSD, Windows 11 Pro.', 7490.00, 3, 'https://oechsle.vteximg.com.br/arquivos/ids/15312394-1000-1000/image-b53f23081da742399c4840662e692618.jpg?v=638281818215870000'),

-- Variaciones de MSI Katana (misma imagen)
('MSI Katana GF66 Pro', 'MSI', 'Laptop gamer con Intel i9, RTX 4070, 32GB RAM, 2TB SSD.', 6599.99, 2, 'https://asset.msi.com/resize/image/global/product/product_1619086146fdfbc8b34331ebecbf18cb444480b7d1.png62405b38c58fe0f07fcef2367d8a9ba1/600.png'),
('MSI Katana GF66 Lite', 'MSI', 'Laptop gamer con Intel i5, RTX 3050, 8GB RAM, 256GB SSD.', 3599.99, 10, 'https://asset.msi.com/resize/image/global/product/product_1619086146fdfbc8b34331ebecbf18cb444480b7d1.png62405b38c58fe0f07fcef2367d8a9ba1/600.png'),
('MSI Katana GF66 Studio', 'MSI', 'Laptop gamer con Intel i7, RTX 3060, 16GB RAM, 1TB SSD, pantalla QHD.', 5599.99, 4, 'https://asset.msi.com/resize/image/global/product/product_1619086146fdfbc8b34331ebecbf18cb444480b7d1.png62405b38c58fe0f07fcef2367d8a9ba1/600.png'),

-- Variaciones de Gigabyte Aorus (misma imagen)
('Gigabyte Aorus 15P Pro', 'Gigabyte', 'Laptop gamer de alto rendimiento con i9, RTX 4080, 64GB RAM.', 9499.00, 1, 'https://www.kabifperu.com/imagenes/prod-24022021204746-laptop-gigabyte-aorus-15p-xc-i7-10870h-xc-8la2430sh-gaming-15-6-i7-512-ssd-32gb-rtx3070-8g-w10-deta.png'),
('Gigabyte Aorus 15P Lite', 'Gigabyte', 'Laptop gamer de rendimiento medio con i5, RTX 3050, 16GB RAM.', 5499.00, 6, 'https://www.kabifperu.com/imagenes/prod-24022021204746-laptop-gigabyte-aorus-15p-xc-i7-10870h-xc-8la2430sh-gaming-15-6-i7-512-ssd-32gb-rtx3070-8g-w10-deta.png'),
('Gigabyte Aorus 15P Studio', 'Gigabyte', 'Laptop gamer de alto rendimiento con i7, RTX 3070, 32GB RAM, pantalla QHD.', 8499.00, 3, 'https://www.kabifperu.com/imagenes/prod-24022021204746-laptop-gigabyte-aorus-15p-xc-i7-10870h-xc-8la2430sh-gaming-15-6-i7-512-ssd-32gb-rtx3070-8g-w10-deta.png');

-- Crear extensión para búsqueda por similitud
CREATE EXTENSION IF NOT EXISTS pg_trgm; 