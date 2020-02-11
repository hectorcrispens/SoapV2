<?php

class valorFormCompsDTO{
    public $etiqueta = "";
    public $id = "";
   /* public $idFormComp = "";
    public $inputName = "";
    public $orden = "";
    public $ordenInterno = "";
    public $relevanciaBusqueda = "";
    public $separadorRepetidor = "";
    public $valorBlob = "";
    public $valorBoolean = "";
    public $valorDate = "";
    public $valorDouble = "";
    public $valorLong = "";
    public $valorStr = "";*/

    function __construct($a)
    {
        $this->etiqueta = $a["etiqueta"];
        $this->id = $a["id"];
      /*  $this->idFormComp = $a["idFormComp"];
        $this->inputName = $a["inputName"];
        $this->orden = $a["orden"];
        $this->ordenInterno = $a["ordenInterno"];
        $this->relevanciaBusqueda = $a["relevanciaBusqueda"];
        $this->separadorRepetidor = $a["separadorRepetidor"];
        $this->valorBlob = $a["valorBlob"];
        $this->valorBoolean = $a["valorBoolean"];
        $this->valorDate = $a["valorDate"];
        $this->valorDouble = $a["valorDouble"];
        $this->valorLong = $a["valorLong"];
        $this->valorStr = $a["valorStr"];*/
    }
}
class TransaccionPorUUIDDTO
{
    public $estadoVisibilidad = "";
    public $fechaCreacion = "";
    public $nombreFormulario = "";
    public $sistOrigen = "";
    public $uuid = "";
    public $valorFormComps = null;

    public function __construct()
    {
       $this->valorFormComps = array();
    }
}