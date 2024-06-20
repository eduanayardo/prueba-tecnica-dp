<?php
require_once 'config.php';

/**
 * Clase Database
 *
 * Esta clase maneja la conexión a la base de datos utilizando PDO (PHP Data Objects).
 * La configuración de la conexión se obtiene de las constantes definidas en el archivo
 * de configuración y las variables de entorno.
 *
 */
class Database
{
    private $conn;

    /**
     * getConnection: Establece y devuelve la conexión a la base de datos.
     *
     * @return PDO|null La conexión PDO a la base de datos, o null en caso de error.
     */

    public function getConnection() {
        $this->conn = null;
        try {
            $dsn = DB_TYPE . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $this->conn = new PDO($dsn, DB_USER, DB_PASS);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
