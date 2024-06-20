<?php
/**
 * Cargar variables de entorno
 *
 * Este script carga las variables de entorno desde un archivo `.env` y las
 * establece en el entorno PHP utilizando la función `putenv()`. Las variables
 * de entorno permiten una configuración flexible y segura de la aplicación.
 */

if (file_exists(__DIR__ . '/../.env')) {
    $lines = file(__DIR__ . '/../.env');
    foreach ($lines as $line) {
        if (trim($line) === '' || strpos(trim($line), '#') === 0) {
            continue;
        }
        list($name, $value) = explode('=', trim($line), 2);
        putenv(sprintf('%s=%s', $name, $value));
    }
}
