<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IndexController
 *
 * @author kibunke
 */
require_once(PATH_VIEW . 'IndexView.php');
require_once(PATH_MODEL . 'CouchModel.php');
require_once(PATH_CONTROLLER . 'SessionController.php');

class IndexController {

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
    private function paginador_process($pagina = 1) {
        $total = CouchModel::getInstance()->count();
        $limit = 3; //cantidad de paginas a mostrar
        $paginas = ceil($total / $limit); //cantidad de paginas en el sistema
        $offset = ($pagina - 1) * $limit;
        $couchinns = CouchModel::getInstance()->getCouchs(array(
            "limit" => $limit,
            "offset" => $offset
        ));
        return array(
            "paginas" => $paginas,
            "couchinns" => $couchinns
        );
    }

    /**
     * 
     */
    public function indexAction() {  
        $session = SessionController::getInstance();
        $dataSession = array(
            "logueado" => NULL
        );
        
        //return var_dump($_COOKIE['COUCHINN_TOKEN']);
        
        
        if ($session->isLogginAction()) {
            $dataSession = $session->getData();
        }
        
        
        $result = $this->paginador_process();
        $view = new IndexView();
        return $view->renderIndex(array(
                    "couchs" => $result['couchinns'],
                    "paginas" => $result['paginas'],
                    "pagActiva" => 1,
                    "session" => $dataSession
        ));
    }

    /**
     * 
     */
    public function ajax_paginadorAction() {
        $result = $this->paginador_process($_POST['pagina']);
        $view = new IndexView();
        $data['couchinns'] = $view->renderCouchinns(array(
            "couchs" => $result['couchinns'],
        ));
        $data['paginador'] = $view->renderPaginador(array(
            "paginas" => $result['paginas'],
            "pagActiva" => $_POST['pagina']
        ));
        echo json_encode($data);
    }

}
