# PHP Market - Sistema de E-commerce

Un sistema completo de comercio electrónico desarrollado en PHP con arquitectura de capas para la gestión de una tienda de laptops.

## 🚀 Características Principales

### 👥 Gestión de Usuarios

- **Registro de usuarios**: Sistema de registro con validación de datos
- **Inicio de sesión**: Autenticación segura de usuarios
- **Tipos de usuario**: Clientes y Administradores con diferentes permisos
- **Gestión de perfiles**: Modificación de información personal

### 🛍️ Catálogo de Productos

- **Catálogo de laptops**: Visualización de productos con imágenes, descripciones y precios
- **Búsqueda avanzada**: Sistema de búsqueda con filtros por nombre, marca y características
- **Gestión de inventario**: Control de stock en tiempo real
- **Imágenes de productos**: Soporte para múltiples imágenes por producto

### 🛒 Sistema de Pedidos

- **Carrito de compras**: Agregar y gestionar productos en el carrito
- **Proceso de compra**: Flujo completo desde selección hasta confirmación
- **Historial de pedidos**: Visualización de pedidos anteriores
- **Detalles de pedidos**: Información detallada de cada compra

### 👨‍💼 Panel de Administración

- **Gestión de productos**: Agregar, editar y eliminar productos
- **Control de inventario**: Actualización de stock y precios
- **Gestión de usuarios**: Administración de cuentas de clientes
- **Reportes de ventas**: Seguimiento de pedidos y estadísticas

## 🏗️ Arquitectura del Proyecto

### Estructura de Carpetas

```
php-market/
├── entidades/          # Modelos de datos (Articulo, Pedido, User, DetallePedido)
├── interfaces/         # Contratos para la lógica de negocio
├── logica/            # Lógica de negocio y operaciones
├── datos/             # Capa de acceso a datos (DB.php)
├── presentacion/      # Interfaces de usuario y formularios
├── assets/            # Recursos estáticos (CSS, JS, imágenes)
└── script.sql         # Esquema de base de datos
```

### Tecnologías Utilizadas

- **Backend**: PHP 7.4+
- **Base de datos**: PostgreSQL
- **Frontend**: HTML5, CSS3, Bootstrap 5
- **Arquitectura**: Patrón MVC con separación de capas

## 📊 Base de Datos

El sistema incluye las siguientes tablas principales:

- **usuarios**: Gestión de clientes y administradores
- **articulos**: Catálogo de productos (laptops)
- **pedidos**: Encabezados de órdenes de compra
- **pedido_detalles**: Detalles de productos en cada pedido

## 📝 Credenciales de Prueba

- **Cliente**: juan@example.com / 1234
- **Administrador**: admin@example.com / admin123

## 🔧 Requisitos del Sistema

- PHP 7.4 o superior
- PostgreSQL 12 o superior
- Servidor web (Apache/Nginx)
- Extensiones PHP: pdo, pdo_pgsql

## 📚 Referencias

Este proyecto está basado en:

- [gsus2024/ncapasphp](https://github.com/gsus2024/ncapasphp/tree/master) - Arquitectura de capas en PHP
- [HectorPulido/Simple-php-blog](https://github.com/HectorPulido/Simple-php-blog) - Patrones de desarrollo PHP
