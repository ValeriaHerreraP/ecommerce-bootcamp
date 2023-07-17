## Proyecto Bootcamp Evertec (Ecommerce):

Este proyecto hace parte de la evidencia del aprendizaje práctico obtenido en un proceso de formacion (Bootcamp), brindado por la compañía Evertec, una empresa líder de tecnología y procesamiento de transacciones. 

## Características generales del proyecto desarrollado:

Un administrador del ecommerce necesita un sistema que le permita realizar la venta de susnproductos de manera online. El sistema deberá permitir registrar cada producto así como también administrar las cuentas de sus clientes, quienes también deberán identificarse para realizar compras de los artículos de mercadería.

Para el administrador de MercaTodo es sumamente importante que el sistema le permita realizar pagos online y generar reportes que sirvan de apoyo para tomar decisiones. También es indispensable que el sistema cuente con opciones para administrar productos de manera masiva.

## Requerimientos Técnicos:

Dentro del desarrollo del proyecto se encuentran las siguientes características: 

- GIT como sistema de gestión de versiones.
- Formato de código PSR-2 y PSR12.
- Uso de COMPOSER como herramienta de gestión de dependencias.
- Separación por capas.
- Laravel como framework de desarrollo.
- Flujo de trabajo basado en GIT-FLOW.
- Tipado estricto en la declaración de funciones y métodos.

## Ejecución del proyecto:

Herramientas necesarias  antes de la instalación:
- Visual studio code
- Laravel 10
- Php 
- Composer
- Node Js
- Maria Db
- Git

Puedes validar que tengas las tecnologías necesarias para ejecutar el proyecto por medio de los siguientes comandos:

- Validar php:         ```php –version```
- Validar composer: ```composer –version```
- Validar laravel:  ```laravel –version```
- Validar npm: ```npm –versión```

Si no tienes alguna. Debes instalarla.

### Descarga del proyecto e instalación de dependencias

Una vez te encuentres en tu editor de código de preferencia ejecuta el comando:

    git clone https://github.com/ValeriaHerreraP/ecommerce-bootcamp.git

Una vez descargado el proyecto, nos ubicamos dentro de la carpeta del mismo e instalamos las dependencias con los siguientes comandos:

- Dependencias de composer:

        composer install

- Depedencias de NPM:

        npm install

Para cargar las vistas con todas sus funcionalidades en el navegador es necesario ejecutar el siguiente comando:

    npm run dev

### Configuración archivo .env

En la carpeta raíz del proyecto encontraras un archivo llamado ```.env.example``` el cual sirve de ejemplo para crear tu propio archivo ```.env```

Dentro de este archivo ```.env``` se configuran las variables de entorno, entre ellas: configuración de base de datos, configuración de servidor SMTP, credenciales de ingreso a pasarela de pagos, entre otras.

Las configuraciones obligatorias para este proyecto son:

- Configuración de base de datos: puedes usar la misma que se encuentra en el archivo de ejemplo. Teniendo en cuenta que debes crear en tu motor de base de datos una nueva BD con el mismo nombre <ecommerse_bootcamp>.  Y finalmente configurar el usuario y la contraseña con la que accedes a tu motor. 

- Configuración de servidor SMPT: dentro de la funcionalidad del sistema se encuentra correo de verificación por medio de Mailtrap con el fin de permitir el ingreso a las funcionalidades. Por lo que debes configurar el servidor de mailtrap.

### Migración de datos

Para crear las tablas y rellenarlas con datos de prueba (seeders) debes ejecutar el comando:

    php artisan migrate –seed

### Habilitar almacenamiento de archivos

Para habilitar el almacenamiento de archivos (imágenes de productos) debes ejecutar el comando:

    php artisan storage:link

### Generación de key

Antes de inicializar el servidor, se debe crear la Key del proyecto en artisan:

    php artisan key:generate

### Inicializar el servidor

Una vez creada la Key puedes inicializar el servidor y probar las funcionalidades del programa ejecutando el siguiente comando:

    php artisan serve


### Trabajos encolados

Si deseas ejecutar los trabajos encolados de la exportación y la importación de los productos, debes ejecutar el comando: 

    php artisan queue:work

### Test

Para ejecutar los test ejecuta el comando:

    .vendor/bin/phpunit


