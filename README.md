# Sistema de Gestión de Seguros - Rentería Seguros

Sistema web desarrollado con Laravel 12 y Livewire 3 para la gestión integral de pólizas de seguros, asegurados, compañías y unidades vehiculares.

## Características

- 📋 Gestión de Pólizas de Seguros
- 👥 Administración de Asegurados (Clientes)
- 🏢 Registro de Compañías Aseguradoras
- 🚗 Control de Unidades Vehiculares
- 📊 Dashboard con métricas y estadísticas
- 📈 Reportes de ventas y renovaciones
- 📥 Importación masiva desde Excel
- 🔐 Autenticación con Laravel Jetstream
- 🎨 Interfaz moderna con Tailwind CSS y Flowbite

## Requisitos del Sistema

- PHP >= 8.2
- Composer
- Node.js >= 18.x
- NPM o Yarn
- MySQL >= 8.0
- Servidor web (Apache/Nginx)
- Extensiones PHP requeridas:
  - BCMath
  - Ctype
  - Fileinfo
  - JSON
  - Mbstring
  - OpenSSL
  - PDO
  - Tokenizer
  - XML
  - GD (para procesamiento de imágenes)
  - ZIP (para importación de Excel)

## Instalación Rápida

### 1. Clonar el Repositorio

```bash
git clone https://gitlab.com/TU_USUARIO/TU_PROYECTO.git
cd TU_PROYECTO
```

### 2. Instalar Dependencias de PHP

```bash
composer install
```

### 3. Instalar Dependencias de Node.js

```bash
npm install
```

### 4. Configurar Variables de Entorno

Copia el archivo de ejemplo de variables de entorno:

```bash
cp .env.example .env
```

Edita el archivo `.env` y configura tu base de datos:

```env
APP_NAME="Sistema de Seguros"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=seguros_db
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generar Clave de Aplicación

```bash
php artisan key:generate
```

### 6. Crear Base de Datos

Crea una base de datos MySQL llamada `seguros_db` (o el nombre que configuraste en `.env`):

```sql
CREATE DATABASE seguros_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 7. Ejecutar Migraciones y Seeders

```bash
 # Borrar todo
php artisan migrate:fresh

# Recrear solo usuarios
php artisan db:seed --class=UsersSeeder
```

Este comando creará todas las tablas necesarias y poblará la base de datos con datos de prueba, incluyendo:

- 2 usuarios de ejemplo
- 7 compañías aseguradoras
- 5 asegurados
- 5 unidades vehiculares
- 20 pólizas de ejemplo

### 8. Crear Link Simbólico de Storage

Este paso es **obligatorio** para que funcionen los archivos PDF de pólizas y endosos:

```bash
php artisan storage:link
```

> **Importante:** Este comando debe ejecutarse cada vez que se clone o copie el proyecto a una nueva ubicación.

### 9. Compilar Assets

Para desarrollo:

```bash
npm run dev
```

Para producción:

```bash
npm run build
```

### 10. Iniciar el Servidor

```bash
php artisan serve
```

La aplicación estará disponible en: `http://localhost:8000`

## Credenciales de Acceso

### Usuario Administrador

- **Email:** admin@seguros.com
- **Contraseña:** password

### Usuario Agente

- **Email:** agente@seguros.com
- **Contraseña:** password

## Estructura del Proyecto

```
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
└── routes/
    └── web.php           # Rutas de la aplicación
```

## Comandos Útiles

### Limpiar Cache

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Refrescar Base de Datos

```bash
php artisan migrate:fresh --seed
```

### Compilar Assets en Modo Watch

```bash
npm run dev
```

### Corregir Pólizas Importadas

Si importaste pólizas desde CSV y hay problemas con la forma de pago o las fechas, ejecuta:

```bash
php artisan polizas:corregir-importadas
```

Este comando corrige automáticamente:
- **FormaPago**: Normaliza valores en mayúsculas (`ANUAL` → `Anual`, `TRIMESTRAL` → `Trimestral`, etc.)
- **FechaInicio**: Si es igual o muy cercana a FechaVencimiento, la recalcula a 1 año antes del vencimiento

### Corregir RFC a Mayúsculas

Para convertir todos los RFC de asegurados a mayúsculas:

```bash
php artisan asegurados:rfc-mayusculas
```

### Convertir Datos a Mayúsculas

Para convertir nombres de asegurados y números de póliza a mayúsculas:

```bash
php artisan datos:mayusculas
```

> **Nota:** A partir de ahora, todos los RFC, nombres de asegurados y números de póliza se guardarán automáticamente en mayúsculas.

## Módulos del Sistema

### 📋 Pólizas

- Crear, editar y visualizar pólizas
- Renovación automática de pólizas
- Cancelación de pólizas
- Filtrado por estatus y compañía
- Alertas de vencimiento

### 👥 Asegurados

- Registro completo de clientes
- Datos personales y fiscales
- Historial de pólizas por asegurado
- Búsqueda y filtrado avanzado

### 🏢 Compañías

- Catálogo de aseguradoras
- Tipos de cobertura
- Estadísticas por compañía

### 🚗 Unidades

- Registro de vehículos
- Información técnica completa
- Vinculación con pólizas

### 📊 Reportes

- Reporte de ventas
- Próximas renovaciones
- Análisis de comisiones

### 📥 Importación

- Importación masiva desde Excel
- Plantillas descargables
- Validación de datos

## Tecnologías Utilizadas

- **Backend:** Laravel 12
- **Frontend:** Livewire 3
- **Estilos:** Tailwind CSS 3.x
- **Componentes UI:** Flowbite
- **Base de Datos:** MySQL 8
- **Autenticación:** Laravel Jetstream
- **Procesamiento Excel:** Maatwebsite/Excel

## Despliegue en Producción

### 1. Configurar .env para Producción

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.com
```

### 2. Optimizar la Aplicación

```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

### 3. Configurar Permisos

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## Soporte y Contacto

**Rentería Seguros**

- 📧 Email: rrenteriam76@gmail.com
- 📱 Teléfono: (442) 183.22.50
- 🌐 WhatsApp: (442) 773.79.25

## Licencia

Este proyecto es propietario de Rentería Seguros.

---

Desarrollado con ❤️ para Rentería Seguros - Sistema de Gestión de Seguros v1.0
