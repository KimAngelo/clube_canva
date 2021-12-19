<?php


namespace Source\Models\Blog;


use CoffeeCode\DataLayer\DataLayer;
use Source\Models\User;

/**
 * Class Post
 * @package Source\Models\Blog
 */
class Post extends DataLayer
{
    /**
     * Post constructor.
     */
    public function __construct()
    {
        parent::__construct('blog_posts', ['title', 'slug', 'type']);
    }

    /**
     * @return User|null
     */
    public function author(): ?User
    {
        if ($this->data()->author) {
            return (new User())->findById($this->data()->author);
        }
        return null;
    }

    /**
     * @return Category|null
     */
    public function category(): ?Category
    {
        if (!empty($this->data()->category)) {
            return (new Category())->findById($this->data()->category);
        }
        return null;
    }
}