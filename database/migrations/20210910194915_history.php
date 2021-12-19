<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class History extends AbstractMigration
{

    public function change(): void
    {
        $table = $this->table('history');
        $table->addColumn('id_user', 'integer')
            ->addColumn('id_art', 'integer', ['null' => true])
            ->addColumn('name', 'string', ['null' => true])
            ->addColumn('link_download', 'string', ['null' => true])
            ->addTimestamps()
            ->addForeignKey('id_user', 'users', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addForeignKey('id_art', 'arts', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->create();
    }
}
