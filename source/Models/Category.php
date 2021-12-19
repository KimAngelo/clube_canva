<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

/**
 * Class Category
 * @package Source\Models
 */
class Category extends DataLayer
{
    /**
     * Category constructor.
     */
    public function __construct()
    {
        parent::__construct('categories', ['name', 'slug']);
    }

    public function artsCount()
    {
        return (new ArtCategory())->find('category = :c', "c={$this->id}")->count();
    }
}