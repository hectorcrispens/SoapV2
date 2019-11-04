<?php

require_once(__DIR__ . '/../interfaces/iNucleoEntidad.php');
require __DIR__ . '/../Dto/DocumentoPorNumeroDTO.php';

class DocumentoPorNumero implements iNucleoEntidad
{

    /**
     *  Implement ComplexType struc Data
     */
    function AddComplex($server)
    {
        $server->wsdl->addComplexType(
            'GEDOrequest',
            'complexType',
            'struct',
            'all',
            '',
            array(
                'assignee' => array('name' => 'assignee', 'type' => 'xsd:string'),
                'numeroDocumento' => array('name' => 'numeroDocumento', 'type' => 'xsd:string'),
                'numeroEspecial' => array('name' => 'numeroEspecial', 'type' => 'xsd:string'),
                'usuarioConsulta' => array('name' => 'usuarioConsulta', 'type' => 'xsd:string')

            )
        );

        $server->wsdl->addComplexType(
            'DocumentoPorNumeroObjeto',
            'complexType',
            'struct',
            'all',
            '',
            array(

                "fechaCreacion" => array("name" => "fechaCreacion", "type" => "xsd:string"),
                "idTransaccion" => array("name" => "idTransaccion", "type" => "xsd:int"),
                "motivo" => array("name" => "motivo", "type" => "xsd:string"),
                "numeroDocumento" => array("name" => "numeroDocumento", "type" => "xsd:string"),
                "sistemaOrigen" => array("name" => "sistemaOrigen", "type" => "xsd:string"),
                "tipoDocumento" => array("name" => "tipoDocumento", "type" => "xsd:string"),
                "urlArchivo" => array("name" => "urlArchivo", "type" => "xsd:string"),
                "usuarioGenerador" => array("name" => "usuarioGenerador", "type" => "xsd:string"),
                "usuarioIniciador" => array("name" => "usuarioIniciador", "type" => "xsd:string")
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
            'consultarDocumentoPorNumero',
            array('request' => 'tns:GEDOrequest'),
            array('return' => 'tns:DocumentoPorNumeroObjeto'),
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
        $req_trace->method = "consultaDocumentoPorNumero";
        $req_trace->jsonRequest = str_replace("\"", "'", json_encode($arrnew));
        $req_trace->fecha = "" . date('Y-m-d H:i:s');
        $id_reg = R::store($req_trace);


        /**
         * Creamos una instancia de FactorySoapClient y pedimos un SoapClient con la clave que identifica al WSDL de GDE
         * llamamos al servicio de GDE
         */

        $factory = new FactorySoapClient();
        $client = $factory->getClient("consultaGEDO");
        $result = $client->consultarDocumentoPorNumero(array(
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
        $res_trace->jsonResponse = str_replace("\"", "'", $json);
        $res_trace->fecha = "" . date('Y-m-d H:i:s');

        R::store($res_trace);
        $result = $result->return;

        $re = new DocumentoPorNumeroDTO();
        $re->fechaCreacion = $result->fechaCreacion;
        $re->idTransaccion = 2;
        $re->motivo = $result->motivo;
        $re->numeroDocumento = $result->numeroDocumento;
        $re->sistemaOrigen = $result->sistemaOrigen;
        $re->tipoDocumento = "FOPAC";
        $re->urlArchivo = $result->urlArchivo;
        $re->usuarioGenerador = $result->usuarioGenerador;
        $re->usuarioIniciador = $result->usuarioIniciador;

        return $re;
    }
}
