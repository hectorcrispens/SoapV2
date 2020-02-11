<?php
 $tiposDatos = array(
    "valorBlob"=> "pedrido",
    "valorBoolean"=> null,
    "valorDate"=> null,
    "valorDouble"=> null,
    "valorLong"=> null,
    "valorStr"=> null
);
$tiposDatos["valorStr"] ="la concha de la lora";
$tiposDatos["valorDate"] = new DateTime();
echo $tiposDatos["valorBlob"];
echo $tiposDatos["valorStr"];
echo $tiposDatos["valorDate"]->format('Y-m-d H:i:s');