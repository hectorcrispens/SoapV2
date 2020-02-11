<?php

require_once __DIR__ .'/../interfaces/iNucleoEntidad.php';

class BaseClass implements iNucleoEntidad{
    
  function AddComplex($server){
    
    $server->wsdl->addComplexType(
        'uno',
        'complexType',
        'struct',
        'all',
        '',
        array(
           'noneuno' => array('name' => 'noneuno', 'type' => 'xsd:string')
        ));

    $server->wsdl->addComplexType(
        'dos',
        'complexType',
        'struct',
        'all',
        '',
        array(
           'nonedos' => array('name' => 'nonedos', 'type' => 'xsd:string'),
        
        ));
    
    $server->wsdl->addComplexType(
        'arrayUno',
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
        'arrayDos',
        'complexType',
        'array',
        '',
        'SOAP-ENC:Array',
        array(),
        array(
            array(
                'ref' => 'SOAP-ENC:arrayType',
                'wsdl:arrayType' => 'tns:dos[]'
            )
        ),
        'tns:dos'
    );

    $server->wsdl->addComplexType(
    'consultaExp',
    'complexType',
    'struct',
    'all',
    '',
    array(
        "codigoExpediente" => array("name" => "codigoExpediente", "type" => "xsd:string"),
        "codigoTrata" => array("name" => "codigoTrata", "type" => "xsd:string"),
        "descripcionTrata" => array("name" => "descripcionTrata", "type" => "xsd:string"),
        "estado" => array("name" => "estado", "type" => "xsd:string"),
        "fechaModificacion" => array("name" => "fechaModificacion", "type" => "xsd:string"),
        "motivo" => array("name" => "motivo", "type" => "xsd:string"),
        "usuarioAnterior" => array("name" => "usuarioAnterior", "type" => "xsd:string")
    ));

$server->wsdl->addComplexType(
    'arrayConsultaExp',
    'complexType',
    'array',
    '',
    'SOAP-ENC:Array',
    array(),
    array(
        array(
            'ref' => 'SOAP-ENC:arrayType',
            'wsdl:arrayType' => 'tns:consultaExp[]'
        )
    ),
    'tns:consultaExp'
);

return;
  }
  function AddMethod($server){
      return;
  }

function execute($e)
{ 
        
    
  return;
}

}
