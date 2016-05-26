<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CouchController
 *
 * @author kibunke
 */
require_once(PATH_VIEW . 'CouchView.php');
require_once(PATH_MODEL. 'CouchModel.php');

class CouchController {

    private static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function newAction() {
        //Se obtiene de la BD las provincias
        $provincias = CouchModel::getInstance()->getProvincias();
        //Se obtiene de la BD los tipos de Couch Cargados
        $tipos = CouchModel::getInstance()->getTipos();
        
        //Se renderiza la plantilla pasandole los parámetros necesarios para visualizar la página 
        $view = new CouchView();
        return $view->renderNew(array(
            "tipos" => $tipos,
            "provincias" => $provincias
        ));
    }
    
    /**
     * Funcion llamada por ajax para retornar las ciudades de una provincia recibida como parámetro
     */
    public function getCiudades($id_provincia){
        $ciudades = CouchModel::getInstance()->getCiudades(array("id_provincia" => $id_provincia));
        $view = new CouchView();
        return $view->renderCiudades(array(
            "ciudades" => $ciudades,
        ));
    }

}
