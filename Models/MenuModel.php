<?php
class Menu
{
    private $conn;           // Conexión a la base de datos
    private $nombre_tabla = "menus"; // Nombre de la tabla en la base de datos

    public $id;              // ID del menú
    public $nombre;          // Nombre del menú
    public $descripcion;     // Descripción del menú
    public $menu_id;         // ID del menú padre

    /**
     * Constructor de la clase Menu
     *
     * Establece la conexión a la base de datos.
     *
     * @access public
     * @param object $db Conexión a la base de datos
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Crea un nuevo menú
     *
     * Este método inserta un nuevo registro en la tabla de menús.
     *
     * @access public
     * @return boolean True si el menú se creó correctamente, false en caso contrario
     */
    public function menuNuevo()
    {
        $query = "INSERT INTO {$this->nombre_tabla} (nombre, descripcion, menu_id) VALUES (:nombre, :descripcion, :menu_id)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":menu_id", $this->menu_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Obtiene todos los menús
     *
     * Este método recupera todos los registros de la tabla de menús.
     *
     * @access public
     * @return PDOStatement El resultado de la consulta
     */
    public function getMenus()
    {
        $query = "SELECT * FROM {$this->nombre_tabla};";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Obtiene la lista de menús con el nombre del menú padre
     *
     * Este método recupera todos los menús y muestra el nombre del menú padre si existe.
     *
     * @access public
     * @return PDOStatement El resultado de la consulta
     */
    public function getMenusListado()
    {
        $query = "SELECT {$this->nombre_tabla}.*, IFNULL(menu_padre.nombre, '---') padre FROM {$this->nombre_tabla} LEFT JOIN {$this->nombre_tabla} menu_padre  ON {$this->nombre_tabla}.menu_id = menu_padre.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Obtiene un menú por su ID
     *
     * Este método recupera un menú específico basado en su ID.
     *
     * @access public
     * @return PDOStatement El resultado de la consulta
     */
    public function getMenu()
    {
        $query = "SELECT * FROM {$this->nombre_tabla} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Actualiza un menú existente
     *
     * Este método actualiza un registro en la tabla de menús basado en su ID.
     *
     * @access public
     * @return boolean True si el menú se actualizó correctamente, false en caso contrario
     */
    public function menuActualizar()
    {
        $query = "UPDATE {$this->nombre_tabla} SET nombre = :nombre, descripcion = :descripcion, menu_id = :menu_id WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":menu_id", $this->menu_id);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Elimina un menú
     *
     * Este método elimina un registro en la tabla de menús basado en su ID.
     *
     * @access public
     * @return boolean True si el menú se eliminó correctamente, false en caso contrario
     */
    public function menuEliminar()
    {
        $this->actualizarHijos();

        $query = "DELETE FROM {$this->nombre_tabla} WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Actualiza los hijos de un menú eliminado
     *
     * Este método actualiza los menús hijos de un menú eliminado, estableciendo su menu_id a 0.
     *
     * @access private
     */
    private function actualizarHijos()
    {
        $query = "UPDATE {$this->nombre_tabla} SET menu_id = 0 WHERE menu_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
    }

    /**
     * Obtiene el menú jerárquico
     *
     * Este método recupera los menús de forma jerárquica usando una consulta recursiva.
     *
     * @access public
     * @return PDOStatement El resultado de la consulta
     */
    public function getMenuJerarquico()
    {
        $query = "
            WITH RECURSIVE menuJerarquico AS (
                SELECT
                    id,
                    nombre,
                    descripcion,
                    menu_id,
                    0 AS nivel
                FROM
                    {$this->nombre_tabla}
                WHERE
                    menu_id = 0
                UNION ALL
                SELECT
                    m.id,
                    m.nombre,
                    m.descripcion,
                    m.menu_id,
                    mh.nivel + 1
                FROM
                    {$this->nombre_tabla} m
                INNER JOIN
                    menuJerarquico mh ON m.menu_id = mh.id
            )
            SELECT
                id,
                nombre,
                descripcion,
                menu_id,
                nivel
            FROM
                menuJerarquico
            ORDER BY
                nivel, menu_id, id;
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
