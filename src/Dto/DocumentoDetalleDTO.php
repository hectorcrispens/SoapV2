<?php

class DocumentoDetalleDTO{
    public $datosPropios = null;
    public $fechaCreacion = '';
    public $listaArchivosDeTrabajo = null;
    public $listaFirmantes = null;
    public $listaHistorial = null;
    public $numeroEspecial = '';
    public $numeroSade = '';
    public $puedeVerDocumento = false;
    public $referencia = '';
    public $tipoDocumento = '';
    public $urlArchivo = '';
  

    function __construct()
    {
        $this->datosPropios = array();
        $this->listaArchivosDeTrabajo = array();
        $this->listaHistorial = array();
        $this->listaFirmantes = array();

    }
}

class listaHistorialDTO{
    public $actividad = '';
    public $fechaFin = '';
    public $fechaInicio = '';
    public $id ;
    public $mensaje = '';
    public $userName = '';
    public $usuario = '';
    public $workflowOrigen = '';

    function __construct()
    {
        $this->actividad = "actividad";
        $this->fechaFin = "fecha Fin";
        $this->fechaInicio = "fecha inicio";
        $this->id = 1234;
        $this->mensaje = "welcome to world";
        $this->userName = "your username";
        $this->usuario = "usuario";
        $this->workflowOrigen ="workflow";
    }
}