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
     * 
     */
    public function getCouchById($parameters) {
        $result = $this->select(""
                . "SELECT couch.titulo, couch.descripcion, couch.capacidad, couch.foto, couch.idUsuario, tc.nombre AS tipo, p.nombre AS provincia, c.nombre AS ciudad "
                . "FROM couch "
                . "INNER JOIN tipocouch AS tc ON tc.idTipoCouch = couch.idTipoCouch "
                . "INNER JOIN provincia_ciudad AS p_c ON  p_c.id_ciudad = couch.idCiudad "
                . "INNER JOIN provincia AS p ON p.id = p_c.id_provincia "
                . "INNER JOIN ciudad AS c ON c.idCiudad = p_c.id_ciudad "
                . "WHERE couch.idCouch = :idCouch AND couch.bajaLogica = 0 AND c.bajaLogica = 0 AND p.bajaLogica = 0", $parameters);
        if (count($result) > 0) {
            $couch = reset($result); //retorna el primer elemento del arreglo;
            $couch['foto'] = base64_encode($couch["foto"]);
            return $couch;
        } else {
            return false;
        }
    }

    /**
     * Se obtienen todos los tipos de Couch activos (no borrados)
     */
    public function getTipos() {
        return $this->select("SELECT * FROM tipocouch WHERE bajaLogica = 0 ORDER BY nombre ASC");
    }

    /**
     * Se obtienen todas las provinicas activas (no borradas)
     */
    public function getProvincias() {
        return $this->select("SELECT * FROM provincia WHERE bajaLogica = 0 ORDER BY nombre ASC");
    }

    /**
     * Se obtienen todas las ciudades activas (no borradas) que perteneces a una provincia que se especifica como parámetro 
     */
    public function getCiudades($parameters) {
        return $this->select("SELECT * FROM provincia_ciudad INNER JOIN ciudad ON ciudad.idCiudad = provincia_ciudad.id_ciudad WHERE ciudad.bajaLogica = 0 AND provincia_ciudad.id_provincia = :id_provincia ORDER BY ciudad.nombre ASC", $parameters);
    }

}
