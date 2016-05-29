<?php

require_once(PATH_VIEW . 'TwigView.php');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ErrorHandlerView
 *
 * @author kibunke
 */
class ErrorHandlerView extends TwigView {

    /**
     * Muestra la página para crear un nuevo couch
     */
    public function renderAcccesDenied($parameters = array()) {
      //  echo self::getTwig()->render('newcouch.html.twig', $parameters);
    }
    
    /**
     * Muestra la página de error al no encotnrar un objeto requerido
     */
    public function renderNotFound() {
        echo self::getTwig()->render('notfound.html.twig');
    }

}
