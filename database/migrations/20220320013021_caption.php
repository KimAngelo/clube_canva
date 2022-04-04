<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Caption extends AbstractMigration
{

    public function change(): void
    {
        /*$table = $this->table('plans');
        $table->addColumn('credit_caption', 'integer', ['null' => true, 'after' => 'period'])
            ->addColumn('price', 'decimal', ['precision' => 10, 'scale' => 2, 'null' => true, 'after' => 'period'])
            ->update();

        $table = $this->table('users');
        $table->addColumn('credit_caption', 'integer', ['null' => true, 'after' => 'next_due'])
            ->update();*/

        $table = $this->table('caption');
        $table->addColumn('description', 'text')
            ->addColumn('language', 'integer', ['null' => true])
            ->addColumn('credit', 'integer')
            ->addColumn('caption', 'text')
            ->addColumn('id_user', 'integer')
            ->addColumn('id_openai', 'string', ['null' => true])
            ->addColumn('model_openai', 'string', ['null' => true])
            ->addForeignKey('id_user', 'users', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addTimestamps()
            ->create();

    }
}
