<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsuarioModel
 *
 * @author kibunke
 */
require_once (PATH_MODEL . 'PDORepository.php');

class UsuarioModel extends PDORepository {

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
    public function newUsuario($parameters) {
        return $this->insert("usuario", $parameters);
    }

    /**
     * 
     */
    public function getByIdToken($parameters) {
        $result = $this->select(""
                . "SELECT u.idUsuario AS idUsuario, u.email AS email, u.password AS password, u.identificador AS identificador, u.token AS token, p.nombre AS nombre, p.apellido AS apellido, tu.nombreTipo AS tipo "
                . "FROM usuario AS u "
                . "INNER JOIN tipousuario AS tu ON tu.idTipoUsuario = u.idTipoUsuario "
                . "INNER JOIN persona AS p ON p.idPersona = u.idPersona "
                . "WHERE u.bajaLogica = 0 AND tu.bajaLogica = 0 AND p.bajaLogica = 0 AND u.identificador = :identificador AND u.token = :token", $parameters);
        if (count($result) > 0) {
            return reset($result);
        } else {
            return FALSE;
        }
    }

    /**
     * 
     */
    public function existEmail($email) {
        $result = $this->select(""
                . "SELECT * "
                . "FROM usuario "
                . "WHERE email = :email AND bajaLogica = 0", array("email" => $email));
        return (count($result) > 0) ? TRUE : FALSE;
    }

    /**
     * 
     */
    public function getUsuario($parameters) {
        $result = $this->select(""
                . "SELECT u.idUsuario AS idUsuario, u.email AS email, u.password AS password, u.identificador AS identificador, u.token AS token, p.nombre AS nombre, p.apellido AS apellido, tu.nombreTipo AS tipo "
                . "FROM usuario AS u "
                . "INNER JOIN tipousuario AS tu ON tu.idTipoUsuario = u.idTipoUsuario "
                . "INNER JOIN persona AS p ON p.idPersona = u.idPersona "
                . "WHERE u.bajaLogica = 0 AND tu.bajaLogica = 0 AND p.bajaLogica = 0 AND u.email = :email AND u.password = :password", $parameters);
        if (count($result) > 0) {
            return reset($result);
        } else {
            return FALSE;
        }
    }

    /**
     * 
     */
    public function getById($idUsuario) {
        $result = $this->select(""
                . "SELECT u.idUsuario AS idUsuario, u.email AS email, u.password AS password, u.identificador AS identificador, u.token AS token, p.nombre AS nombre, p.apellido AS apellido, tu.nombreTipo AS tipo "
                . "FROM usuario AS u "
                . "INNER JOIN tipousuario AS tu ON tu.idTipoUsuario = u.idTipoUsuario "
                . "INNER JOIN persona AS p ON p.idPersona = u.idPersona "
                . "WHERE u.bajaLogica = 0 AND tu.bajaLogica = 0 AND p.bajaLogica = 0 AND u.idUsuario = :idUsuario", array('idUsuario' => $idUsuario));
        if (count($result) > 0) {
            return reset($result);
        } else {
            return FALSE;
        }
    }

    private function updateU($table, $data, $id) {
        ksort($data);
        $columnas = array_keys($data);
        foreach ($columnas as $key => $value) {
            $columnas[$key] = $value . ' = :' . $value;
        }
        $str = implode(' , ', array_values($columnas));
        $connection = $this->getConnection();
        $sth = $connection->prepare("UPDATE $table SET $str WHERE idUsuario = :id");
        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }
        $sth->bindValue(':id', $id);
        
        //return $sth->debugDumpParams();
        
        
        return $sth->execute();
    }
    
    /**
     * 
     */
    public function updateUsuario($id, $data) {
        return $this->updateU("usuario", $data, $id);
    }

}
