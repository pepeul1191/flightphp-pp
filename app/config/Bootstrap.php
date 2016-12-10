<?php

class Bootstrap
{
    public static function run(Request $peticion)
    {
        $modulo = $peticion->get_modulo();
        $controller = $peticion->get_controlador() . 'Controller';
        $ruta_controlador = ROOT . 'controllers' . DS . $controller . '.php';
        $metodo = $peticion->get_metodo();
        $args = $peticion->get_args();
        //var_dump($peticion);var_dump($ruta_controlador);
        try{
            if(!file_exists($ruta_controlador)){
              throw new Exception('Error, no existe el controlador ' . $controller);
            }else{
              require_once $ruta_controlador;
            }

            if($metodo == null){
              throw new Exception('Error no hay método definido en el controlador ' . $controller);
            }

            $controllerInstacia = new $controller($peticion);

            if(!method_exists($controllerInstacia, $metodo)){
              unset($controllerInstacia);
              throw new Exception('Error no existe el método ' . $metodo . ' definido en el controlador ' . $controller);
            }

            if(isset($args)){
                $classMethod = new ReflectionMethod($controllerInstacia,$metodo);
                $argumentCount = count($classMethod->getParameters());
                if($argumentCount == count($args)){
                    call_user_func_array(array($controllerInstacia, $metodo), $args);
                }else{
                  unset($controllerInstacia);
                    throw new Exception('El número de parámetros no coinciden en el  método ' . $metodo . ' definido en el controlador ' . $controller);
                }
            }else{
                call_user_func(array($controllerInstacia, $metodo));
            }
        }catch (Exception $e) {
            header('Content-Type: text/html; charset=utf-8');
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }

    }
}

?>
