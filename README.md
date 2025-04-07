# ecommerce-backend
RESTful API for a digital media adspace reservation platform, built with Laravel 10. Includes user authentication with Sanctum, role-based access, availability logic, and reservation management.

## Descripción del Proyecto

Este proyecto tiene como objetivo desarrollar una plataforma de e-commerce para la reserva de espacios publicitarios digitales. La arquitectura del proyecto se dividió en dos repositorios: uno para el backend y otro para el frontend. Esta división responde a razones técnicas clave:

1. Escalabilidad y Mantenimiento: Separar el backend y el frontend facilita la escalabilidad y el mantenimiento del sistema, ya que cada repositorio puede evolucionar independientemente sin afectar directamente al otro.

2.  Optimización del Desempeño: Permite optimizar el rendimiento del servidor backend y la experiencia del usuario en el frontend sin que ambos dependan directamente uno del otro.

3. Desarrollo Independiente: Los equipos de backend y frontend pueden trabajar de manera más independiente, cada uno con su propio ciclo de desarrollo y despliegue, lo que acelera el tiempo de entrega y mejora la colaboración.

4. Flexibilidad: Al tener repositorios separados, es más fácil realizar integraciones con otras plataformas o servicios, o incluso cambiar la tecnología del frontend sin impactar la lógica del backend.

## Requisitos

Asegúrate de tener instalado lo siguiente:

- PHP >= 8.2  
- Composer  
- MySQL
- Docker (si deseas utilizar la configuración de Docker incluida en el proyecto, a través del archivo `docker-compose.yml`, para ejecutar los contenedores que corren el proyecto)

## Clonar el repositorio

```bash
git clone hgit@github.com:Necrospartan/ecommerce-backend.git
cd ecommerce-backend
```

## Instalar dependencias de PHP

```bash
composer install
```

## Configurar variables de entorno

Copia el archivo `.env.example` como `.env`:

```bash
cp .env.example .env
```

Configura las variables de la base de datos. Si se utiliza `docker-compose.yml`, utiliza la configuración que se encuentra en el archivo `.env.example`.

En el archivo `.env` debes agregar las siguientes variables:

```dotenv
APP_PORT="indicar el puerto en el que corre el servidor"

DB_CONNECTION=mysql
DB_HOST=mysqldb
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

L5_SWAGGER_CONST_HOST="${APP_URL}:${APP_PORT}"
L5_SWAGGER_GENERATE_ALWAYS=true
```

**Explicación de las variables:**
- `APP_PORT`: Define el puerto en el que correrá el servidor Laravel (ej. 8000, o 8017 para docker).
- `DB_HOST`: El host de la base de datos, si usas Docker sería el nombre del servicio en `docker-compose.yml` (por ejemplo, `mysqldb`).
- `DB_PORT`: Puerto por defecto para MySQL (3306).
- `DB_DATABASE`: El nombre de la base de datos que estás utilizando.
- `DB_USERNAME`: El usuario de la base de datos.
- `DB_PASSWORD`: La contraseña de la base de datos.
- `L5_SWAGGER_CONST_HOST`: La URL del Swagger UI, que depende del puerto y la URL de la app.
- `L5_SWAGGER_GENERATE_ALWAYS`: Establece que siempre se genere la documentación Swagger.

Una vez configuradas las variables, guarda los cambios.

## Generar clave de la aplicación

```bash
php artisan key:generate
```

# Configuración de la Base de Datos

Para configurar la base de datos, ejecuta los siguientes comandos en tu terminal:

```bash
php artisan migrate
php artisan db:seed
```

Si el proyecto está corriendo dentro de un contenedor Docker, sigue estos pasos:

1. Obtén el `CONTAINER ID` del contenedor en ejecución usando el siguiente comando:

```bash
docker ps
```

2. Accede al contenedor con el comando:

```bash
docker exec -it {CONTAINER ID} bash
```

3. Una vez dentro del contenedor, ejecuta los comandos de migración:

```bash
php artisan migrate
php artisan db:seed
```

Con esto, habrás configurado correctamente la base de datos para el proyecto.

## Correr el servidor de desarrollo

```bash
php artisan serve
```

Sin embargo, si estás utilizando un contenedor Docker, **no es necesario correr el servidor manualmente**. El contenedor ya está configurado para ejecutar el proyecto automáticamente cuando esté en funcionamiento.

### Usuarios por defecto para utilizar el API:

- `Administrador@example.org`, usuario con el rol Adimistrador, que puede registrar Medios.

- `Cliente1@example.org`, usuario con el rol de Cliente, que puede registrar hacer reservaciones.

- `Cliente2@example.org`, usuario con el rol de Cliente, que puede registrar hacer reservaciones.

La contraseña por defecto para los 3 usuarios es: **Password#1**

Ya existe `Medios` y `Reservaciones` creadas asociados a los dos usuariso anteriores.

La documentacion fue creada usando `Swagger` y esta se encuentra en: http://localhost:8000/api/documentation (por defecto) o si se utilizo docker en : http://localhost:8017/api/documentation 

Para hacer login solo hay que utilizar el `API` de login, sustituir los datos por la información de alguno de los anteriores usuarios, en la respuesta contendra un Token, copiar su información y agregarla donde dice `Authorize`, con esto ya podra acceder a las `Apis` que requieren autorización. Nota algunas `Apis` solo las puede utilizar un usuario con el rol de Administrador
