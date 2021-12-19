<?php


namespace Source\Models\Blog;


use CoffeeCode\DataLayer\DataLayer;

/**
 * Class Category
 * @package Source\Models\Blog
 */
class Category extends DataLayer
{
    /**
     * Category constructor.
     */
    public function __construct()
    {
        parent::__construct('blog_categories', ['title', 'slug']);
    }

    /**
     * @return int
     */
    public function countPost()
    {
        return (new Post())->find('category = :category', "category={$this->id}")->count();
    }
}