<?php
require_once 'ServiceLocator.php';
require __DIR__ .'/../vendor/RedBean/rb.php';
require __DIR__ .'/../soap-ClientFactory.php';
require __DIR__ .'/../config/database.php';

function consultarDatosExpedientePorCodigosDeTrata($codigo_trata, $estado, $usuario){
    $sl = ServiceLocator::getInstance(null);
    $Service = $sl->container->getService("DatosPorCodigoTrataService");
    return $Service->execute(array("codigo_trata" =>$codigo_trata, "estado" => $estado, "usuario" => $usuario));

}

function expose($data){
    $sl = ServiceLocator::getInstance(null);
    $Service = $sl->container->getService("ExposeService");
    //var_dump($Service);
    return $Service->execute($data);

}

function obtenerHistorialDePasesDeExpediente($codigoEE){
    $sl = ServiceLocator::getInstance(null);
    $Service = $sl->container->getService("HistorialDePases");
    //var_dump($Service);
    return $Service->execute($codigoEE);
}

function consultaEEDetallado($codigoEE){
    $sl = ServiceLocator::getInstance(null);
    $Service = $sl->container->getService("CEEDetallado");
    //var_dump($Service);
    return $Service->execute($codigoEE);
    
}
function consultarDocumentoPorNumero($request){
    $sl = ServiceLocator::getInstance(null);
    $Service = $sl->container->getService("DocumentoPorNumero");
    //var_dump($Service);
    return $Service->execute($request);
}
function buscarTransaccionPorUUID($arg){
    $sl = ServiceLocator::getInstance(null);
    $Service = $sl->container->getService("TransaccionPorUUID");
    //var_dump($Service);
    return $Service->execute($arg);
}
function consultarDocumentoPdf($request){
    $sl = ServiceLocator::getInstance(null);
    $Service = $sl->container->getService("DocumentoPdf");
    //var_dump($Service);
    return $Service->execute($request);
}