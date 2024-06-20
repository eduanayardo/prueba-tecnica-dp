<?php
define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('URL', ROOT . "prueba-tecnica-dp/");

require_once URL . 'Config/config.php';
require_once URL . 'Config/Database.php';
require_once URL . 'Controllers/MenuController.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

$controller = new MenuController();

switch ($action) {
    case 'create':
        $controller->create();
        break;
    case 'edit':
        $controller->update();
        break;
    case 'delete':
        $controller->delete();
        break;
    default:
        $controller->read();
        break;
}
