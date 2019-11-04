<?php
require __DIR__ .'/../Dto/DatosExpedientePorCodigoDeTrataDTO.php';
require_once __DIR__ .'/../interfaces/iNucleoEntidad.php';

class DatosExpedientePorCodigosDeTrata implements iNucleoEntidad{
  function AddComplex($server){
    /**
         *  arrays no completados
         */
        $server->wsdl->addComplexType(
          'arraylistArchivosAdjuntos',
          'complexType',
          'array',
          '',
          'SOAP-ENC:Array',
          array(),
          array(
              array(
                  'ref' => 'SOAP-ENC:arrayType',
                  'wsdl:arrayType' => 'tns:uno[]'
              )
          ),
          'tns:uno'
      );
      $server->wsdl->addComplexType(
          'arrayDocumentosOficiales',
          'complexType',
          'array',
          '',
          'SOAP-ENC:Array',
          array(),
          array(
              array(
                  'ref' => 'SOAP-ENC:arrayType',
                  'wsdl:arrayType' => 'tns:uno[]'
              )
          ),
          'tns:uno'
      );
      $server->wsdl->addComplexType(
          'arrayExpedientesAsociados',
          'complexType',
          'array',
          '',
          'SOAP-ENC:Array',
          array(),
          array(
              array(
                  'ref' => 'SOAP-ENC:arrayType',
                  'wsdl:arrayType' => 'tns:uno[]'
              )
          ),
          'tns:uno'
      );

       /**
        * arrays end
        */
      
      $server->wsdl->addComplexType(
          'consultaExpedienteObjeto',
          'complexType',
          'struct',
          'all',
          '',
          array(
              "codigoDocCaratula" => array("name" => "codigoDocCaratula", "type" => "xsd:string"),
              "codigoEE" => array("name" => "codigoEE", "type" => "xsd:string"),
              "codigotrata" => array("name" => "codigotrata", "type" => "xsd:string"),
              "descripcionTrata" => array("name" => "descripcionTrata", "type" => "xsd:string"),
              "estado" => array("name" => "estado", "type" => "xsd:string"),
              "listArchivosAdjuntos" => array("type" => "tns:arraylistArchivosAdjuntos"),
              "listDocumentosOficiales" => array("type" => "tns:arrayDocumentosOficiales"),
              "listExpedientesAsociados" => array("type" => "tns:arrayExpedientesAsociados"),
              "listaDatosTarea" => array('type' => 'tns:arrayConsultaExp')
              
          )
      );
      return;
  }
  function AddMethod($server){
    $server->register('consultarDatosExpedientePorCodigosDeTrata',    
    array(
        'listaDeCodigosTrata' => 'xsd:string',
        'expedienteEstado'=> 'xsd:string',
        'expedienteUsuarioAsignado' => 'xsd:string'),
    array('return' => 'tns:consultaExpedienteObjeto'),
    'urn:idu',    // namespace
    '',            // soapaction
    '',                                    // style
    '',                                // use
    'Copyright by Hector Orlando Crispens'        // documentation
);

  }

function execute($e)
{ 
  $codigo_trata = $e["codigo_trata"];
  $estado = $e["estado"];
  $usuario = $e["usuario"];
 
    /**
     * Guardar el Request 
     * */ 
     
    $req_trace = R::dispense('tracerequest');
    $req_trace->method = "consultarDatosExpedientePorCodigosDeTrata";
    $req_trace->jsonRequest= "{'codigo_trata' => '".$codigo_trata."', 'estado' => '".$estado."', 'usuario' => '".$usuario."' }";
    $req_trace->fecha = "".date('Y-m-d H:i:s');
    $id_reg = R::store($req_trace);

    /**
     * Creamos una instancia de FactorySoapClient y pedimos un SoapClient con la clave que identifica al WSDL de GDE
     * llamamos al servicio de GDE
     */
    
     $factory = new FactorySoapClient();
     $client = $factory->getClient("consultaGDE");
 
     $result = $client->consultarDatosExpedientePorCodigosDeTrata(array(
     "listaDeCodigosTrata" => $codigo_trata,
     "expedienteEstado" => $estado,
     "expedienteUsuarioAsignado" => $usuario));

     if (is_soap_fault($result)) {
      
      $res_trace = R::dispense('traceresponse');
      $res_trace->idRequest = $id_reg;
      $res_trace->jsonResponse = "{'SOAP Fault': {'faultcode': '{$result->faultcode}', 'faultstring': '{$result->faultstring}'}}";
      $res_trace->fecha = "".date('Y-m-d H:i:s');
  
      R::store($res_trace);
     return $result;  
  }
    
     /**
      * Creamos el Json y reemplazamos los acentos
      */

  /*
      $jsonO = R::load("traceresponse", "44");
      $lista = json_decode($jsonO->jsonResponse);
      $value = $lista->listaDatosTarea;
  
     */
    
    $json = json_encode($result->{"return"});
       /**
         * Guardamos en la base de datos el response
         */
      
       $lista = json_decode($json);
       $res_trace = R::dispense('traceresponse');
       $res_trace->idRequest = $id_reg;
       $res_trace->jsonResponse = $json;
       $res_trace->fecha = "".date('Y-m-d H:i:s');
       $idResponse = R::store($res_trace);

    

      $re = new DatosExpedientePorCodigoDeTrataDTO();
      
      $arr =$lista->listaDatosTarea;
        array_push($re->listaDatosTarea, array(
          "codigoExpediente" => $arr->codigoExpediente,
          "codigoTrata" => $arr->codigoTrata,
          "descripcionTrata" => $arr->descripcionTrata,
          "estado" => $arr->estado,
          "fechaModificacion" => $arr->fechaModificacion,
          "motivo" => $arr->motivo,
          "usuarioAnterior" => $arr->usuarioAnterior
      ));

     
    
  return $re;
       }

}
