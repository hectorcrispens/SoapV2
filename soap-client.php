<?php


require 'config/container.php';


class SoapCliente
{
    private $client;
    private $container;
    function __construct($endpoint){
        $contenedor = new container();
        $registerSettings = require __DIR__ .'/config/settings.php';
        $registerSettings($contenedor);
        $this->container = $contenedor;

        $this->client = new SoapClient( $this->container->getDefinition($endpoint), array( 'cache_wsdl' => WSDL_CACHE_NONE ) );

    }

    function get($method, $param, $d, $c){
        return $this->client->consultarDatosExpedientePorCodigosDeTrata('GSF000002', 'XVXVXVXVXVV', 'USUARIO1');

    }
}
?>