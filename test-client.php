<?php

$transaccionService = 'https://cgde-mule.santafe.gob.ar/GEDOServices/consultaDocumento?wsdl';
//186.33.209.66   euf.tst.gde.gob.ar

//$_SERVER['no_proxy'] = "127.0.0.1,localhost,10.0.0.0/8,.sfnet,.santafe.gov.ar,.santafe.gob.ar,.euf.tst.gde.gob.ar";
//libxml_disable_entity_loader(false);
//stream_context_set_default(['http'=>['proxy'=>'10.5.4.219:3128']]);
try {
   // echo json_encode($_SERVER);
    $client = new soapclient($transaccionService, array('trace' => 1, 'exceptions' => 0));

    $result = $client->consultarDocumentoDetalle(array(
        "request" => array(
            "assignee" => "",
            "numeroDocumento" => "IF-2018-00003558-GSF-COMPRAS#LIF",
            "numeroEspecial" => "",
            "usuarioConsulta" => "USUARIO1"
        )
    ));
    var_dump($result->return->listaHistorial[0]->fechaFin);
    /*
    $t = fopen("text2.txt", "w");
    fwrite($t, $result->return);
    fclose($t);*/
}
catch(Exception $e){
echo $e->getMessage();
}

//echo $_SERVER['no_proxy'];

?>