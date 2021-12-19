<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

/**
 * Class History
 * @package Source\Models
 */
class History extends DataLayer
{
    /**
     * History constructor.
     */
    public function __construct()
    {
        parent::__construct('history', ['id_user']);
    }
}