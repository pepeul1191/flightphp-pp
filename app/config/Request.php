<?php

class Request{
    private $_modulo;
    private $_controlador;
    private $_metodo;
    private $_argumentos;
    private $_modules;
    public $_url;
    public $_params;

    public function __construct($url, $params)
    {
        $this->_url = $url;
        $this->_params = $params;
        //var_dump($this->_url);exit();
        if(isset($this->_url)){
            //$url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            $url = array_filter($url);
            //exit();
            /*En este arreglo deben ir los módulos que tenga la aplicación*/

            $this->_modules = array('');
            //1. modulo/controlador/metodo/argumento
            //2. controlador/metodo/argumento

            $this->_modulo = strtolower(array_shift($url));

            if(!$this->_modulo){
                $this->_modulo = false;
            }else{
                if(count($this->_modules)){
                    if(!in_array($this->_modulo,$this->_modules)){
                        $this->_controlador = $this->_modulo;
                        $this->_modulo = false;
                    }else{
                        $this->_controlador = strtolower(array_shift($url));
                        if(!$this->_controlador){
                            $this->_controlador = 'index';
                        }
                    }
                }else{
                    $this->_controlador = $this->_modulo;
                    $this->_modulo = false;
                }
            }

            $this->_metodo = strtolower(array_shift($url));

            if(!empty($url)){
              $this->_argumentos = $url;
            }

        }
    }

    public function get_modulo()
    {
        return $this->_modulo;
    }

    public function get_controlador()
    {
        return $this->_controlador;
    }

    public function get_metodo()
    {
        return $this->_metodo;
    }

    public function get_args()
    {
        return $this->_argumentos;
    }

    public function get_params()
    {
        return $this->_params;
    }
}

?>
