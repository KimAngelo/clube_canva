<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

/**
 * Class Plans
 * @package Source\Models
 */
class Plan extends DataLayer
{
    /**
     * Plans constructor.
     */
    public function __construct()
    {
        parent::__construct('plans', ['name', 'limit_day', 'cod_hotmart']);
    }

    /**
     * @return int
     */
    public function userCount()
    {
        return (new User())->find('id_plan = :id_plan', "id_plan={$this->id}")->count();
    }
}