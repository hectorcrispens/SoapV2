<?php

require_once(__DIR__ . '/../interfaces/iNucleoEntidad.php');
require __DIR__ . '/../Dto/EEDetalladoDTO.php';

class EEDetallado implements iNucleoEntidad
{
    /**
     *  Implement ComplexType struc Data
     */
    function AddComplex($server)
    {
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
                    'wsdl:arrayType' => 'xsd:string[]'
                )
            ),
            'xsd:string'
        );
        $server->wsdl->addComplexType(
            'EEDetalladoObjeto',
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
                "listArchivosAdjuntos" => array("type" => "tns:arrayUno"),
                "listDocumentosOficiales" => array("type" => "tns:arrayDocumentosOficiales"),
                "listExpedientesAsociados" => array("type" => "tns:arrayDos"),
                "listaDatosTarea" => array("type" => "tns:arrayConsultaExp"),
                "motivo" => array("name" => "", "type" => "xsd:string"),
                "sistemaOrigen" => array("name" => "", "type" => "xsd:string"),
                "datoVariable" => array("type" => "tns:arrayDos"),
                "descripcionTramite" => array("name" => "", "type" => "xsd:string"),
                "f_caratulacion" => array("name" => "", "type" => "xsd:string"),
                "listaExpedientesAsociados" => array("type" => "tns:arrayDos"),
                "listaExpedientesAsociadosFusion" => array("type" => "tns:arrayDos"),
                "listaExpedientesAsociadosTC" => array("type" => "tns:arrayDos"),
                "sectorDestino" => array("name" => "", "type" => "xsd:string"),
                "usuarioCaratulador" => array("name" => "", "type" => "xsd:string"),
                "usuarioDestino" => array("name" => "", "type" => "xsd:string")
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
            'consultaEEDetallado',
            array(
                'codigoEE' => 'xsd:string'
            ),
            array('return' => 'tns:EEDetalladoObjeto'),
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
        $req_trace->method = "consultaEEDetallado";
        $req_trace->jsonRequest = "{'codigoEE' : '" . $codigo . "'}";
        $req_trace->fecha = "" . date('Y-m-d H:i:s');
        $id_reg = R::store($req_trace);

        /**
         * Creamos una instancia de FactorySoapClient y pedimos un SoapClient con la clave que identifica al WSDL de GDE
         * llamamos al servicio de GDE
         */

        $factory = new FactorySoapClient();
        $client = $factory->getClient("consultaGDE");

        // Call wsdl function
        $result = $client->consultaEEDetallado(array(
            "codigoEE" => $codigo
        ));

        if (is_soap_fault($result)) {

            $res_trace = R::dispense('traceresponse');
            $res_trace->idRequest = $id_reg;
            $res_trace->jsonResponse = "{'SOAP Fault': {'faultcode': '{$result->faultcode}', 'faultstring': '{$result->faultstring}'}}";
            $res_trace->fecha = "" . date('Y-m-d H:i:s');

            R::store($res_trace);
            return $result;
        }

        $json = json_encode($result->{"return"});
        /**
         * Guardamos en la base de datos el response
         */

        $lista = json_decode($json);
        $res_trace = R::dispense('traceresponse');
        $res_trace->idRequest = $id_reg;
        $res_trace->jsonResponse = $json;
        $res_trace->fecha = "" . date('Y-m-d H:i:s');
        $idResponse = R::store($res_trace);

        //var_dump($lista);
        $re = new EEDetalladoDTO();
        if (array_key_exists("codigoDocCaratula", $lista))
            $re->codigoDocCaratula = $lista->codigoDocCaratula;
        if (array_key_exists("codigoEE", $lista))
            $re->codigoEE = $lista->codigoEE;
        if (array_key_exists("codigotrata", $lista))
            $re->codigotrata = $lista->codigotrata;
        if (array_key_exists("descripcionTrata", $lista))
            $re->descripcionTrata = $lista->descripcionTrata;
        if (array_key_exists("estado", $lista))
            $re->estado = $lista->estado;
        if (array_key_exists("listArchivosAdjuntos", $lista))
            $re->listArchivosAdjuntos = $lista->listArchivosAdjuntos;
        if (array_key_exists("listDocumentosOficiales", $lista))
            $re->listDocumentosOficiales = $lista->listDocumentosOficiales;
        if (array_key_exists("listExpedientesAsociados", $lista))
            $re->listExpedientesAsociados = $lista->listExpedientesAsociados;
        if (array_key_exists("listadatosTarea", $lista))
            $re->listaDatosTarea = $lista->listaDatosTarea;
        if (array_key_exists("motivo", $lista))
            $re->motivo = $lista->motivo;
        if (array_key_exists("sistemaOrigen", $lista))
            $re->sistemaOrigen = $lista->sistemaOrigen;
        if (array_key_exists("datoVariable", $lista))
            $re->datoVariable = $lista->datoVariable;
        if (array_key_exists("descripcionTramite", $lista))
            $re->descripcionTramite = $lista->descripcionTramite;
        if (array_key_exists("f_caratulacion", $lista))
            $re->f_caratulacion = $lista->f_caratulacion;
        if (array_key_exists("listaExpedientesAsociados", $lista))
            $re->listaExpedientesAsociados = $lista->listaExpedientesAsociados;
        if (array_key_exists("clistaExpedientesAsociadosFusion", $lista))
            $re->listaExpedientesAsociadosFusion = $lista->listaExpedientesAsociadosFusion;
        if (array_key_exists("listaExpedientesAsociadosTC", $lista))
            $re->listaExpedientesAsociadosTC = $lista->listaExpedientesAsociadosTC;
        if (array_key_exists("sectorDestino", $lista))
            $re->sectorDestino = $lista->sectorDestino;
        if (array_key_exists("usuarioCaratulador", $lista))
            $re->usuarioCaratulador = $lista->usuarioCaratulador;
        if (array_key_exists("usuarioDestino", $lista))
            $re->usuarioDestino = $lista->usuarioDestino;


        return $re;
    }
}
