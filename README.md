Sistema de Gestión de Productos Cárnicos (SGPC)
Descripción
El Sistema de Gestión de Productos Cárnicos (SGPC) es una aplicación web diseñada para ayudar a las empresas en la industria cárnica a gestionar eficientemente sus productos, ventas, inventario y reportes. Desarrollado con PHP, MySQL, HTML5, CSS3 y JavaScript.
Características

Gestión de inventario de productos cárnicos
Procesamiento de ventas y órdenes
Generación de reportes
Gestión de usuarios y roles
Interfaz responsiva para acceso desde diferentes dispositivos

Requisitos del Sistema

PHP 7.4 o superior
MySQL 5.7 o superior
Servidor web (Apache/Nginx)
Navegador web moderno
Composer (Gestor de dependencias para PHP)
Laragon o XAMPP (Entorno de desarrollo local)

Instalación
1. Preparación del Entorno

Instala Laragon o XAMPP en tu sistema.
Instala Composer.
Para una guía de instalación detallada, puedes ver este video tutorial.
https://www.youtube.com/watch?v=NOSb3gQHtmY
 solo la parte de instalacion de laragon y composer lo demas ya no, ya que no Usamos laravel.

2. Clonar el Repositorio
   https://github.com/GA17033-Dev/Gesti-n-de-Productos-C-rnicos.git
      cd Gesti-n-de-Productos-C-rnicos
3. Instalar Dependencias
   composer update
4. Configurar Variables de Entorno
   cp .env.example .env
   DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=sistema_ventas_laravel
DB_USERNAME=root
DB_PASSWORD=

APP_ENV=development
APP_DEBUG=true
5. Configurar la Base de Datos
El proyecto incluye un script SQL para crear y configurar la base de datos. Sigue estos pasos:
a. Localiza el archivo script.sql en la raíz del proyecto.
b. Ejecuta el script de una de estas dos maneras:

Usando phpMyAdmin (incluido en Laragon o XAMPP):

Abre phpMyAdmin desde tu panel de control de Laragon o XAMPP.
Crea una nueva base de datos llamada sistema_ventas_laravel.
Selecciona la base de datos recién creada.
Ve a la pestaña "Importar".
Selecciona el archivo script.sql y haz clic en "Go" o "Importar".


Usando la línea de comandos:

Abre una terminal o línea de comandos.
Navega hasta el directorio del proyecto.
Ejecuta el siguiente comando:
mysql -u root -p sistema_ventas_laravel < script.sql

Ingresa la contraseña de MySQL cuando se te solicite.



c. Verifica que la base de datos se haya creado correctamente con todas las tablas necesarias.
6. Iniciar el Servidor Local
Ejecuta el siguiente comando en la raíz del proyecto:
php -S localhost:8001 -t public

Uso
Accede al sistema a través de tu navegador web usando la URL http://localhost:8001.
Soporte
   
   
   
