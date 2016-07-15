<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReservaController
 *
 * @author kibunke
 */
require_once(PATH_MODEL . 'ReservaModel.php');
require_once(PATH_CONTROLLER . 'SessionController.php');
require_once(PATH_VIEW . 'ReservaView.php');

class ReservaController {

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

    public function listadoRealizadasAction() {
        $session = SessionController::getInstance();
        if (!$session->isLogginAction()) {
            $view = new ErrorHandlerView();
            return $view->renderAcccesDenied();
        }
        $dataSession = $session->getData();
        $view = new ReservaView();
        $realizadas = ReservaModel::getInstance()->getListadoRealizados($dataSession['id']);
        return $view->renderListadoRealizadas(array(
                    "session" => $dataSession,
                    "realizadas" => $realizadas
        ));
    }

    /**
     * 
     */
    public function listadoRecibidasAction() {
        $session = SessionController::getInstance();
        if (!$session->isLogginAction()) {
            $view = new ErrorHandlerView();
            return $view->renderAcccesDenied();
        }
        $dataSession = $session->getData();
        $view = new ReservaView();
        $recibidas = ReservaModel::getInstance()->getListadoRecibidosPendientes($dataSession['id']);
        $noPendientes = ReservaModel::getInstance()->getListadoRecibidosNoPendientes($dataSession['id']);
        return $view->renderListadoRecibidas(array(
                    "session" => $dataSession,
                    "recibidas" => $recibidas,
                    "noPendientes" => $noPendientes
        ));
    }

    /**
     * 
     */
    public function listadoMisCalificacionesAction() {
        $session = SessionController::getInstance();
        if (!$session->isLogginAction()) {
            $view = new ErrorHandlerView();
            return $view->renderAcccesDenied();
        }
        $dataSession = $session->getData();
        $view = new ReservaView();


        $pendientes = ReservaModel::getInstance()->getCalificacionesPendientes($dataSession['id']);

        $calificadas = ReservaModel::getInstance()->getCalificacionesRealizadas($dataSession['id']);

        return $view->renderMisCalificaciones(array(
                    "session" => $dataSession,
                    "pendientes" => $pendientes,
                    "calificadas" => $calificadas
        ));
    }

    /**
     * 
     */
    public function listadoParaCalificarAction() {
        $session = SessionController::getInstance();
        if (!$session->isLogginAction()) {
            $view = new ErrorHandlerView();
            return $view->renderAcccesDenied();
        }
        $dataSession = $session->getData();
        $view = new ReservaView();


        $pendientes = ReservaModel::getInstance()->getCalificacionesPendientes($dataSession['id']);

        $calificadas = ReservaModel::getInstance()->getCalificacionesRealizadas($dataSession['id']);

        return $view->renderCalificaciones(array(
                    "session" => $dataSession,
                    "pendientes" => $pendientes,
                    "calificadas" => $calificadas
        ));
    }

    /**
     * 
     */
    public function ajax_aceptarReservaAction() {
        $session = SessionController::getInstance();
        if (!$session->isLogginAction()) {
            return json_encode(array(
                "error" => true,
                "msj" => "Error de acceso."
            ));
        }
        $estado = ReservaModel::getInstance()->getEstado("ACEPTADA");
        $dataSession = $session->getData();
        ReservaModel::getInstance()->updateReserva($_POST['idReserva'], array(
            "idReservaEstado" => $estado['id']
        ));
        $reserva = ReservaModel::getInstance()->getById($_POST['idReserva']);
        $paraRechazar = ReservaModel::getInstance()->reservasEnRangoFecha($reserva['idCouch'], $reserva['fechaInicio'], $reserva['fechaFin']);
        $estado = ReservaModel::getInstance()->getEstado("RECHAZADA");
        foreach ($paraRechazar as $res) {
            if ($res['idReserva'] != $_POST['idReserva']) {
                ReservaModel::getInstance()->updateReserva($res['idReserva'], array(
                    "idReservaEstado" => $estado['id']
                ));
            }
        }
        return json_encode(array(
            "error" => false,
        ));
    }

    /**
     * 
     */
    public function ajax_rechazarReservaAction() {
        $session = SessionController::getInstance();
        if (!$session->isLogginAction()) {
            return json_encode(array(
                "error" => true,
                "msj" => "Error de acceso."
            ));
        }
        $estado = ReservaModel::getInstance()->getEstado("RECHAZADA");
        $dataSession = $session->getData();
        ReservaModel::getInstance()->updateReserva($_POST['idReserva'], array(
            "idReservaEstado" => $estado['id']
        ));
        return json_encode(array(
            "error" => false,
        ));
    }

    /**
     * 
     */
    public function ajax_sentReservaAction() {
        $session = SessionController::getInstance();
        $dataSession = array(
            "logueado" => NULL
        );
        $estado = ReservaModel::getInstance()->getEstado("PENDIENTE");
        $fecha_inicio = explode("/", substr($_POST['fechas'], 0, 10));
        $fecha_fin = explode("/", substr($_POST['fechas'], 13, 10));
        if ($session->isLogginAction()) {
            $dataSession = $session->getData();
            ReservaModel::getInstance()->newReserva(array(
                "idCouch" => $_POST['idCouch'],
                "comentarioReserva" => $_POST['comentario'],
                "idUsuarioHospedado" => $dataSession['id'],
                "idReservaEstado" => $estado['id'],
                "fechaInicio" => $fecha_inicio[2] . "-" . $fecha_inicio[1] . "-" . $fecha_inicio[0],
                "fechaFin" => $fecha_fin[2] . "-" . $fecha_fin[1] . "-" . $fecha_fin[0],
            ));
            return json_encode(array(
                "error" => false,
            ));
        } else {
            return json_encode(array(
                "error" => true,
                "msj" => "Error de acceso."
            ));
        }
    }

}
