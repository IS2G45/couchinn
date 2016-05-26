<?php

require_once(PATH_VIEW . 'TwigView.php');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CouchView
 *
 * @author kibunke
 */
class CouchView extends TwigView {

    /**
     * Muestra la página para crear un nuevo couch
     */
    public function renderNew($parameters = array()) {
        echo self::getTwig()->render('newcouch.html.twig', $parameters);
    }

    /**
     * Muestra las opciones de un campo select de ciudades de una provincia
     */
    public function renderCiudades($parameters = array()) {
        echo self::getTwig()->render('ciudades.html.twig', $parameters);
    }

}
