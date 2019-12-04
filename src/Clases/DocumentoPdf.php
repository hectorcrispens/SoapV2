<?php

require_once(__DIR__ . '/../interfaces/iNucleoEntidad.php');
require __DIR__ . '/../Dto/DocumentoPdfDTO.php';

class DocumentoPdf implements iNucleoEntidad
{

    function AddComplex($server)
    {
        
        return;
    }
    function AddMethod($server)
    {
        $server->register(
            'consultarDocumentoPdf',
            array('request' => 'tns:GEDOrequest'),
            array('return' => 'xsd:base64Binary'),
            'urn:idu',    // namespace
            '',            // soapaction
            '',                                    // style
            '',                                // use
            'Copyright by Hector Orlando Crispens'        // documentation
        );
        return;
    }

    function execute($request)
    {

        /**
         * Guardar el Request 
         * */

        //var_dump($request["numeroDocumento"]);

        $arrnew = array('request' => $request);
        $req_trace = R::dispense('tracerequest');
        $req_trace->method = "consultaDocumentoPdf";
        $req_trace->jsonRequest = str_replace("\"", "'", json_encode($arrnew));
        $req_trace->fecha = "" . date('Y-m-d H:i:s');
        $id_reg = R::store($req_trace);


        /**
         * Creamos una instancia de FactorySoapClient y pedimos un SoapClient con la clave que identifica al WSDL de GDE
         * llamamos al servicio de GDE
         */

        $factory = new FactorySoapClient();
        $client = $factory->getClient("consultaGEDO");
        $result = $client->consultarDocumentoPdf(array(
            "request" => array(
                "assignee" => "",
                "numeroDocumento" => $request["numeroDocumento"],
                "numeroEspecial" => "",
                "usuarioConsulta" => $request["usuarioConsulta"]
            )
        ));
       
        $file = fopen(__DIR__."/../Files/".$request["numeroDocumento"].".pdf", "w");
        fwrite($file, $result->return);
        fclose($file);

        $file = fopen(__DIR__."/../Files/".$request["numeroDocumento"].".pdf", "rb");

       $cadena = fread($file, filesize(__DIR__."/../Files/".$request["numeroDocumento"].".pdf"));

        return base64_encode($cadena);
        }
}
