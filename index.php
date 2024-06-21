<?php
define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('URL', ROOT . "prueba-tecnica-dp/");

require_once URL . '/Config/config.php';
require_once URL . 'Config/Database.php';
require_once URL . 'Controllers/MenuController.php';

$accion = isset($_GET['accion']) ? $_GET['accion'] : '';

$controller = new MenuController();

switch ($accion) {
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
