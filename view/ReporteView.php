<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReporteView
 *
 * @author kibunke
 */
require_once(PATH_VIEW . 'TwigView.php');

class ReporteView extends TwigView {

    /**
     * 
     */
    public function renderReporteSolicitudesAceptadas($parameters = array()) {
        echo self::getTwig()->render('reporte_solicitudesAceptadas.html.twig', $parameters);
    }
    
    /**
     * 
     */
    public function renderReporteSolicitudesAceptadasResult($parameters = array()) {
        echo self::getTwig()->render('reporte_solicitudesAceptadasResult.html.twig', $parameters);
    }
}