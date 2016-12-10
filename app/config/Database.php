<?php

class Database extends PDO
{
    public function __construct() {
        try{ 
           parent::__construct(
               'mysql:host=' . 'localhost' .
               ';dbname=' . 'db_chamba',
               'root', 
               '123', 
               array(
               PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . 'utf8'
           ));
       }catch(Exception $e){
          echo "Verifique los parámetros de conección";
       }
    }
}

?>
