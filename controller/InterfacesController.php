<?php

require_once(PATH_VIEW . 'InterfacesView.php');

class InterfacesController {

    private static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function indexAction() {
        $view = new InterfacesView();
        return $view->renderIndex();
    }

    public function layoutAction() {
        $view = new InterfacesView();
        return $view->renderLayout();
    }

    public function registerAction() {
        $view = new InterfacesView();
        return $view->renderRegister();
    }
    public function newCouchAction() {
        $view = new InterfacesView();
        return $view->renderNewCouch();
    }

}
