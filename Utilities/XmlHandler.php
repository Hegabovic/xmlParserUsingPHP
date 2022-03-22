<?php

class  XmlHandler{
    private $xmlFile;


    public function __construct($xmlFile)
    {
        $this->xmlFile = $xmlFile;
    }




    public function readXmlFile(){
        return simplexml_load_file($this->xmlFile);
    }

    public function saveData($xmlElement){
        $xmlElement->asXML($this->xmlFile);
    }
}