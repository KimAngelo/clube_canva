<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ArtCategory extends AbstractMigration
{

    public function change(): void
    {
        $table = $this->table('art_category');
        $table->addColumn('art', 'integer')
            ->addColumn('category', 'integer')
            ->addForeignKey('art', 'arts', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addForeignKey('category', 'categories', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->create();
    }
}
