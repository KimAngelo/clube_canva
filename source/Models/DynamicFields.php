<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

class DynamicFields extends DataLayer
{
    public function __construct()
    {
        parent::__construct('dynamic_fields_support', []);
    }
}