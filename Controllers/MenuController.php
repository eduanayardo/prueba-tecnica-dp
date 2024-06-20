<?php

// define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
// define('URL', ROOT . "");

require_once URL.'/Config/Database.php';
require_once URL.'/Models/MenuModel.php';

class MenuController
{
    private $db;
    private $menu;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->menu = new Menu($this->db);
    }

    public function create()
    {
        echo "<pre>"; print_r($_POST); echo "</pre>"; die();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
            $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);
            $menuId = filter_input(INPUT_POST, 'menu_id', FILTER_VALIDATE_INT);

            // Validar datos del formulario
            $errors = [];
            if (empty($name)) {
                $errors[] = 'El nombre del menú es obligatorio.';
            }
            if (empty($description)) {
                $errors[] = 'La descripción del menú es obligatoria.';
            }

            // Si hay errores, mostrar el formulario con mensajes de error
            if (!empty($errors)) {
                include URL.'Views/edicion_menu.php';
                return;
            }

            $this->menu->nombre = $nombre;
            $this->menu->descripcion = $descripcion;
            $this->menu->menu_id = $menuId;

            if ($this->menu->create()) {
                header("Location: ../Views/listMenu.php");
            } else {
                echo "Error creating menu.";
            }
        }
        include URL.'Views/edicion_menu.php';
    }

    public function read()
    {
        $stmt = $this->menu->read();
        $menus = $stmt->fetchAll(PDO::FETCH_ASSOC);
        include URL.'Views/listado_menu.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->menu->id = $_POST['id'];
            $this->menu->name = $_POST['name'];
            $this->menu->description = $_POST['description'];
            $this->menu->parent_id = $_POST['parent_id'];

            if ($this->menu->update()) {
                header("Location: ../Views/listMenu.php");
            } else {
                echo "Error updating menu.";
            }
        } else {
            // echo "<pre>"; print_r($_GET); echo "</pre>"; die();
            $this->menu->id = $_GET['id'];
            $stmt = $this->menu->getMenu();
            $menu = $stmt->fetch(PDO::FETCH_ASSOC);
            include URL.'Views/edicion_menu.php';
        }
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->menu->id = $_POST['id'];

            if ($this->menu->delete()) {
                header("Location: ../Views/listMenu.php");
            } else {
                echo "Error deleting menu.";
            }
        }
    }
}
