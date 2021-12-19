<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Faq extends AbstractMigration
{

    public function change(): void
    {
        $table = $this->table('faq');
        $table->addColumn('title', 'string')
            ->addColumn('description', 'text', ['null' => true])
            ->addColumn('order', 'integer', ['null' => true])
            ->addTimestamps()
            ->create();
    }

}
