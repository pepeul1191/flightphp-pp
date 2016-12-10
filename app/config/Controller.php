<?php

abstract class Controller
{
    protected $_request;

    public function __construct($peticion)
    {
        $this->_request = $peticion;
    }

    //abstract public function index();

    protected function load_model($modelo,$modulo = false)
    {
        $modelo = $modelo . 'Model';
        $ruta_modelo = ROOT . 'models' . DS . $modelo . '.php';

        if(!$modulo){
            $modulo = $this->_request->get_modulo();
        }

        if($modulo){
            if($modulo != 'default'){
                $ruta_modelo = ROOT . 'modules' . DS . $modulo . DS . 'models' . DS . $modelo . '.php';
            }
        }
        //var_dump($ruta_modelo);
        if(is_readable($ruta_modelo)){
            require_once $ruta_modelo;
            $modelo = new $modelo;
            return $modelo;
        }
        else {
            throw new Exception('Error de modelo');
        }
    }

    protected function load_controller($controlador,$modulo = false)
    {
        $controlador = $controlador . 'Controller';
        $ruta_controlador = ROOT . 'controllers' . DS . $controlador . '.php';

        //var_dump($ruta_controlador);

        if(!$modulo){
            $modulo = $this->_request->get_modulo();
        }
        //var_dump($modulo);
        if($modulo){
            if($modulo != 'default'){
                $ruta_controlador = ROOT . 'modules' . DS . $modulo . DS . 'controllers' . DS . $controlador . '.php';
            }
        }
        //var_dump($ruta_controlador);
        if(is_readable($ruta_controlador)){
            require_once $ruta_controlador;
            $controllerInstacia = new $controlador($this->_request);
            //$controlador = new $controlador;
            return $controllerInstacia;
        }
        else {
            throw new Exception('Error, controlador a cargar dinámicamente no existe');
        }
    }

    protected function get_library($libreria)
    {
        $ruta_libreria = ROOT . 'libs' . DS . $libreria . '.php';

        if(is_readable($ruta_libreria)){
            require_once $ruta_libreria;
        }
        else{
            throw new Exception('Error de libreria');
        }
    }

    protected function get_param($clave)
    {
        if(isset($this->_request->get_params()[$clave])){
            return $this->_request->get_params()[$clave];
        }
    }
}

?>
