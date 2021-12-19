<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class OrderFeaturedCategory extends AbstractMigration
{

    public function change(): void
    {
        $table = $this->table('categories');
        $table->addColumn('order_key', 'integer', ['limit' => MysqlAdapter::INT_SMALL, 'after' => 'slug', 'null' => true])
            ->addColumn('featured', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'after' => 'order_key', 'null' => true])
            ->update();
    }
}
