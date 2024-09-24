# Sistema de Gestión de Productos Cárnicos (SGPC)

## Descripción
El Sistema de Gestión de Productos Cárnicos (SGPC) es una aplicación web diseñada para ayudar a las empresas en la industria cárnica a gestionar eficientemente sus productos, ventas, inventario y reportes. Desarrollado con PHP, MySQL, HTML5, CSS3 y JavaScript.
## Características
- Gestión de inventario de productos cárnicos
- Procesamiento de ventas y órdenes
- Generación de reportes
- Gestión de usuarios y roles
- Interfaz responsiva para acceso desde diferentes dispositivos

## Requisitos del Sistema
- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (Apache/Nginx)
- Navegador web moderno

## Instalación
1. **Clonar el Repositorio**
2. **Instalar Dependencias**

Ejecuta Composer para instalar las dependencias del proyecto: composer install
3. **Configurar Variables de Entorno**

Copia el archivo de ejemplo de variables de entorno y configúralo:
Abre el archivo `.env` y configura tus variables de entorno, especialmente las relacionadas con la base de datos:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=example
DB_USERNAME=root
DB_PASSWORD=

4. **Crear la Base de Datos**

Crea una base de datos MySQL para el proyecto. Puedes hacerlo desde la línea de comandos:
