<?php
require_once(__DIR__.'/../Dto/TransaccionPorUUIDDTO.php');
class GDEFactory{
public function get($clave){
    $dto = new TransaccionPorUUIDDTO();
switch($clave){
    case "avisoGde":
        
        $datos = array(
            "Fecha de Firma" => new DateTime(),
            "Titulo" => "Titulo Aviso",
            "Nro de Norma" => 123456,
            "anio" => 2019,
            "Firmantes" => "Juan del Gualeyan",
            "NroContratacion" => 123456,
            "AnioContratacion" => 2014,
            "ObservacionesGenerales" => "Observaciones Generales",
            "ObservacionesAviso" => "observaciones del aviso",
            "Rubro" => "Audiencias Publicas",
            "Tipo de Aviso" => "Audiencias Publicas",
            "Fecha de Publicacion" => new DateTime(),
            "Cantidad de Dias" => 45,
            "Organismo" => "Sectorial de Informatica"
        );
        $this->setValorForm($dto, $datos);

    break;
    default:
        return null;
}
return $dto;
}

private function setValorForm($entidad, $a){
    foreach($a as $clave => $valor){

        /**
         * Creamos la parte de arriba del formulario
         */
        $EstructuraSuperior = array(
            "etiqueta"=> $clave,
            "id"=> "5522845L",
            "idFormComp"=> "1753869L",
            "inputName"=> $clave,
            "orden"=> "13L",
            "ordenInterno"=> null,
            "relevanciaBusqueda"=> "1L",
            "separadorRepetidor"=> null,
            
        );

        /**
         * Creamos la estructura inferior del formulario
         */
        $EstructuraInferior = array(
            "valorBlob"=> null,
            "valorBoolean"=> null,
            "valorDate"=> null,
            "valorDouble"=> null,
            "valorLong"=> null,
            "valorStr"=> null
        );

        /**
         * Evaluamos el tipo de datos y lo seteamos en la estructura inferior
         */
        switch(gettype($valor)){
            case "object":
                $tiposDatos["valorDate"] = $valor;
                //echo $tiposDatos["valorDate"]->format('Y-m-d H:i:s');
            break;
            case "integer":
                $tiposDatos["valorLong"] = $valor;
               // echo $tiposDatos["valorLong"];
            break;
            case "string":
                $tiposDatos["valorStr"] = $valor;
                //echo $tiposDatos["valorStr"];
            break;
        }
  
            $valorForm = array_merge($EstructuraSuperior, $EstructuraInferior);
            array_push($entidad->valorFormComps, $valorForm);
        }

       

    }
    
}