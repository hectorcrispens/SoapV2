<?php

require_once(__DIR__ . '/../interfaces/iNucleoEntidad.php');
require __DIR__ . '/../Dto/DocumentoDetalleDTO.php';

class DocumentoDetalle implements iNucleoEntidad
{

    /**
     *  Implement ComplexType struc Data
     */

    function AddComplex($server)
    {

        $server->wsdl->addComplexType(
            'listaHistorial',
            'complexType',
            'struct',
            'all',
            '',
            array(
                'actividad' => array('name' => 'actividad', 'type' => 'xsd:string'),
                'fechaFin' => array('name' => 'fechaFin', 'type' => 'xsd:string'),
                'fechaInicio' => array('name' => 'fechaInicio', 'type' => 'xsd:string'),
                'id' => array('name' => 'id', 'type' => 'xsd:integer'),
                'mensaje' => array('name' => 'mensaje', 'type' => 'xsd:string'),
                'userName' => array('name' => 'userName', 'type' => 'xsd:string'),
                'usuario' => array('name' => 'usuario', 'type' => 'xsd:string'),
                'workflowOrigen' => array('name' => 'workflowOrigen', 'type' => 'xsd:string')
            )
        );

        $server->wsdl->addComplexType(
            'arraylistaHistorial',
            'complexType',
            'array',
            '',
            'SOAP-ENC:Array',
            array(),
            array(
                array(
                    'ref' => 'SOAP-ENC:arrayType',
                    'wsdl:arrayType' => 'tns:listaHistorial[]'
                )
            ),
            'tns:listaHistorial'
        );

        $server->wsdl->addComplexType(
            'arrayString',
            'complexType',
            'array',
            '',
            'SOAP-ENC:Array',
            array(),
            array(
                array(
                    'ref' => 'SOAP-ENC:arrayType',
                    'wsdl:arrayType' => 'xsd:string[]'
                )
            ),
            'xsd:string'
        );


        $server->wsdl->addComplexType(
            'documentoDetalle',
            'complexType',
            'struct',
            'all',
            '',
            array(
                "datosPropios" => array("name" => "datosPropios", "type" => "tns:arrayString"),
                "fechaCreacion" => array("name" => "fechaCreacion", "type" => "xsd:string"),
                "listaArchivosDeTrabajo" => array("name" => "listaArchivosDeTrabajo", "type" => "tns:arrayString"),
                "listaFirmantes" => array("name" => "listaFirmantes", "type" => "tns:arrayString"),
                "listaHistorial" => array("name" => "listaHistorial", "type" => "tns:arraylistaHistorial"),
                "numeroEspecial" => array("name" => "numeroEspecial", "type" => "xsd:string"),
                "numeroSade" => array("name" => "numeroSade", "type" => "xsd:string"),
                "puedeVerDocumento" => array("name" => "puedeVerDocumento", "type" => "xsd:boolean"),
                "referencia" => array("name" => "referencia", "type" => "xsd:string"),
                "tipoDocumento" => array("name" => "tipoDocumento", "type" => "xsd:string"),
                "urlArchivo" => array("name" => "urlArchivo", "type" => "xsd:string")
                
            )
        );
        return;
    }

    /**
     * ADD method to Server-Soap
     */
    function AddMethod($server)
    {
        $server->register(
            'consultarDocumentoDetalle',
            array('request' => 'tns:GEDOrequest'),
            array('return' => 'tns:documentoDetalle'),
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
    function execute($request)
    {

        /**
         * Guardar el Request 
         * */

        //var_dump($request["numeroDocumento"]);

        $arrnew = array('request' => $request);
        $req_trace = R::dispense('tracerequest');
        $req_trace->method = "consultarDocumentoDetalle";
        $req_trace->jsonRequest = str_replace("\"", "'", json_encode($arrnew));
        $req_trace->fecha = "" . date('Y-m-d H:i:s');
        $id_reg = R::store($req_trace);


        /**
         * Creamos una instancia de FactorySoapClient y pedimos un SoapClient con la clave que identifica al WSDL de GDE
         * llamamos al servicio de GDE
         */

        $factory = new FactorySoapClient();
        $client = $factory->getClient("consultaGEDO");
        $result = $client->consultarDocumentoDetalle(array(
            "request" => array(
                "assignee" => "",
                "numeroDocumento" => $request["numeroDocumento"],
                "numeroEspecial" => "",
                "usuarioConsulta" => $request["usuarioConsulta"]
            )
        ));

        if (is_soap_fault($result)) {
            $res_trace = R::dispense('traceresponse');
            $res_trace->idRequest = $id_reg;
            $res_trace->jsonResponse = "{'SOAP Fault': {'faultcode': '{$result->faultcode}', 'faultstring': '{$result->faultstring}'}}";
            $res_trace->fecha = "" . date('Y-m-d H:i:s');
            R::store($res_trace);
            return $result;
        }

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

        $re = new DocumentoDetalleDTO();
        //var_dump($result->listaHistorial);
        
        $re->datosPropios = $result->datosPropios;
        $re->fechaCreacion = $result->fechaCreacion;
        $re->listaArchivosDeTrabajo = $result->listaArchivosDeTrabajo;
        $re->listaFirmantes = array($result->listaFirmantes);
       
        foreach($result->listaHistorial as $obj){
            $dto = array(
            "actividad" => $obj->actividad,
            "fechaFin" => $obj->fechaFin,
            "fechaInicio" => $obj->fechaInicio,
            "id" => $obj->id,
            "mensaje" => $obj->mensaje,
            "userName" => $obj->userName,
            "usuario" => $obj->usuario,
            "workflowOrigen" => $obj->workflowOrigen);
            array_push($re->listaHistorial, $dto);
        }
        //var_dump($re->listaHistorial);
        //$re->listaHistorial = $result->listaHistorial;
        $re->numeroEspecial = $result->numerEspecial;
        $re->numeroSade = $result->numeroSade;
        $re->puedeVerDocumento = $result->puedeVerDocumento;
        $re->referencia = $result->referencia;
        $re->tipoDocumento = $result->tipoDocumento;
        $re->urlArchivo = $result->urlArchivo;
        

        return $re;
    }
}
