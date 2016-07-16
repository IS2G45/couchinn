<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReporteModel
 *
 * @author kibunke
 */
require_once (PATH_MODEL . 'PDORepository.php');

class ReporteModel extends PDORepository {

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
    public function reservasRealizadas($fechaIni, $fechaFin) {
        return $this->select("SELECT p.nombre, p.apellido, c.titulo, r.idReserva, r.idCouch, r.idUsuarioHospedado, r.idReservaEstado, r.fechaInicio, r.fechaFin, r.comentarioUsuario, r.comentarioReserva, r.comentarioCouch, r.puntajeCouch, r.puntajeUsuario, r.fechaAlta, r.bajaLogica, re.nombre AS estado "
                        . "FROM reserva AS r "
                        . "INNER JOIN reservaestado AS re ON r.idReservaEstado = re.id "
                        . "INNER JOIN couch AS c ON c.idCouch = r.idCouch "
                        . "INNER JOIN usuario AS u ON u.idUsuario = r.idUsuarioHospedado "
                        . "INNER JOIN persona AS p ON u.idPersona = p.idPersona "
                        . "WHERE r.fechaAlta >= CAST(:fechaInicio AS DATE) AND r.fechaAlta <= CAST(:fechaFin AS DATE) "
                        . "ORDER BY r.fechaAlta DESC ", array(
                    "fechaInicio" => $fechaIni,
                    "fechaFin" => $fechaFin
        ));
    }

}
