<?php
interface iServiceLocator
{
    public static function getInstance($e);
    public function registrarComplex($server);
    public function registerMethods($server);
}