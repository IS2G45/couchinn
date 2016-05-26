<?php

require_once(PATH_VIEW . 'TwigView.php');

class InterfacesView extends TwigView {

    public function renderIndex($parameters = array()) {
        echo self::getTwig()->render('index.html.twig', $parameters);
    }
    
    public function renderLayout($parameters = array()) {
        echo self::getTwig()->render('template.html.twig', $parameters);
    }
    
    public function renderRegister($parameters = array()) {
        echo self::getTwig()->render('register.html.twig', $parameters);
    }
    
    public function renderNewCouch($parameters = array()) {
        echo self::getTwig()->render('newcouch.html.twig', $parameters);
    }
}
