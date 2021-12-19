<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class FirstAccessUser extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('users');
        $table->addColumn('first_access', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'after' => 'id_plan', 'null' => true, 'default' => '0'])
            ->addColumn('gateway', 'string', ['limit' => 20, 'null' => true, 'after' => 'first_access'])
            ->addColumn('ip', 'string', ['limit' => 20, 'null' => true, 'after' => 'gateway'])
            ->addColumn('pwa', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'null' => true, 'after' => 'ip'])
            ->addColumn('onesignal', 'string', ['limit' => 30, 'null' => true, 'after' => 'pwa'])
            ->update();
    }
}
