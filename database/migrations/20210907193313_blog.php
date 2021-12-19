<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Blog extends AbstractMigration
{

    public function change(): void
    {
        //CATEGORIAS
        $table = $this->table('blog_categories');
        $table
            ->addColumn('title', 'string')
            ->addColumn('description', 'string', ['null' => true])
            ->addColumn('slug', 'string', ['null' => true])
            ->addTimestamps()
            ->create();

        //POSTS
        $table = $this->table('blog_posts');
        $table
            ->addColumn('author', 'integer', ['null' => true])
            ->addColumn('category', 'integer', ['null' => true])
            ->addColumn('title', 'string')
            ->addColumn('slug', 'string')
            ->addColumn('description', 'string', ['null' => true])
            ->addColumn('content', 'text', ['null' => true])
            ->addColumn('cover', 'string', ['null' => true])
            ->addColumn('views', 'integer', ['null' => true])
            ->addColumn('status', 'string', ['null' => true, 'limit' => 20])
            ->addColumn('type', 'string', ['null' => true, 'limit' => 10])
            ->addTimestamps()
            ->addForeignKey('author', 'users', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->addForeignKey('category', 'blog_categories', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->create();
    }
}
