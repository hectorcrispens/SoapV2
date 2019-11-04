<?php

require_once(__DIR__ .'/../interfaces/iNucleoEntidad.php');
require __DIR__ .'/../Dto/ExposeDTO.php';

class Expose implements iNucleoEntidad{
/**
 *  Implement ComplexType struc Data
 */
  function AddComplex($server){

    $server->wsdl->addComplexType(
        'exposeResponse',
        'complexType',
        'struct',
        'all',
        '',
        array(
            'dato1' => array('name' => 'dato1', 'type' =>'xsd:string'),
            'dato2' => array('name' => 'dato2' , 'type' => 'xsd:string')
        ));

        $server->wsdl->addComplexType(
            'exposeArray',
            'complexType',
            'array',
            '',
            'SOAP-ENC:Array',
            array(),
            array(
                array(
                    'ref' => 'SOAP-ENC:arrayType',
                    'wsdl:arrayType' => 'tns:exposeResponse[]'
                )
            ),
            'tns:exposeResponse'
        );
        $server->wsdl->addComplexType(
            'exposeObject',
            'complexType',
            'struct',
            'all',
            '',
            array(
                'exposeReturn' => array('type' => 'tns:exposeArray')
            )
        );
        return;
  }

  /**
   * ADD method to Server-Soap
   */
  function AddMethod($server){

    $server->register('expose',
    array('data' => 'xsd:string'),
    array('return' => 'tns:exposeObject'),
    'urn:idu',    // namespace
    '',            // soapaction
    '',                                    // style
    '',                                // use
    'Copyright by Hector Orlando Crispens');
    return;

  }


  /**
   * Execute Command
   */
function execute($data)
{ 
    $datad = R::dispense('dumpdata');
    $datad->text = $data;
    R::store($datad);
    $ret = new ExposeDTO();
    $ret->exposeReturn = array();
    array_push($ret->exposeReturn, array("dato1" => "de karnout", "dato2" => "deathpool"));
    return $ret;
       }

}
