<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UserPlanMercadoPago extends AbstractMigration
{

    public function change(): void
    {
        //Data de vencimento
        $table = $this->table('users');
        $table->addColumn('next_due', 'datetime', ['null' => true, 'after' => 'onesignal'])
            ->addColumn('last_due', 'datetime', ['null' => true, 'after' => 'onesignal'])
            ->update();

        //Planos Dinâmicos
        $table = $this->table('plans');
        $table->changeColumn('cod_hotmart', 'string', ['null' => true])
            ->addColumn('gateway', 'string', ['null' => true, 'after' => 'cod_hotmart'])
            ->addColumn('cod_reference', 'string', ['null' => true, 'after' => 'gateway'])
            ->addColumn('period', 'string', ['limit' => 10, 'null' => true, 'after' => 'cod_reference'])
            ->update();
    }
}
