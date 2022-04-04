<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

class Caption extends DataLayer
{
    public function __construct()
    {
        parent::__construct('caption', ['description', 'credit', 'caption', 'id_user']);
    }
}