<?php

class Session {

    static function init() {
        @session_start();
    }

    static function destroy() {
        session_destroy();
    }

    static function getValue($var) {
        return ($_SESSION[$var]);
    }

    static function setValue($var, $val) {
        $_SESSION[$var] = $val;
    }

    static function getRol() {
        if (sizeof($_SESSION) > 0 && $_SESSION['ROL'] != '') {
            return $_SESSION['ROL'];
        } else {
            return false;
        }
    }

    static function unsetValue($var) {
        if (isset($_SESSION[$var])) {
            unset($_SESSION[$var]);
        }
    }

    static function getSession() {
        return $_SESSION;
    }

    static function exist() {
        Session::init();
        if (sizeof($_SESSION) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 
     */
    static function tieneAcceso($roles) {
        Session::init();
        //Si no hay session creada o no esta bien definida con el rol cargado se dirige a una pantalla de error
        if (!(Session::exist() && Session::getRol())) {
            $view = new ErrorPage();
            return $view->show(array('mensaje' => 'Aceeso denegado', 'urlBack' => ROOT_URL . "index.php?action=login"));
        }
        $rolePerteneciente = Session::getRol();
        $hasrole = false;
        //se busca en el arreglo de roles si se encuentra el rol del usuario logueado en el sistema
        foreach ($roles as $role) {
            if ($role === $rolePerteneciente) {
                $hasrole = true;
            }
        }
        if (!$hasrole) {
            //Redirige a la página de error ya que  el usuario logueado no tiene alguno de los roles que se recibió como parámetros
            $view = new ErrorPage();
            return $view->show(array('mensaje' => 'Aceeso denegado', 'urlBack' => ROOT_URL . "index.php?action=login"));
        } else {
            return true;
        }
    }

}
