# Proyecto Laravel Web 2

Aplicación web de **comercio electrónico** desarrollada con **Laravel 12**. Incluye una tienda para clientes (catálogo, carrito, checkout, pago y factura) y un **panel de administración** completo para gestionar usuarios, productos y reportes de ventas. La autenticación se basa en Laravel Breeze y el acceso al área de administración está protegido por roles.

> El proyecto Laravel se encuentra dentro de la carpeta `proyectolaravel/`.

## Características

### Tienda (cliente)
- **Catálogo de productos** con nombre, descripción, precio, categoría, stock e imagen.
- **Carrito de compras**: agregar, actualizar cantidades, eliminar y vaciar.
- **Checkout** que genera el pedido a partir del carrito.
- **Proceso de pago** y **generación de factura** de la compra.
- **Autenticación de usuarios** (registro, login, verificación de email, recuperación de contraseña) mediante Laravel Breeze.
- **Perfil de usuario** editable, con cambio de contraseña y eliminación de cuenta.

### Panel de administración (`/admin`)
- **Dashboard** con accesos a las distintas secciones.
- **Gestión de usuarios**: listar, crear, ver, promover/quitar rol de administrador y eliminar (con protección para no borrar administradores).
- **Gestión de productos (CRUD)**: crear, editar, eliminar y subir imágenes (almacenadas en disco público).
- **Reportes de ventas**: estadísticas generales (totales de usuarios, productos, pedidos y ventas), ventas por mes, productos más vendidos, usuarios con más compras y categorías más vendidas.
- **Exportación de reportes a PDF** por rango de fechas (DomPDF).
- **Middleware `admin`** que restringe el acceso a usuarios con `is_admin = true`.

## Tecnologías

- **Framework:** Laravel 12 (PHP 8.2+)
- **Autenticación:** Laravel Breeze
- **Plantillas:** Blade
- **Frontend:** Tailwind CSS, Alpine.js y Vite
- **PDF:** barryvdh/laravel-dompdf
- **Base de datos:** MySQL (u otra compatible con Eloquent)

## Modelo de datos

Principales tablas y modelos:

- **`users`** — usuarios, con campo `is_admin` para distinguir administradores.
- **`productos`** — nombre, descripción, precio, `imagen_url`, stock y categoría.
- **`carritos`** y **`detalles_carrito`** — carrito de compra del usuario y sus líneas.
- **`pedidos`** y **`detalles_pedido`** — pedidos con `total`, `estado` (pendiente, procesando, enviado, entregado, cancelado, pagado) y `fecha_pedido`, junto a sus líneas de detalle.
- **`pagos`** — registros de pago asociados a los pedidos.

## Instalación y ejecución

1. Clonar el repositorio y entrar a la carpeta del proyecto Laravel:
   ```bash
   git clone https://github.com/ivanniaPorras/proyecto_laravel_web2.git
   cd proyecto_laravel_web2/proyectolaravel
   ```
2. Instalar las dependencias de PHP y de Node:
   ```bash
   composer install
   npm install
   ```
   > Si DomPDF no está instalado, agrégalo con:
   > ```bash
   > composer require barryvdh/laravel-dompdf
   > ```
3. Crear el archivo de entorno y generar la clave de la aplicación:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Configurar la conexión a la base de datos en `.env` y ejecutar migraciones y seeders:
   ```bash
   php artisan migrate --seed
   ```
5. Crear el enlace simbólico para las imágenes públicas:
   ```bash
   php artisan storage:link
   ```
6. Compilar los assets y levantar el servidor:
   ```bash
   npm run dev
   php artisan serve
   ```

### Usuario administrador por defecto
El seeder crea una cuenta de administrador lista para usar:

- **Email:** `admin@admin.com`
- **Contraseña:** `password`

(También crea un usuario de prueba: `user@test.com` / `password`.) Se recomienda cambiar estas credenciales en un entorno real.

Para convertir a cualquier usuario en administrador desde la consola también existe el comando:
```bash
php artisan make:user-admin
```

## Autoría

Proyecto desarrollado por [ivanniaPorras](https://github.com/ivanniaPorras) como proyecto del curso de Desarrollo Web 2.
