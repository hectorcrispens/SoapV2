<?php

require_once(__DIR__ .'/../interfaces/iNucleoEntidad.php');
require __DIR__ .'/../Dto/DatosCaratulaVariableDTO.php';

class DatosCaratulaVariable implements iNucleoEntidad{

/**
 *  Implement ComplexType struc Data
 */
  function AddComplex($server){
    $server->wsdl->addComplexType(
        'campo',
        'complexType',
        'struct',
        'all',
        '',
        array(
            "campo" => array("name" => "campo", "type" => "xsd:string"),
            "valor" => array("name" => "nombre", "type" => "xsd:string")
            
            
        )
    );
    $server->wsdl->addComplexType(
        'acampos',
        'complexType',
        'array',
        '',
        'SOAP-ENC:Array',
        array(),
        array(
            array(
                'ref' => 'SOAP-ENC:arrayType',
                'wsdl:arrayType' => 'tns:campo[]'
            )
        ),
        'tns:campo'
    );
    $server->wsdl->addComplexType(
        'caratulaVariableObjeto',
        'complexType',
        'struct',
        'all',
        '',
        array(
            "campos" => array("name" => "campos", "type" => "tns:acampos"),
            "nombre" => array("name" => "nombre", "type" => "xsd:string")
            
            
        )
    );
  }

  /**
   * ADD method to Server-Soap
   */
  function AddMethod($server){
    $server->register(
        'obtenerDatosCaratulaVariable',
        array(
            'codigoEE' => 'xsd:string',
            'usuario' => 'xsd:string'
            ),
        array('return' => 'tns:caratulaVariableObjeto'),
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
   $ee = $codigo["codigoEE"];
   $usuario =$codigo["usuario"];

    /**
     * Guardar el Request 
     * */ 
     
    $req_trace = R::dispense('tracerequest');
    $req_trace->method = "obtenerDatosCaratulaVariable";
    $req_trace->jsonRequest= "{'codigoEE' => '".$ee."', 'usuario' => '".$usuario."' }";
    $req_trace->fecha = "".date('Y-m-d H:i:s');
    $id_reg = R::store($req_trace);


        /**
         * Creamos una instancia de FactorySoapClient y pedimos un SoapClient con la clave que identifica al WSDL de GDE
         * llamamos al servicio de GDE
         */

        $factory = new FactorySoapClient();
        $client = $factory->getClient("consultaGDE");
        $result = $client->obtenerDatosCaratulaVariable(array("codigoEE" => $ee, "usuario" => $usuario));

        if (is_soap_fault($result)) {
            $res_trace = R::dispense('traceresponse');
            $res_trace->idRequest = $id_reg;
            $res_trace->jsonResponse = "{'SOAP Fault': {'faultcode': '{$result->faultcode}', 'faultstring': '{$result->faultstring}'}}";
            $res_trace->fecha = "" . date('Y-m-d H:i:s');
            R::store($res_trace);
            return $result;
        }
        else{

         /**
         * Creamos el Json y reemplazamos los acentos
         */

        $json = json_encode($result);
        //$json = remplaceAcentos($json);

        /**
         * Guardamos en la base de datos el response
         */

        $array = json_decode($json);
        $res_trace = R::dispense('traceresponse');
        $res_trace->idRequest = $id_reg;
        $res_trace->jsonResponse = $json;
        $res_trace->fecha = "" . date('Y-m-d H:i:s');

        R::store($res_trace);
        $result = $result->return;


   $entidad = new DatosCaratulaVariableDTO();
   $entidad->nombre = $ee;

   foreach($result->campos as $campoItem){
       if(strcmp($campoItem->campo, "Sección")==0) $campoItem->valor = "primera";
    array_push($entidad->campos, array("valor" => $campoItem->valor, "campo" => $campoItem->campo));
   }

   return $entidad;

        }

}
}
