<?php
// Incluye los archivos necesarios para la conexión a la base de datos y el modelo de menú
require_once URL . '/Config/Database.php';
require_once URL . '/Models/MenuModel.php';

class MenuController
{
    private $db;   // Conexión a la base de datos
    private $menu; // Instancia del modelo de menú

    /**
     * Constructor de la clase MenuController
     *
     * Establece la conexión a la base de datos y crea una instancia del modelo de menú.
     *
     * @access public
     */
    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->menu = new Menu($this->db);
    }

    /**
     * Muestra la página principal con el menú jerárquico
     *
     * Este método obtiene los menús jerarquicamente y los muestra en la vista principal.
     *
     * @access public
     */
    public function index()
    {
        $stmt = $this->menu->getMenuJerarquico();
        $menus = $stmt->fetchAll(PDO::FETCH_ASSOC);
        include URL . 'Views/index.php';
    }

    /**
     * Muestra el formulario para crear un menú y maneja su creación
     *
     * Este método muestra el formulario para crear un menú y, cuando el formulario es enviado,
     * sanitiza y valida los datos del formulario, y crea un nuevo menú en la base de datos.
     *
     * @access public
     */
    public function menuNuevo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitiza los datos obtenidos desde el formulario
            $nombre = htmlspecialchars($_POST["nombre"], ENT_QUOTES);
            $descripcion = htmlspecialchars($_POST["descripcion"], ENT_QUOTES);
            $menuId = filter_input(INPUT_POST, 'menu_id', FILTER_VALIDATE_INT);

            // Valida los datos del formulario
            $errors = [];
            if (empty($nombre)) {
                $errors[] = 'El nombre del menú es obligatorio.';
            }
            if (empty($descripcion)) {
                $errors[] = 'La descripción del menú es obligatoria.';
            }

            // Si hay errores, muestra el formulario con mensajes de error
            if (!empty($errors)) {
                include URL . 'Views/edicion_menu.php';
                return;
            }

            // Asigna los valores al objeto menú
            $this->menu->nombre = $nombre;
            $this->menu->descripcion = $descripcion;
            $this->menu->menu_id = $menuId;

            // Intenta guardar el nuevo menú en la base de datos
            if ($this->menu->menuNuevo()) {
                header("Location: " . BASE_URL . "?accion=menuListado");
            } else {
                header("Location: " . BASE_URL . "?accion=menuNuevo&error=1");
            }
        }

        // Incluye la vista del formulario para crear/editar menú
        include URL . 'Views/edicion_menu.php';
    }

    /**
     * Obtiene todos los menús
     *
     * Este método obtiene todos los menús de la base de datos y se muestran en el Select del formulario.
     *
     * @access public
     * @return array
     */
    public function getMenus()
    {
        $stmt = $this->menu->getMenus();
        $menus = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $menus;
    }

    /**
     * Muestra la lista de menús
     *
     * Este método obtiene todos los menús y se muestran en la vista del lsitado.
     *
     * @access public
     */
    public function menuListado()
    {
        $stmt = $this->menu->getMenusListado();
        $menus = $stmt->fetchAll(PDO::FETCH_ASSOC);
        include URL . 'Views/listado_menu.php';
    }

    /**
     * Maneja la actualización de un menú
     *
     * Este método muestra el formulario para editar un menú y cuando el formulario es enviado,
     * sanitiza y valida los datos del formulario, y actualiza el menú en la base de datos.
     *
     * @access public
     */
    public function menuActualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitiza los datos obtenidos desde el formulario
            $idMenu = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            $nombre = htmlspecialchars($_POST["nombre"], ENT_QUOTES);
            $descripcion = htmlspecialchars($_POST["descripcion"], ENT_QUOTES);
            $menuId = filter_input(INPUT_POST, 'menu_id', FILTER_VALIDATE_INT);

            // Valida los datos del formulario
            $errors = [];
            if (empty($nombre)) {
                $errors[] = 'El nombre del menú es obligatorio.';
            }
            if (empty($descripcion)) {
                $errors[] = 'La descripción del menú es obligatoria.';
            }

            // Si hay errores, muestra el formulario con mensajes de error
            if (!empty($errors)) {
                include URL . 'Views/edicion_menu.php';
                return;
            }

            // Asigna los valores al objeto menú
            $this->menu->id = $idMenu;
            $this->menu->nombre = $nombre;
            $this->menu->descripcion = $descripcion;
            $this->menu->menu_id = $menuId;

            // Intenta actualizar el menú en la base de datos
            if ($this->menu->menuActualizar()) {
                header("Location: " . BASE_URL . "?accion=menuListado");
            } else {
                header("Location: " . BASE_URL . "?accion=menuNuevo&error=2");
            }
        } else {
            // Si el formulario no fue enviado, obtiene los datos del menú a editar
            $this->menu->id = $_GET['id'];
            $stmt = $this->menu->getMenu();
            $menu = $stmt->fetch(PDO::FETCH_ASSOC);
            include URL . 'Views/edicion_menu.php';
        }
    }

    /**
     * Maneja la eliminación de un menú
     *
     * Este método maneja la eliminación de un menú de la base de datos.
     *
     * @access public
     */
    public function menuEliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Asigna el ID del menú a eliminar
            $this->menu->id = $_GET['id'];

            // Intenta eliminar el menú de la base de datos
            if ($this->menu->menuEliminar()) {
                header("Location: " . BASE_URL . "?accion=menuListado");
            } else {
                header("Location: " . BASE_URL . "?accion=menuListado&error=3");
            }
        }
    }
}
