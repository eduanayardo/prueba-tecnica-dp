<?php
class Menu
{
    private $conn;
    private $nombre_table = "menus";

    public $id;
    public $nombre;
    public $descripcion;
    public $menu_id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->nombre_table . " (nombre, descripcion, menu_id) VALUES (:name, :descripcion, :menu_id)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":descripdescripciontion", $this->descripcion);
        $stmt->bindParam(":menu_id", $this->menu_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function read()
    {
        $query = "SELECT * FROM " . $this->nombre_table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getMenu()
    {
        $query = "SELECT * FROM " . $this->nombre_table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function update()
    {
        $query = "UPDATE " . $this->nombre_table . " SET nombre = :nombre, descripcion = :descripcion, menu_id = :menu_id WHERE id = :id";
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

    public function delete()
    {
        $query = "DELETE FROM " . $this->nombre_table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
