<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PremiumController
 *
 * @author kibunke
 */
require_once(PATH_VIEW . 'PremiumView.php');
require_once(PATH_VIEW . 'ErrorHandlerView.php');
require_once(PATH_MODEL . 'PrecioPremiumModel.php');
require_once(PATH_CONTROLLER . 'SessionController.php');

class PremiumController {

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
    public function indexAction() {
        $session = SessionController::getInstance();
        if ($session->isLogginAction()) {
            $dataSession = $session->getData();
            $view = new PremiumView();
            return $view->renderIndex(array(
                        "session" => $dataSession
            ));
        } else {
            $view = new ErrorHandlerView();
            return $view->renderAcccesDenied();
        }
    }

}
