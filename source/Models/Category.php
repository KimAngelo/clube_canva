<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;
use Source\Support\Redis;

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

    public function popup()
    {
        $redis = new Redis();
        if ($redis->get('categories_popup')) {
            return json_decode($redis->get('categories_popup'));
        }
        $all = (new Category())->find()->order('name')->fetch(true);
        $array = [];
        if ($all) {
            foreach ($all as $item) {
                $array[] = $item->data();
            }
        }
        $redis->set('categories_popup', json_encode($array));
        return $all;
    }

    public function featured_categories()
    {
        $redis = new Redis();
        if ($redis->get('featured_categories')) {
            return json_decode($redis->get('featured_categories'));
        }
        $all = (new Category())->find()->order('order_key')->limit(10)->fetch(true);
        $array = [];
        if ($all) {
            foreach ($all as $item) {
                $array[] = $item->data();
            }
        }
        $redis->set('featured_categories', json_encode($array));
        return $all;
    }
}