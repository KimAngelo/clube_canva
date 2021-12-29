<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class FavoriteCategoryUser extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('users');
        $table->addColumn('favorite_categories', 'string', ['null' => true, 'after' => 'id_plan'])
            ->update();

        $table = $this->table('favorite_categories_users');
        $table->addColumn('id_user', 'integer')
            ->addColumn('id_category', 'integer')
            ->addTimestamps()
            ->addForeignKey('id_user', 'users', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addForeignKey('id_category', 'categories', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->create();
    }
}
