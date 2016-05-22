<?php

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

require_once('./config/config.php');
require_once(PATH_CONTROLLER . 'InterfacesController.php');

switch ($_GET["show"]) {
    case 'index':
        InterfacesController::getInstance()->indexAction();
        break;
    case 'layout':
        InterfacesController::getInstance()->layoutAction();
        break;
    case 'register':
        InterfacesController::getInstance()->registerAction();
        break;
    case 'counchinn':
        //CuotasController::getInstance()->modificar();
        break;
    default:
        echo "index";
        //IndexController::getInstance()->errorPage();
        break;
}