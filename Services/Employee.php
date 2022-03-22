<?php

class Employee
{

    function createEmployeeElement($rootElement, $data, string $parentElementName)
    {
        $element = $rootElement->addChild($parentElementName);
        foreach ($data as $key => $value) {
            $element->addChild($key, $value);
        }
        return $element;
    }

    function updateEmployeeElement($rootElement,$index){
        $rootElement->employee[$index]->name = $_POST["name"];
        $rootElement->employee[$index]->phone = $_POST["phone"];
        $rootElement->employee[$index]->address =$_POST["address"];
        $rootElement->employee[$index]->Email = $_POST["email"];

    }

    function deleteEmployeeElement($rootElement, $index){
        unset($rootElement->employee[$index]);
    }



    function navigateEmployee($rootElement, $index): array
    {
        $name    = $rootElement->employee[$index]->name;
        $phone   = $rootElement->employee[$index]->phone;
        $address = $rootElement->employee[$index]->address;
        $email   = $rootElement->employee[$index]->Email;
        return [$name,$phone,$address,$email];
    }

}