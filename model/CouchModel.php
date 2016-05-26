<?php

require_once (PATH_MODEL . 'PDORepository.php');

class CouchModel extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Inserta un couch en la Base de Datos
     */
    public function newCouch($parameters) {
        return $this->insert("couch", $parameters);
    }
    
    /**
     * Se obtienen todos los tipos de Couch activos (no borrados)
     */
    public function  getTipos(){
        return $this->select("SELECT * FROM tipocouch WHERE bajaLogica = 0 ORDER BY nombre ASC");
    }
    
    /**
     * Se obtienen todas las provinicas activas (no borradas)
     */
    public function getProvincias(){
        return $this->select("SELECT * FROM provincia WHERE bajaLogica = 0 ORDER BY nombre ASC");
    }
    
    /**
     * Se obtienen todas las ciudades activas (no borradas) que perteneces a una provincia que se especifica como parámetro 
     */
    public function getCiudades($parameters){
        return $this->select("SELECT * FROM provincia_ciudad INNER JOIN ciudad ON ciudad.idCiudad = provincia_ciudad.id_ciudad WHERE ciudad.bajaLogica = 0 AND provincia_ciudad.id_provincia = :id_provincia ORDER BY ciudad.nombre ASC", $parameters);
    }
}
