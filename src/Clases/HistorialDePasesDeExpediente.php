<?php

require_once(__DIR__ .'/../interfaces/iNucleoEntidad.php');
require __DIR__ .'/../Dto/HistorialDePasesDTO.php';

class HistorialDePasesDeExpediente implements iNucleoEntidad{
/**
 *  Implement ComplexType struc Data
 */
  function AddComplex($server){
    $server->wsdl->addComplexType(
        'documentoVinculado',
        'complexType',
        'struct',
        'all',
        '',
        array(
            'fechaCreacion' => array('name' => 'fechaCreacion', 'type' => 'xsd:string'),
            'fechavinculacionDefinitiva' => array('name' => 'fechavinculacionDefinitiva', 'type' => 'xsd:string'),
            'numeroEspecialDocumento' => array('name' => 'numeroEspecialDocumento', 'type' => 'xsd:string'),
            'numeroSadeDocumento' => array('name' => 'numeroSadeDocumento', 'type' => 'xsd:string'),
            'referencia' => array('name' => 'referencia', 'type' => 'xsd:string'),
            'tipodeDocumento' => array('name' => 'tipoDocumento', 'type' => 'xsd:string'),
            'usuarioAsociacion' => array('name' => 'usuarioAsociacion', 'type' => 'xsd:string'),
            'usuarioGenerador' => array('name' => 'usuarioGenerador', 'type' => 'xsd:string')
        
        ));
        $server->wsdl->addComplexType(
            'expedienteAsociado',
            'complexType',
            'struct',
            'all',
            '',
            array(
               'none' => array('name' => 'none', 'type' => 'xsd:string')
            
            ));
        $server->wsdl->addComplexType(
            'expedienteFusionAsociado',
            'complexType',
            'struct',
            'all',
            '',
            array(
               'none' => array('name' => 'none', 'type' => 'xsd:string')
            ));
        $server->wsdl->addComplexType(
            'expedienteVinculado',
            'complexType',
            'struct',
            'all',
            '',
            array(
               'none' => array('name' => 'none', 'type' => 'xsd:string')
            ));
        $server->wsdl->addComplexType(
            'historialDeOperacion',
            'complexType',
            'struct',
            'all',
            '',
            array(
               'destinatario' => array('name' => 'destinatario', 'type' => 'xsd:string'),
               'estado' => array('name' => 'estado', 'type' => 'xsd:string'),
               'expediente' => array('name' => 'expediente', 'type' => 'xsd:string'),
               'fechaOperacion' => array('name' => 'fechaOperacion', 'type' => 'xsd:string'),
               'idExpediente' => array('name' => 'idExpediente', 'type' => 'xsd:string'),
               'motivo' => array('name' => 'motivo', 'type' => 'xsd:string'),
               'tipoOperacion' => array('name' => 'tipoOperacion', 'type' => 'xsd:string'),
               'usuario' => array('name' => 'usuario', 'type' => 'xsd:string')
            ));
   
        $server->wsdl->addComplexType(
            'documentosVinculadosArray',
            'complexType',
            'array',
            '',
            'SOAP-ENC:Array',
            array(),
            array(
                array(
                    'ref' => 'SOAP-ENC:arrayType',
                    'wsdl:arrayType' => 'tns:documentoVinculado[]'
                )
            ),
            'tns:documentoVinculado'
        );
        $server->wsdl->addComplexType(
            'expedientesAsociadosArray',
            'complexType',
            'array',
            '',
            'SOAP-ENC:Array',
            array(),
            array(
                array(
                    'ref' => 'SOAP-ENC:arrayType',
                    'wsdl:arrayType' => 'tns:expedienteAsociado[]'
                )
            ),
            'tns:expedienteAsociado'
        );
        $server->wsdl->addComplexType(
            'expedientesFusionAsociadosArray',
            'complexType',
            'array',
            '',
            'SOAP-ENC:Array',
            array(),
            array(
                array(
                    'ref' => 'SOAP-ENC:arrayType',
                    'wsdl:arrayType' => 'tns:expedienteFusionAsociado[]'
                )
            ),
            'tns:expedienteFusionAsociado'
        );
        $server->wsdl->addComplexType(
            'expedientesVinculadosArray',
            'complexType',
            'array',
            '',
            'SOAP-ENC:Array',
            array(),
            array(
                array(
                    'ref' => 'SOAP-ENC:arrayType',
                    'wsdl:arrayType' => 'tns:expedienteVinculado[]'
                )
            ),
            'tns:expedienteVinculado'
        );
        $server->wsdl->addComplexType(
            'historialDeOperacionArray',
            'complexType',
            'array',
            '',
            'SOAP-ENC:Array',
            array(),
            array(
                array(
                    'ref' => 'SOAP-ENC:arrayType',
                    'wsdl:arrayType' => 'tns:historialDeOperacion[]'
                )
            ),
            'tns:historialDeOperacion'
        );
        $server->wsdl->addComplexType(
            'HistorialDePasesDeExpediente',
            'complexType',
            'struct',
            'all',
            '',
            array(
                'documentosVinculados' => array('type' => 'tns:documentosVinculadosArray'),
                'expedientesAsociados' => array('type' => 'tns:expedientesAsociadosArray'),
                'expedientesFusionAsociados' => array('type' => 'tns:expedientesFusionAsociadosArray'),
                'expedientesVinculados' => array('type' => 'tns:expedientesVinculadosArray'),
                'historialDeOperacion' => array('type' => 'tns:historialDeOperacionArray')
            )
        );
        return;
   
  }

  /**
   * ADD method to Server-Soap
   */
  function AddMethod($server){
    $server->register('obtenerHistorialDePasesDeExpediente',    
    array(
        'codigoEE' => 'xsd:string'),
    array('return' => 'tns:HistorialDePasesDeExpediente'),
    'urn:idu',    // namespace
    '',            // soapaction
    '',                                    // style
    '',                                // use
    'Copyright by Hector Orlando Crispens'        // documentation
);
return;
    

  }


  /**
   * Execute Command
   */
function execute($codigo)
{ 
   /**
     * Preparamos la base de datos y storeamos los datos ingresados en el request 
     * */    
    
    $req_trace = R::dispense('tracerequest');
    $req_trace->method = "obtenerHistorialDePasesDeExpediente";
    $req_trace->jsonRequest= "{'codigoEE' => '".$codigo."'}";
    $req_trace->fecha = "".date('Y-m-d H:i:s');
    $id_reg = R::store($req_trace);

     /**
     * Creamos una instancia de FactorySoapClient y pedimos un SoapClient con la clave que identifica al WSDL de GDE
     * llamamos al servicio de GDE
     */
    
    $factory = new FactorySoapClient();
    $client = $factory->getClient("consultaGDE");

   // Call wsdl function
    $result = $client->obtenerHistorialDePasesDeExpediente(array(
    "codigoEE" => $codigo));

    if (is_soap_fault($result)) {
    
      $res_trace = R::dispense('traceresponse');
      $res_trace->idRequest = $id_reg;
      $res_trace->jsonResponse = "{'SOAP Fault': {'faultcode': '{$result->faultcode}', 'faultstring': '{$result->faultstring}'}}";
      $res_trace->fecha = "".date('Y-m-d H:i:s');
  
      R::store($res_trace);
     return $result;  
  }

  
  $json = json_encode($result->{"return"});
  /**
    * Guardamos en la base de datos el response
    */
 
  $response = json_decode($json);
  $res_trace = R::dispense('traceresponse');
  $res_trace->idRequest = $id_reg;
  $res_trace->jsonResponse = $json;
  $res_trace->fecha = "".date('Y-m-d H:i:s');
  $idResponse = R::store($res_trace);


$re = new HistorialDePasesDTO();

/**
 * Documentos Vinculados
 */



foreach($response->documentosVinculados as $e){
    $numEsp = null;
    $tipoD = null;

if(array_key_exists("numeroEspecialDocumento", $e)){
$numEsp = $e->numeroEspecialDocumento;
}
if(array_key_exists("tipoDocumento", $e)){
    $tipoD = $e->tipoDocumento;
    }
array_push($re->documentosVinculados, array(
  "fechaCreacion" => $e->fechaCreacion,
  "fechavinculacionDefinitiva" => $e->fechavinculacionDefinitiva,
  "numeroEspecialDocumento" => $numEsp,
  "numeroSadeDocumento" => $e->numeroSadeDocumento,
  "referencia" => $e->referencia,
  "tipodeDocumento" => $tipoD,
  "usuarioAsociacion" => $e->usuarioAsociacion,
  "usuarioGenerador" => $e->usuarioGenerador

));
}

/**
 * Expedientes Asociados
 */
/*
$value = $response->expedientesAsociados;
foreach($value as $documentoV){
array_push($this->expedientesAsociados, $documentoV);
}

/**
 * Documentos Fusion Asociados
 */
/*
$value = $response->expedientesFusionAsociados;
foreach($value as $documentoV){
array_push($this->expedientesFusionAsociados, $documentoV);
}

/**
 * Expedientes Vinculados
 */
/*
$value = $response->expedientesVinculados;
foreach($value as $documentoV){
array_push($this->expedientesVinculados, $documentoV);
}

/**
 * Historial de Operacion
 */


foreach($response->historialDeOperacion as $e){
array_push($re->historialDeOperacion, array(
  "destinatario" => $e->destinatario,
  "estado" => $e->estado,
  "expediente" => $e->expediente,
  "fechaOperacion" => $e->fechaOperacion,
  "idExpediente" => $e->idExpediente,
  "motivo" => $e->motivo,
  "tipoOperacion" => $e->tipoOperacion,
  "usuario" => $e->usuario
));
}




return $re;
}

}
