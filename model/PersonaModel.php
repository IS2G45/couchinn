<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PersonaModel
 *
 * @author kibunke
 */
require_once (PATH_MODEL . 'PDORepository.php');

class PersonaModel extends PDORepository {

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
    public function newPersona($parameters) {
        return $this->insert("persona", $parameters);
    }

}
