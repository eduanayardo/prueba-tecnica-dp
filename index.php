<?php
define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('URL', ROOT . "prueba-tecnica-dp/");
// echo __DIR__;
require_once URL . '/Config/config.php';
// echo BASE_URL;
require_once URL . 'Config/Database.php';
require_once URL . 'Controllers/MenuController.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

$controller = new MenuController();

switch ($action) {
    case 'menuNuevo':
        $controller->menuNuevo();
        break;
    case 'menuActualizar':
        $controller->menuActualizar();
        break;
    case 'menuEliminar':
        $controller->menuEliminar();
        break;
    case 'menuListado':
        $controller->menuListado();
        break;
    default:
        $controller->index();
        break;
}
