<?php
class Menu
{
    private $conn;
    private $nombre_tabla = "menus";

    public $id;
    public $nombre;
    public $descripcion;
    public $menu_id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

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

    public function getMenus()
    {
        $query = "SELECT * FROM {$this->nombre_tabla}; ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getMenusListado()
    {
        $query = "SELECT {$this->nombre_tabla}.*, IFNULL(menu_padre.nombre, '---') padre FROM {$this->nombre_tabla} LEFT JOIN {$this->nombre_tabla} menu_padre  ON {$this->nombre_tabla}.menu_id = menu_padre.id ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getMenu()
    {
        $query = "SELECT * FROM {$this->nombre_tabla} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        return $stmt;
    }

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

    private function actualizarHijos()
    {
        $query = "UPDATE {$this->nombre_tabla} SET menu_id = 0 WHERE menu_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
    }

    public function getMenuJerarquico() {
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
