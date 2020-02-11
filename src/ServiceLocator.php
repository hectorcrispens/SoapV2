<?php
require_once(__DIR__ .'/interfaces/iServiceLocator.php');

class ServiceLocator implements iServiceLocator
{
    public $container=null;
    static private $instance = null; 

    function __construct($e){
        $this->container = $e;
    }

    public static function getInstance($e){
        if(self::$instance == null){
            self::$instance = new ServiceLocator($e);
        }
        return self::$instance;

    }

    function registrarComplex($server){
        foreach($this->container->lista as $clave => $valor){
            $valor->AddComplex($server);
        };

    }
    function registerMethods($server){
        foreach($this->container->lista as $clave => $valor){
         
            $valor->AddMethod($server);
        };

    }

}