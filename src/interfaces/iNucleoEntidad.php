<?php
interface iNucleoEntidad
{
    public function AddComplex($server);
    public function AddMethod($server);
    public function execute($e);
}