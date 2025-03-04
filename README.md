## Requisitos previos

<p>Asegurate de que tu equipo cuente con las siguientes tecnologías instaladas: </p>

- PHP

- MySQL

- Composer

## Features/ Funcionalidades

- Operaciones de crear, leer, actualizar y borrar (CRUD) para categorias mediante AJAX.

- Operaciones de crear, leer, actualizar y borrar (CRUD) para tareas mediante AJAX.

## Pasos instalación del proyecto

1. Clona este repositorio:
  ```bash
  git clone https://github.com/ChallengerClay/task-manager.git
  ```
2. Navega al directorio del proyecto:
  ```bash
  cd task-manager
  ```

## Comandos a ejecutar tras clonar el repositorio

| Comando                          | Acción                                                                                                                                                                |
|----------------------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| composer install                 | Lee el archivo composer.json e instala las dependencias en la carpeta vendor (si esta carpeta no existe, este comando la crea)                                        |
| npm install                      | Lee el archivo package.json e instala las dependencias en la carpeta node_modules.                                                                                    |
| npm install jquery               | En caso de tener errores o las funciones de JQuery no funcionen, se recomienda ejecutar este comando.                                                                 |
| npm install ajax                 | Caso similar con JQuery, si las funcionalidades que utilizan Ajax no funcionan, se recomienda ejecutar este comando.                                                  |
| (Linux/Mac) cp .env.example .env | Al contar con un entorno de Linux o Mac, ejecutar este comando para crear una copia del archivo .env.example para poder cambiar las variables de entorno a comodidad. |
| (Windows) copy .env.example .env | Al contar con un entorno de Windows, ejecutar este comando para crear una copia del archivo .env.example para poder cambiar las variables de entorno a comodidad.      

## Crear la base de datos para el manager de tareas
<p>Recordatorio de tener MySQL instalado para poder crear la base de datos para almacenar las tareas y las categorías, para crear la base de datos puedes optar por estos pasos: </p>

- Crear la base de datos desde tu terminal usando el siguiente comando al ingresar:
  ```bash
  CREATE DATABASE task_manager CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
  ```

- Crear la base de datos en PhpMyAdmin con su respectivo nombre y se recomienda que sea con el cotejamiento utf8mb4_unicode_ci

## Tras crear la base de datos, correr CategorySeeder para no tener que agregarlas manualmente

php artisan db:seed --class=CategorySeeder


## Hacer que el proyecto funcione en entorno local

<p>Una vez realizados los pasos, se debe proceder a ejecutar el siguiente comando</p>

  ```bash
    composer run dev
  ```


## Tecnologías / Stack

| Tecnología | Versión |
|------------|---------|
| PHP        | 8.2     |
| Laravel    | 12.0    |
| Jquery     | 3.7.1   |
| Ajax       | 0.0.4   |
| Tailwind   | 4.0.0   |
