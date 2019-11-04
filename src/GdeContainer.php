<?php
require_once(__DIR__ .'/interfaces/iContainerIterator.php');
require __DIR__ .'/Clases/DatosExpedientePorCodigosDeTrata.php';
require __DIR__ .'/Clases/BaseClass.php';
require __DIR__ .'/Clases/Expose.php';
require __DIR__ .'/Clases/HistorialDePasesDeExpediente.php';
require __DIR__ .'/Clases/EEDetallado.php';
require __DIR__ .'/Clases/DocumentoPorNumero.php';
require __DIR__ .'/Clases/TransaccionPorUUID.php';

class GdeContainer implements iContainerIterator
{
    public $lista = null;
    private $iterator = 0;

    public function __construct(){
        $this->lista = array(
            "baseService" => new BaseClass(),
            "DatosPorCodigoTrataService" => new DatosExpedientePorCodigosDeTrata(),
            "ExposeService" => new Expose(),
            "HistorialDePases" => new HistorialDePasesDeExpediente(),
            "CEEDetallado" => new EEDetallado(),
            "DocumentoPorNumero" => new DocumentoPorNumero(),
            "TransaccionPorUUID" => new TransaccionPorUUID()
        );
    }

    public function getService($name){
        return $this->lista[$name];
    }

}