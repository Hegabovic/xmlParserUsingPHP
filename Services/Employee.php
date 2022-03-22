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

    function navigateEmployee($rootElement, $index): array
    {
        $name    = $rootElement->employee[$index]->name;
        $phone   = $rootElement->employee[$index]->phone;
        $address = $rootElement->employee[$index]->address;
        $email   = $rootElement->employee[$index]->Email;
        return [$name,$phone,$address,$email];
    }
}