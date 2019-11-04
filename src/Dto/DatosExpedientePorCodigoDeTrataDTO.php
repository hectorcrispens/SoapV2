<?php
class DatosExpedientePorCodigoDeTrataDTO{

    public $codigoDocCaratula = '';
    public $codigoEE = '';
    public $codigotrata = '';
    public $descripcionTrata = '';
    public $estado = '';
    public $listArchivosAdjuntos = null;
    public $listDocumentosOficiales = null;
    public $listExpedientesAsociados = null;
    public $listaDatosTarea = null;
    
    
    public function __construct(){
        $this->listaDatosTarea = array();
        $this->listArchivosAdjuntos = array();
        $this->listDocumentosOficiales = array();
        $this->listExpedientesAsociados = array(); 
    }
    }