<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

class FavoriteCategory extends DataLayer
{
    public function __construct()
    {
        parent::__construct('favorite_categories_users', ['id_user', 'id_category']);
    }
}