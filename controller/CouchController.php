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
require_once(PATH_VIEW . 'ErrorHandlerView.php');
require_once(PATH_MODEL . 'CouchModel.php');
require_once(PATH_CONTROLLER . 'SessionController.php');

class CouchController {

    private static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 
     */
    public function newAction() {
        $session = SessionController::getInstance();
        if ($session->isLogginAction()) {
            $dataSession = $session->getData();
            //Se obtiene de la BD las provincias
            $provincias = CouchModel::getInstance()->getProvincias();
            //Se obtiene de la BD los tipos de Couch Cargados
            $tipos = CouchModel::getInstance()->getTipos();

            //Se renderiza la plantilla pasandole los parámetros necesarios para visualizar la página 
            $view = new CouchView();
            return $view->renderNew(array(
                        "tipos" => $tipos,
                        "provincias" => $provincias,
                        "session" => $dataSession
            ));
        } else {
            $view = new ErrorHandlerView();
            return $view->renderAcccesDenied();
        }
    }

    /**
     * Muestra un couch
     */
    public function showAction() {
        $session = SessionController::getInstance();
        if ($session->isLogginAction()) {
            $dataSession = $session->getData();
            $couch = CouchModel::getInstance()->getCouchById(array(
                "idCouch" => $_GET['id']
            ));
            if ($couch) {
                $view = new CouchView();
                return $view->renderShow(array(
                            "session" => $dataSession,
                            "couch" => $couch
                ));
            } else {
                //No fue encontrado el couch en la BD
                $view = new ErrorHandlerView();
                return $view->renderNotFound();
            }
        } else {
            $view = new ErrorHandlerView();
            return $view->renderAcccesDenied();
        }
    }

    /**
     * Funcion llamada por ajax para retornar las ciudades de una provincia recibida como parámetro
     */
    public function ajax_getCiudadesAction() {
        $ciudades = CouchModel::getInstance()->getCiudades(array(
            "id_provincia" => $_POST["id_provincia"]
        ));
        $view = new CouchView();
        return $view->renderCiudades(array(
                    "ciudades" => $ciudades,
        ));
    }

    /**
     * Función llamada por ajax que verifica los datos provenientes del cliente y de ser los correctos, los persiste en la Base de Datos
     */
    public function ajax_couchSubmitAction() {
        $blob = file_get_contents($_FILES['foto']['tmp_name']);
        if (!$blob) {//Validacion del tamaño de la imagen
            return json_encode(array(
                "error" => true,
                "msj" => "Error al cargar la imagen. (tamaño < 8Mb)"
            ));
        }
        $session = SessionController::getInstance()->getData();
        $result = CouchModel::getInstance()->newCouch(array(
            'idTipoCouch' => $_POST['idTipoCouch'],
            'idUsuario' => $session['id'],
            'idCiudad' => $_POST['idCiudad'],
            'capacidad' => $_POST['capacidad'],
            'descripcion' => $_POST['descripcion'],
            'titulo' => $_POST['titulo'],
            'foto' => $blob,
        ));
        if ($result) {
            return json_encode(array(
                "error" => false,
                "id" => $result
            ));
        } else {
            return json_encode(array(
                "error" => true,
                "msj" => "Error en la Base de Datos."
            ));
        }
    }

}
