<?php
class EEDetalladoDTO
{
    public $codigoDocCaratula = null;
    public $codigoEE = null;
    public $codigotrata = null;
    public $descripcionTrata = null;
    public $estado = null;
    public $listArchivosAdjuntos = null;
    public $listDocumentosOficiales = null;
    public $listExpedientesAsociados = null;
    public $listaDatosTarea = null;
    public $motivo = null;
    public $sistemaOrigen = null;
    public $datoVariable = null;
    public $descripcionTramite = null;
    public $f_caratulacion = null;
    public $listaExpedientesAsociados = null;
    public $listaExpedientesAsociadosFusion = null;
    public $listaExpedientesAsociadosTC = null;
    public $sectorDestino = null;
    public $usuarioCaratulador = null;
    public $usuarioDestino = null;

    public function __construct(){
        $this->listArchivosAdjuntos = array();
        $this->listDocumentosOficiales = array();
        $this->listExpedientesAsociados = array();
        $this->listaDatosTarea = array();
        $this->datoVariable = array();
        $this->listaExpedientesAsociados = array();
        $this->listaExpedientesAsociadosFusion = array();
        $this->listaExpedientesAsociadosTC = array();
    }
}