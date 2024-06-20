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

    public function index()
    {
        $stmt = $this->menu->getMenuJerarquico();
        $menus = $stmt->fetchAll(PDO::FETCH_ASSOC);
        include URL.'Views/index.php';
    }

    public function menuNuevo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitizar los datos obtenidos desde el formulario
            $nombre = htmlspecialchars($_POST["nombre"], ENT_QUOTES);
            $descripcion = htmlspecialchars($_POST["descripcion"], ENT_QUOTES);
            $menuId = filter_input(INPUT_POST, 'menu_id', FILTER_VALIDATE_INT);

            // Validar datos del formulario
            $errors = [];
            if (empty($nombre)) {
                $errors[] = 'El nombre del menú es obligatorio.';
            }
            if (empty($descripcion)) {
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

            if ($this->menu->menuNuevo()) {
                header("Location: ".BASE_URL);
            } else {
                echo "Error creating menu.";
            }
        }
        include URL.'Views/edicion_menu.php';
    }

    public function menuListado()
    {
        $stmt = $this->menu->getMenusListado();
        $menus = $stmt->fetchAll(PDO::FETCH_ASSOC);
        include URL.'Views/listado_menu.php';
    }

    public function menuActualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitizar los datos obtenidos desde el formulario
            $idMenu = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            $nombre = htmlspecialchars($_POST["nombre"], ENT_QUOTES);
            $descripcion = htmlspecialchars($_POST["descripcion"], ENT_QUOTES);
            $menuId = filter_input(INPUT_POST, 'menu_id', FILTER_VALIDATE_INT);

            // Validar datos del formulario
            $errors = [];
            if (empty($nombre)) {
                $errors[] = 'El nombre del menú es obligatorio.';
            }
            if (empty($descripcion)) {
                $errors[] = 'La descripción del menú es obligatoria.';
            }

            // Si hay errores, mostrar el formulario con mensajes de error
            if (!empty($errors)) {
                include URL.'Views/edicion_menu.php';
                return;
            }

            $this->menu->id = $idMenu;
            $this->menu->nombre = $nombre;
            $this->menu->descripcion = $descripcion;
            $this->menu->menu_id = $menuId;

            if ($this->menu->menuActualizar()) {
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

    public function menuEliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->menu->id = $_POST['id'];

            if ($this->menu->menuEliminar()) {
                header("Location: ../Views/listMenu.php");
            } else {
                echo "Error deleting menu.";
            }
        }
    }
}
