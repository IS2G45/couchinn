<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReporteController
 *
 * @author kibunke
 */
require_once(PATH_MODEL . 'ReporteModel.php');
require_once(PATH_CONTROLLER . 'SessionController.php');
require_once(PATH_VIEW . 'ReporteView.php');

class ReporteController {

    private static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /*
     * 
     */

    public function reporte1Action() {
        $session = SessionController::getInstance();
        if (!$session->isLogginAction()) {
            $view = new ErrorHandlerView();
            return $view->renderAcccesDenied();
        }
        $dataSession = $session->getData();
        $view = new ReporteView();
        // $realizadas = ReservaModel::getInstance()->getListadoRealizados($dataSession['id']);
        return $view->renderReporteSolicitudesAceptadas(array(
                    "session" => $dataSession,
        ));
    }

    /**
     * 
     */
    public function rajax_eporte1Action() {
        $session = SessionController::getInstance();
        if (!$session->isLogginAction()) {
            return json_encode(array(
                "error" => true,
                "msj" => "Error de acceso."
            ));
        }
        $resultado = ReporteModel::getInstance()->reservasRealizadas($_POST['fechaIni'], $_POST['fechaFin']);
        
        return var_dump($resultado);
        
        return json_encode(array(
            "error" => false,
            "result" => $view->renderCalificaciones(array(
                "result" => $resultado,
            ))
        ));
    }

}
