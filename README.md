
# PRUEBA OPCALE

## Descripción del Proyecto

Este es un proyecto desarrollado con Laravel 9-10 y Laravel Nova. El objetivo de este proyecto es cumplir con los requerimientos de la prueba que incluye la implementación de dos desafíos específicos:

1. Implementación del servidor de webhooks utilizando Spatie Webhook Server.
2. Conexión con la API de OpenAI usando Laravel GPT para detectar nuevos usuarios creados en las últimas 24 horas.

## Requerimientos

- Laravel 9-10
- Laravel Nova 
- SQLite

## Instalación

1. **Clonar el repositorio:**

   ```bash
   git clone <URL_del_repositorio>
   cd <nombre_del_proyecto>
   ```

2. **Instalar las dependencias:**

   ```bash
   composer install
   ```

3. **Configurar la base de datos:**

   Crear el archivo de la base de datos SQLite:

   ```bash
   touch database/database.sqlite
   ```

   Copiar el archivo `.env.example` a `.env` y ajustar la configuración según sea necesario:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Cargar los datos precargados:**

   ```bash
   php artisan migrate --seed
   ```

## Funcionalidades

### 1. Implementación del Servidor de Webhooks

Se ha implementado un servidor de webhooks utilizando Spatie Webhook Server. Los usuarios pueden crear registros de webhooks definiendo el método, la URL y los encabezados. Cada vez que se crea un usuario, se envía el payload del usuario a todos los webhooks registrados.

- Para ejecutar pruebas unitarias relacionadas con esta funcionalidad:

  ```bash
  php artisan test
  ```

### 6. Conexión con la API de OpenAI

Se ha implementado una conexión con la API de OpenAI utilizando Laravel GPT. Esta funcionalidad permite detectar los usuarios creados en las últimas 24 horas a través de un comando de ChatGPT.

- Para ejecutar este comando:

  ```bash
  php artisan chatgpt:detect-new-users
  ```

## Archivos Importantes

- **.env.example**: Contiene la configuración pertinente para correr el proyecto sin problemas de configuración.
- **database/database.sqlite**: Base de datos SQLite precargada incluida en el repositorio.

## Contribución

Para contribuir a este proyecto, por favor sigue los siguientes pasos:

1. Realiza un fork del proyecto.
2. Crea una nueva rama (`git checkout -b feature/nueva-funcionalidad`).
3. Realiza tus cambios y commitea (`git commit -am 'Agrega nueva funcionalidad'`).
4. Realiza un push a la rama (`git push origin feature/nueva-funcionalidad`).
5. Abre un Pull Request.

## Licencia

Este proyecto está bajo la licencia MIT. Consulta el archivo `LICENSE` para más detalles.
