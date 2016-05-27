<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('./config/config.php');
require_once(PATH_CONTROLLER . 'CouchController.php');

//Se chequea si el requerimiento http es via GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    switch ($_GET["show"]) {
        case 'new':
            CouchController::getInstance()->newAction();
            break;
        default:
            echo "index";
            //IndexController::getInstance()->errorPage();
            break;
    }
}

//Se chequea si el requerimiento http es via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_GET["action"]) {
        case 'get_ciudades':
            echo CouchController::getInstance()->ajax_getCiudades();
            break;
        case 'couch_submit':
            echo CouchController::getInstance()->ajax_couchSubmit();
            break;
        default:
            //IndexController::getInstance()->errorPage();
            break;
    }
}