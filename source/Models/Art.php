<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

/**
 * Class Art
 * @package Source\Models
 */
class Art extends DataLayer
{
    /**
     * Art constructor.
     */
    public function __construct()
    {
        parent::__construct('arts', ['name', 'slug', 'thumb']);
    }
}