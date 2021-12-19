<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

/**
 * Class Packs
 * @package Source\Models
 */
class Pack extends DataLayer
{
    /**
     * Packs constructor.
     */
    public function __construct()
    {
        parent::__construct('packs', ['name', 'slug']);
    }

    public function artsCount()
    {
        return (new Art())->find('id_pack = :id', "id={$this->id}")->count();
    }
}