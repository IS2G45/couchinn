<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * ini_set('display_startup_errors', 1);
  ini_set('display_errors', 1);
  error_reporting(-1);
 */

require_once('./config/config.php');
require_once(PATH_CONTROLLER . 'IndexController.php');
require_once(PATH_CONTROLLER . 'SessionController.php');
require_once(PATH_CONTROLLER . 'ErrorHandlerController.php');

//Se chequea si el requerimiento http es via GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    IndexController::getInstance()->indexAction();
}

//Se chequea si el requerimiento http es via POST
//$isPaginador = ($_SERVER['REQUEST_METHOD'] == 'POST' && $_GET["action"] == "paginador") ? true : false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    return IndexController::getInstance()->ajax_paginadorAction();
}
