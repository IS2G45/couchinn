<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('./config/config.php');
require_once(PATH_CONTROLLER . 'ReporteController.php');
require_once(PATH_CONTROLLER . 'ErrorHandlerController.php');

//Se chequea si el requerimiento http es via GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    switch ($_GET["action"]) {
        case 'solicitudes':
            ReporteController::getInstance()->reporte1Action();
            break;
        default:
            //Se lanza una pagina de error
            ErrorHandlerController::getInstance()->notFoundAction();
            break;
    }
}
//Se chequea si el requerimiento http es via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_GET["action"]) {
        case 'ajax_solicitudes':
            echo ReporteController::getInstance()->rajax_eporte1Action();
            break;
        default:
            echo ErrorHandlerController::getInstance()->notFoundAction();
            break;
    }
}
