<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

class Faq extends DataLayer
{
    public function __construct()
    {
        parent::__construct('faq', ['title']);
    }
}