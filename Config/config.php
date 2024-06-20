<?php
require_once 'load_env_variables.php';

/**
 * Configuración para Base de Datos
 *
 * Este archivo define las constantes utilizadas para la configuración
 * de la conexión a la base de datos. Utiliza variables de entorno para
 * mejorar la seguridad y la portabilidad de la aplicación.
 *
 * Las constantes definidas aquí incluyen:
 * * DB_TYPE: El tipo de base de datos (por ejemplo, 'mysql').
 * * DB_HOST: La dirección IP o el nombre del host del servidor de la base de datos.
 * * DB_NAME: El nombre de la base de datos a la que se va a conectar.
 * * DB_USER: El nombre de usuario para la conexión a la base de datos.
 * * DB_PASS: La contraseña del usuario para la conexión a la base de datos.
 * * DB_CHARSET: El conjunto de caracteres que se utilizará para la conexión.
 *
 * Las variables de entorno se obtienen utilizando la función `getenv()`, y si no
 * están definidas, se utilizan valores predeterminados.
 */

define('DB_TYPE', getenv('DB_TYPE') ?: 'mysql');
define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_NAME', getenv('DB_NAME') ?: 'menus');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_CHARSET', getenv('DB_CHARSET') ?: 'utf8');


define('URL_PUBLIC_FOLDER', 'public');
define('URL_SUB_FOLDER', str_replace(URL_PUBLIC_FOLDER, '', dirname($_SERVER['SCRIPT_NAME'])));


/**
 * Obtener la URL base dinámica
 *
 * @return string URL base del proyecto
 */
function getBaseUrl() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $script = $_SERVER['SCRIPT_NAME'];
    $path = str_replace(basename($script), '', $script);
    return $protocol . $host . $path;
}

define('BASE_URL', getBaseUrl());
