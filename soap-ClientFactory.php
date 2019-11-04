<?php
class FactorySoapClient{
  private $servicios;
  function __construct(){
    $setting = require __DIR__.'/config/settings.php';
    $setting($this);
  }
   function addDefinitions($arr)
   {
     $this->servicios = $arr;
   }

   function getClient($clave){
     //return new SoapClient($this->servicios[$clave], array("trace" => 1, "exception" => 0));
     return new SoapClient($this->servicios[$clave], array('trace' => 1, 'exceptions' => 0));
   }
}
