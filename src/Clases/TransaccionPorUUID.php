<?php

require_once(__DIR__ .'/../interfaces/iNucleoEntidad.php');
require __DIR__ .'/../Dto/TransaccionPorUUIDDTO.php';
require __DIR__.'/../Factory/GDEFactory.php';

class TransaccionPorUUID implements iNucleoEntidad{

/**
 *  Implement ComplexType struc Data
 */
  function AddComplex($server){
    $server->wsdl->addComplexType(
        'comps',
        'complexType',
        'struct',
        'all',
        '',
        array(
            'etiqueta' => array('name' => 'etiqueta', 'type' => 'xsd:string'),
            'id' => array('name' => 'id', 'type' => 'xsd:string'),
            'idFormComp' => array('name' => 'idFormComp', 'type' => 'xsd:string'),
            'inputName' => array('name' => 'inputName', 'type' => 'xsd:string'),
            'orden' => array('name' => 'orden', 'type' => 'xsd:string'),
            'ordenInterno' => array('name' => 'ordenInterno', 'type' => 'xsd:string'),
            'relevanciaBusqueda' => array('name' => 'relevanciaBusqueda', 'type' => 'xsd:string'),
            'separadorRepetidor' => array('name' => 'separadorRepetidor', 'type' => 'xsd:string'),
            'valorBlob' => array('name' => 'valorBlob', 'type' => 'xsd:string'),
            'valorBoolean' => array('name' => 'valorBoolean', 'type' => 'xsd:string'),
            'valorDate' => array('name' => 'valorDate', 'type' => 'xsd:date'),
            'valorDouble' => array('name' => 'valorDouble', 'type' => 'xsd:string'),
            'valorLong' => array('name' => 'valorLong', 'type' => 'xsd:string'),
            'valorStr' => array('name' => 'valorStr', 'type' => 'xsd:string')
        
        ));
      
      
        $server->wsdl->addComplexType(
            'formArray',
            'complexType',
            'array',
            '',
            'SOAP-ENC:Array',
            array(),
            array(
                array(
                    'ref' => 'SOAP-ENC:arrayType',
                    'wsdl:arrayType' => 'tns:comps[]'
                )
            ),
            'tns:comps'
        );
        $server->wsdl->addComplexType(
            'TransaccionPorUUIDDTO',
            'complexType',
            'struct',
            'all',
            '',
            array(
                'estadoVisibilidad' => array('name' => 'estadoVisibilidad', 'type' => 'xsd:string'),
                'fechaCreacion' => array('name' => 'fechaCreacion', 'type' => 'xsd:date'),
                'nombreFormulario' => array('name' => 'nombreFormulario', 'type' => 'xsd:string'),
                'sistOrigen' => array('name' => 'sistOrigen', 'type' => 'xsd:string'),
                'uuid' => array('name' => 'uuid', 'type' => 'xsd:string'),
                'valorFormComps' => array('type' => 'tns:formArray')
            )
        );
        return;
   
  }

  /**
   * ADD method to Server-Soap
   */
  function AddMethod($server){
    $server->register(
        'buscarTransaccionPorUUID',
        array(
            'arg' => 'xsd:int'
        ),
        array('return' => 'tns:TransaccionPorUUIDDTO'),
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
function execute($codigo){ 
    /**TransaccionPorUUIDDTO
         * PreparamosTransaccionPorUUIDDTO la base de datos y storeamos los datos ingresados en el request 
         * */
        
        $req_trace = R::dispense('tracerequest');
        $req_trace->method = "buscarTransaccionPorUUID";
        $req_trace->jsonRequest = "{'arg' : '" . $codigo . "'}";
        $req_trace->fecha = "" . date('Y-m-d H:i:s');
        $id_reg = R::store($req_trace);

        $factory = new FactorySoapClient();
        $client = $factory->getClient("consultaGEDO");
        $result = $client->consultarDocumentoDetalle(array(
            "request" => array(
                "assignee" => "",
                "numeroDocumento" => "IF-2018-00003558-GSF-COMPRAS#LIF",
                "numeroEspecial" => "",
                "usuarioConsulta" => "USUARIO1"
            )
        ));

        $fecha = $result->return->listaHistorial[0]->fechaFin;
       
        $fabrica = new GDEFactory();
        $response = $fabrica->get("avisoGde");

        $response->estadoVisibilidad = "";
        $response->fechaCreacion = $fecha;
        $response->nombreFormulario = "FFCC_Caratula Variable_APN_FOITR_v2";
        $response->sistOrigen ="RLM";
        $response->uuid ="3L";

       
        
        
 /**
         * Guardamos en la base de datos el response
         */

        $res_trace = R::dispense('traceresponse');
        $res_trace->idRequest = $id_reg;
        $res_trace->jsonResponse = json_encode($response);
        $res_trace->fecha = "" . date('Y-m-d H:i:s');

        R::store($res_trace);
        return $response;
}
}
