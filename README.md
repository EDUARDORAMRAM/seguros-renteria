# Sistema de Gestion de Seguros - Renteria Seguros

Sistema web desarrollado con Laravel 12 y Livewire 3 para la gestion integral de polizas de seguros, asegurados, companias y unidades vehiculares.

## Caracteristicas

- Gestion de Polizas de Seguros
- Administracion de Asegurados (Clientes)
- Registro de Companias Aseguradoras
- Control de Unidades Vehiculares
- Dashboard con metricas y estadisticas
- Calendario de Cobranzas
- Reportes de ventas, renovaciones y por asegurado
- Importacion masiva desde Excel
- Autenticacion con Laravel Jetstream
- Interfaz moderna con Tailwind CSS y Flowbite

## Requisitos del Sistema

- **XAMPP** (recomendado) o servidor web con:
  - PHP >= 8.2
  - MySQL >= 8.0
  - Apache
- **Composer** - Gestor de dependencias PHP
- **Node.js** >= 18.x con NPM
- **Git** (para clonar el repositorio)

### Extensiones PHP requeridas

Estas extensiones vienen habilitadas por defecto en XAMPP:
- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- PDO_MySQL
- Tokenizer
- XML
- GD (para procesamiento de imagenes)
- ZIP (para importacion de Excel)

## Instalacion Paso a Paso

### 1. Instalar Requisitos Previos

#### XAMPP
Descarga e instala XAMPP desde: https://www.apachefriends.org/

#### Composer
Descarga e instala Composer desde: https://getcomposer.org/download/

#### Node.js
Descarga e instala Node.js LTS desde: https://nodejs.org/

#### Git
Descarga e instala Git desde: https://git-scm.com/downloads

### 2. Clonar el Repositorio

Abre una terminal (Git Bash en Windows) y navega a la carpeta htdocs de XAMPP:

```bash
cd C:/xampp/htdocs
```

Clona el repositorio:

```bash
git clone <URL_DEL_REPOSITORIO> Seguros
cd Seguros
```

### 3. Instalar Dependencias de PHP

```bash
composer install
```

> Si hay errores de memoria, ejecuta: `php -d memory_limit=-1 C:/xampp/php/composer.phar install`

### 4. Instalar Dependencias de Node.js

```bash
npm install
```

### 5. Configurar Variables de Entorno

Copia el archivo de configuracion de ejemplo:

**Windows (CMD):**
```cmd
copy .env.example .env
```

**Windows (PowerShell/Git Bash):**
```bash
cp .env.example .env
```

Abre el archivo `.env` con un editor de texto y verifica la configuracion de la base de datos:

```env
APP_NAME="Sistema de Seguros"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=seguros_db
DB_USERNAME=root
DB_PASSWORD=
```

> **Nota:** Si tu MySQL tiene contrasena, agregala en `DB_PASSWORD=`

### 6. Generar Clave de Aplicacion

```bash
php artisan key:generate
```

### 7. Crear la Base de Datos

#### Opcion A: Usando phpMyAdmin

1. Inicia XAMPP y activa Apache y MySQL
2. Abre http://localhost/phpmyadmin
3. Click en "Nueva" (New) en el panel izquierdo
4. Nombre de la base de datos: `seguros_db`
5. Cotejamiento: `utf8mb4_unicode_ci`
6. Click en "Crear"

#### Opcion B: Usando linea de comandos

```bash
mysql -u root -p -e "CREATE DATABASE seguros_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 8. Ejecutar Migraciones

Esto crea todas las tablas necesarias en la base de datos:

```bash
php artisan migrate
```

### 9. Cargar Datos Iniciales (Opcional)

Para crear usuarios de prueba:

```bash
php artisan db:seed --class=UsersSeeder
```

Esto creara:
- Usuario admin: `admin@seguros.com` / `password`
- Usuario agente: `agente@seguros.com` / `password`

### 10. Crear Link Simbolico de Storage

**IMPORTANTE:** Este paso es obligatorio para que funcionen los archivos PDF:

```bash
php artisan storage:link
```

### 11. Compilar Assets (CSS/JS)

Para desarrollo (con recarga automatica):

```bash
npm run dev
```

Para produccion (archivos optimizados):

```bash
npm run build
```

### 12. Iniciar el Servidor

Abre **dos terminales**:

**Terminal 1 - Servidor PHP:**
```bash
php artisan serve
```

**Terminal 2 - Compilador de Assets (solo si usas `npm run dev`):**
```bash
npm run dev
```

La aplicacion estara disponible en: **http://localhost:8000**

## Credenciales de Acceso

### Usuario Administrador
- **Email:** admin@seguros.com
- **Contrasena:** password

### Usuario Agente
- **Email:** agente@seguros.com
- **Contrasena:** password

## Solucion de Problemas Comunes

### Error: "SQLSTATE[HY000] [1049] Unknown database"
La base de datos no existe. Creala siguiendo el paso 7.

### Error: "Could not open input file: artisan"
No estas en la carpeta correcta del proyecto. Usa `cd C:/xampp/htdocs/Seguros`

### Error: "Class not found" o "Composer autoload"
Ejecuta:
```bash
composer dump-autoload
```

### Los estilos CSS no cargan
Ejecuta:
```bash
npm run build
```

### Error de permisos en storage
```bash
# En Windows, asegurate de que la carpeta storage tenga permisos de escritura
# Normalmente no es necesario en XAMPP local
```

### Los PDFs no se muestran
Ejecuta nuevamente:
```bash
php artisan storage:link
```

### Limpiar cache de la aplicacion
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### Error: "Class Barryvdh\DomPDF\Facade\Pdf not found"
Ejecuta estos comandos en orden:
```bash
composer clear-cache
composer install
composer dump-autoload
php artisan config:clear
```

Si persiste el error:
```bash
composer require barryvdh/laravel-dompdf
```

## Comandos Utiles

### Refrescar Base de Datos (borra todos los datos)

```bash
php artisan migrate:fresh
php artisan db:seed --class=UsersSeeder
```

### Corregir Polizas Importadas

Si importaste polizas desde CSV y hay problemas:

```bash
php artisan polizas:corregir-importadas
```

### Convertir RFC a Mayusculas

```bash
php artisan asegurados:rfc-mayusculas
```

### Convertir Datos a Mayusculas

```bash
php artisan datos:mayusculas
```

## Estructura del Proyecto

```
Seguros/
├── app/
│   ├── Livewire/          # Componentes Livewire
│   │   ├── Asegurados/
│   │   ├── Companias/
│   │   ├── Polizas/
│   │   ├── Unidades/
│   │   └── Reportes/
│   ├── Models/            # Modelos Eloquent
│   └── Http/
├── database/
│   ├── migrations/        # Migraciones de base de datos
│   └── seeders/           # Seeders con datos de prueba
├── resources/
│   ├── views/
│   │   ├── livewire/     # Vistas de componentes Livewire
│   │   └── layouts/      # Layouts principales
│   └── css/              # Estilos Tailwind
├── routes/
│   └── web.php           # Rutas de la aplicacion
├── storage/              # Archivos subidos y cache
└── public/               # Archivos publicos (CSS, JS compilados)
```

## Modulos del Sistema

### Polizas
- Crear, editar y visualizar polizas
- Renovacion automatica de polizas
- Cancelacion de polizas
- Filtrado por estatus y compania
- Alertas de vencimiento
- Prima modificable

### Asegurados
- Registro completo de clientes
- Datos personales y fiscales
- Historial de polizas por asegurado
- Busqueda y filtrado avanzado
- Reportes por asegurado

### Companias
- Catalogo de aseguradoras
- Tipos de cobertura
- Estadisticas por compania

### Unidades
- Registro de vehiculos
- Informacion tecnica completa
- Vinculacion con polizas

### Reportes
- Reporte de ventas
- Proximas renovaciones
- Reportes por asegurado
- Analisis de comisiones

### Calendario de Cobranzas
- Visualizacion de pagos pendientes
- Seguimiento de cobranza

### Importacion
- Importacion masiva desde Excel
- Plantillas descargables
- Validacion de datos

## Tecnologias Utilizadas

- **Backend:** Laravel 12
- **Frontend:** Livewire 3
- **Estilos:** Tailwind CSS 3.x
- **Componentes UI:** Flowbite
- **Base de Datos:** MySQL 8
- **Autenticacion:** Laravel Jetstream
- **Procesamiento Excel:** Maatwebsite/Excel
- **Generacion PDF:** DomPDF

## Despliegue en Produccion

### 1. Configurar .env para Produccion

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.com
```

### 2. Optimizar la Aplicacion

```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

### 3. Configurar Permisos (Linux)

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## Soporte y Contacto

**Renteria Seguros**

- Email: rrenteriam76@gmail.com
- Telefono: (442) 183.22.50
- WhatsApp: (442) 773.79.25

## Licencia

Este proyecto es propietario de Renteria Seguros.

---

Desarrollado para Renteria Seguros - Sistema de Gestion de Seguros v1.0
