<?php

ini_set('display_errors',1);

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)) . DS . 'app' . DS);
define('APP_PATH', ROOT . 'config' . DS);

require 'vendor/autoload.php';

Flight::route('/', function(){
    header('Content-Type: text/html; charset=utf-8');
    echo 'Error : URL vacía';
});

Flight::route('/hello/@nombre', function($nombre){
    echo 'hello ' . $nombre . '!';
});

Flight::route('/*', function(){
        try{
            require_once APP_PATH . 'Config.php';
            require_once APP_PATH . 'Request.php';
            require_once APP_PATH . 'Bootstrap.php';
            require_once APP_PATH . 'Controller.php';
            require_once APP_PATH . 'Model.php';
            require_once APP_PATH . 'Database.php';

            $request = Flight::request();
            //var_dump($request);var_dump($request->query);
            $base_request = explode( '?', $request->url)[0];
            $parametros_request = $request->query;

            Bootstrap::run(new Request($base_request, $parametros_request));
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
});

Flight::route('notFound', function(){
    // Display custom 404 page
    echo 'errors/404.html';
});

Flight::start();

?>
