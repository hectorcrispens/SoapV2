<?php
// Pull in the NuSOAP code
require_once('vendor/NuSoap/nusoap.php');
require_once(__DIR__ .'/src/ServiceLocator.php');
require __DIR__ .'/src/GdeContainer.php';


// Pull function file
require __DIR__. '/src/Functions.php';

// Create the server instance
$server = new soap_server();

$server->soap_defencoding = 'UTF-8';
$server->decode_utf8 = false;
$server->encode_utf8 = true;

// Initialize WSDL support
$url="urn:idu";
$server->configureWSDL('server', $url);

$serviceLocator = ServiceLocator::getInstance(new GdeContainer());

//set All complextype
$serviceLocator->registrarComplex($server);

//register All methods
$serviceLocator->registerMethods($server);


// Use the request to (try to) invoke the service
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service(file_get_contents("php://input"));
?>