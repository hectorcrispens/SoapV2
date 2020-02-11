<?php
class HistorialDePasesDTO
{
    public $documentosVinculados = null;
    public $expedientesAsociados = null;
    public $expedientesFusionAsociados = null;
    public $expedientesVinculados = null;
    public $historialDeOperacion = null;
   
    public function __construct(){
        $this->documentosVinculados = array();
        $this->expedientesAsociados = array();
        $this->expedientesFusionAsociados = array();
        $this->expedientesVinculados = array();
        $this->historialDeOperacion = array();
   
    }
}