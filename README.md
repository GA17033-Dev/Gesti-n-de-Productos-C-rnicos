
# Sistema de Gestión de Productos Cárnicos (SGPC)

## Descripción
El **Sistema de Gestión de Productos Cárnicos (SGPC)** es una aplicación web diseñada para ayudar a las empresas de la industria cárnica a gestionar eficientemente sus productos, ventas, inventario y reportes. Este sistema está desarrollado utilizando las siguientes tecnologías:

- PHP
- MySQL
- HTML5
- CSS3
- JavaScript

## Características
- **Gestión de inventario de productos cárnicos**
- **Procesamiento de ventas y órdenes**
- **Generación de reportes**
- **Gestión de usuarios y roles**
- **Interfaz responsiva** para acceso desde diferentes dispositivos

## Requisitos del Sistema
- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (Apache o Nginx)
- Navegador web moderno
- Composer (Gestor de dependencias para PHP)
- Laragon o XAMPP (Entorno de desarrollo local)

## Instalación

### 1. Preparación del Entorno
1. Instala Laragon o XAMPP en tu sistema.
2. Instala Composer.
   
   Puedes seguir este [video tutorial](https://www.youtube.com/watch?v=NOSb3gQHtmY) solo para la instalación de **Laragon** y **Composer** (Ignora las secciones de Laravel, ya que no usamos Laravel).

### 2. Clonar el Repositorio
Clona el repositorio del proyecto con el siguiente comando:

```bash
git clone https://github.com/GA17033-Dev/Gesti-n-de-Productos-C-rnicos.git
cd Gesti-n-de-Productos-C-rnicos
```

### 3. Instalar Dependencias
Ejecuta el siguiente comando para instalar las dependencias:

```bash
composer update
```

### 4. Configurar Variables de Entorno
Copia el archivo de ejemplo `.env.example` y renómbralo a `.env`:

```bash
cp .env.example .env
```

Luego, configura las variables de entorno del archivo `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=sistema_ventas
DB_USERNAME=root
DB_PASSWORD=

APP_ENV=development
APP_DEBUG=true
```

### 5. Configurar la Base de Datos
El proyecto incluye un script SQL para crear y configurar la base de datos. Sigue estos pasos:

#### Opción A: Usando phpMyAdmin (incluido en Laragon o XAMPP)
1. Abre phpMyAdmin desde el panel de control de Laragon o XAMPP.
2. Crea una nueva base de datos llamada `sistema_ventas`.
3. Selecciona la base de datos recién creada.
4. Ve a la pestaña **Importar**.
5. Selecciona el archivo `script.sql` ubicado en la raíz del proyecto.
6. Haz clic en **Go** o **Importar**.

#### Opción B: Usando la línea de comandos
1. Abre una terminal o línea de comandos.
2. Navega hasta el directorio del proyecto.
3. Ejecuta el siguiente comando:

   ```bash
   mysql -u root -p sistema_ventas_laravel < script.sql
   ```

4. Ingresa la contraseña de MySQL cuando se te solicite.
   
Verifica que la base de datos se haya creado correctamente con todas las tablas necesarias.

### 6. Iniciar el Servidor Local
Ejecuta el siguiente comando en la raíz del proyecto:

```bash
php -S localhost:8001 -t public
```

## Uso
Accede al sistema a través de tu navegador web en la siguiente URL:

```
http://localhost:8001
