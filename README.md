# Evaluación Técnica - Catálogo de Menús

Este proyecto es una evaluación técnica que implementa un catálogo para la gestión de menús de un sistema, incluyendo funcionalidades para crear, editar y eliminar menús. Además, permite visualizar los menús y submenús generados, mostrando la descripción de cada ítem al hacer clic en él.

## Características

- **Creación de Menús**: Alta de menús con los campos nombre, descripción y dependencia a otro menú.
- **Edición de Menús**: Modificación de los menús existentes.
- **Eliminación de Menús**: Eliminación de menús con confirmación.
- **Consulta de Menús**: Visualización de menús y submenús generados, mostrando la descripción en el centro de la página al hacer clic.
- **Modelo MVC**: Estructura del proyecto siguiendo el patrón de diseño Modelo-Vista-Controlador (MVC).
- **PHP Puro y POO**: Desarrollo utilizando PHP puro y programación orientada a objetos.
- **Conexión a Base de Datos mediante PDO**: Gestión de la base de datos usando PDO (PHP Data Objects).

## Requisitos

- Servidor web con soporte para PHP (por ejemplo, Apache o Nginx).
- Base de datos MySQL.
- Navegador web moderno.

## Instalación

1. Clona el repositorio en tu servidor local:
    ```sh
    git clone https://github.com/eduanayardo/prueba-tecnica-dp
    ```

2. Navega al directorio del proyecto:
    ```sh
    cd prueba-tecnica-dp
    ```

3. Configura la base de datos:
    - Crea una base de datos en MySQL.
    - Crea la tabla `menus` a partir del siguiente esquema:
      ```sql
        CREATE TABLE menus (
          id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
          nombre VARCHAR(255) NOT NULL DEFAULT '',
          descripcion VARCHAR(255) NOT NULL DEFAULT '',
          menu_id INT(11) NOT NULL DEFAULT 0,
          estatus TINYINT(1) NOT NULL DEFAULT 1,
          fecha_registro TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
          fecha_modificacion DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(),
          PRIMARY KEY (id),
          KEY menu_id (menu_id)
        ) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
        ```
    - Si deseas tener datos ya en la tabla, ejecuta la siguiente consulta `SQL`:
      ```sql
        INSERT INTO menus (id, nombre, descripcion, menu_id, estatus, fecha_registro, fecha_modificacion)
        VALUES
          (1, 'Catálogos', 'Menú de catálogos', 0, 1, '2024-06-21 00:08:28', NULL),
          (2, 'Tipos de archivos', 'Listado de tipos de archivos', 1, 1, '2024-06-21 00:15:39', NULL),
          (3, 'Profesiones', 'Listado de profesiones', 1, 1, '2024-06-21 00:16:00', NULL),
          (4, 'Marcas', 'Listado de marcas', 0, 1, '2024-06-21 00:16:20', NULL);
      ```

4. Configura el acceso a la base de datos:
    - Renombra el archivo `example.env` a `.env`.
    - Edita el archivo `.env` y actualiza las credenciales de la base de datos:
        ```
        DB_TYPE=mysql
        DB_HOST=127.0.0.1
        DB_NAME=nombre_de_tu_base_de_datos
        DB_USER=tu_usuario
        DB_PASS=tu_contraseña
        DB_CHARSET=utf8
        ```

## Estructura del Proyecto
~~~
/prueba-tecnica-dp
├── /Config                   # Carpeta de Configuración
│   ├── config.php            # Configuración de la aplicación
│   ├── Database.php          # Clase para la conexión a la base de datos usando PDO
│   └── load_env_variables.php# Carga las variables de entorno desde el archivo .env
├── /Controllers              # Carpeta de Controladores
│   └── MenuController.php    # Controlador para las operaciones CRUD del menú
├── /Models                   # Carpeta de Modelos
│   └── MenuModel.php         # Modelo para la objeto Menú
├── /public                   # Carpeta de Archivos públicos
│   ├── /css                  # Carpeta de Archivos CSS
│   │   └── style-min.css     # Archivo CSS minificado
│   │   └── style.css         # Archivo CSS
│   ├── /js                   # Carpeta de Archivos JavaScript
│   │   └── script-min.js     # Archivo JavaScript minificado
│   │   └── script.js         # Archivo JavaScript
├── /Views                    # Carpeta de Vistas
│   ├── /Templates            # Carpeta de Plantillas
│   │   ├── footer.php        # Pie de página
│   │   └── header.php        # Encabezado
│   ├── edicion_menu.php      # Formulario para agregar y editar menús
│   ├── index.php             # Página principal de la aplicación
│   └── listado_menu.php      # Listado y gestión de menús
├── .gitignore                # Archivos y directorios que Git debe ignorar
├── example.env               # Archivo de ejemplo para la configuración de variables de entorno
├── index.php                 # Punto de entrada principal de la aplicación
└── README.md                 # Documentación del proyecto
~~~

## Uso

- **Abre tu navegador e ingresa la siguiente dirección**:
   ```sh
    http://localhost/prueba-tecnica-dp
    ```
- **Página principal**: Aquí se podrá observar el menú una vez que hayamos dado de alta al menos un elemento.
    ![Página de inicio](/public/screenshots/index.png "Inicio")
- **Listado de menús**: Aquí podremos ver un listado paginado de los menús que se han dado de alta.
    ![Listado de menús](/public/screenshots/listado.png "Listado de menús")
- **Agregar Menú**: Usa el formulario de alta para agregar nuevos ítems al menú.
    ![Formulario para agregar un nuevo menú](/public/screenshots/nuevo-menu.png "Formulario para agregar un nuevo menú")
- **Editar Menús**: Haz clic en el botón "Editar" junto a cualquier ítem del menú para modificarlo.
    ![Formulario para editar un nuevo menú](/public/screenshots/editar-menu.png "Formulario para editar un nuevo menú")
- **Eliminar Menús**: Haz clic en el botón "Eliminar" junto a cualquier ítem del menú y confirma la acción.
    ![Eliminar un menú](/public/screenshots/eliminar-menu.png "Eliminar un menú")
- **Descripción de los Menús**: Haz clic en cualquier ítem del menú para ver su descripción en el centro de la página.
    ![Se muestra la descripción al dar clic en algún menú](/public/screenshots/index-descripcion.png "Se muestra la descripción al dar clic en algún menú")


## Agradecimientos

Gracias por tomarte el tiempo para revisar este proyecto. Espero y cumpla con los requerimientos solicitados y cualquier feedback o sugerencia siempre es bienvenida.

## Contacto

Para cualquier consulta o sugerencia, puedes contactarme en la siguiente dirección de correo [eduanayardo@gmail.com](mailto:eduanayardo@gmail.com).
