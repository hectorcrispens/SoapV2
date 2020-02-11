<?php

return function ($container) {
    // Global Settings Object
    $container->addDefinitions([
        'consultaGDE' => 'http://cgde-mule.santafe.gob.ar/EEServices/consulta?wsdl',
        'consultaGEDO' => 'http://cgde-mule.santafe.gob.ar/GEDOServices/consultaDocumento?wsdl',
        'bloqueoEE' => 'http://cgde-mule.santafe.gob.ar/EEServices/bloqueo-expediente?wsdl',
        'generar-pase' => 'http://cgde-mule.santafe.gob.ar/EEServices/generar-pase?wsdl',
        'documentos-oficiales' => 'http://cgde-mule.santafe.gob.ar/EEServices/documentos-oficiales?wsdl',
        'generar-caratula' => 'http://cgde-mule.santafe.gob.ar/EEServices/generar-caratula?wsdl',
        'generar-documento' => 'http://cgde-mule.santafe.gob.ar/GEDOServices/generarDocumento?wsdl',
        'transaccionService' => 'http://euf.tst.gde.gob.ar/dynform-web/transaccionService?wsdl'
    ]);
};
