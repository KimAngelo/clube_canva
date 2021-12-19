<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class FirstMigrate extends AbstractMigration
{

    public function change(): void
    {
//REPORTS PARA RELÁTORIO DE ACESSOS
        $tab = $this->table('report_access');
        $tab->addColumn('users', 'integer')
            ->addColumn('views', 'integer')
            ->addColumn('pages', 'integer')
            ->addTimestamps()
            ->create();

        //RELATÓRIO DE USUÁRIOS ONLINE
        $tab = $this->table('report_online');
        $tab->addColumn('user', 'integer', ['null' => true])
            ->addColumn('ip', 'string', ['limit' => 50])
            ->addColumn('url', 'string')
            ->addColumn('agent', 'string')
            ->addColumn('pages', 'integer', ['default' => '1'])
            ->addTimestamps()
            ->create();

        //FILA DE E-MAILS
        $tab = $this->table('mail_queue');
        $tab->addColumn('subject', 'string')
            ->addColumn('body', 'string')
            ->addColumn('from_email', 'string')
            ->addColumn('from_name', 'string')
            ->addColumn('recipient_email', 'string')
            ->addColumn('recipient_name', 'string')
            ->addColumn('sent_at', 'timestamp')
            ->addTimestamps()
            ->create();

        //CATEGORIAS
        $tab = $this->table('categories');
        $tab->addColumn('name', 'string', ['limit' => 20])
            ->addColumn('thumb', 'string', ['null' => true])
            ->addColumn('slug', 'string')
            ->addTimestamps()
            ->create();

        //PACKS
        $tab = $this->table('packs');
        $tab->addColumn('name', 'string', ['limit' => 20])
            ->addColumn('slug', 'string')
            ->addTimestamps()
            ->create();

        //PLANOS
        $tab = $this->table('plans');
        $tab->addColumn('name', 'string', ['limit' => 20])
            ->addColumn('limit_day', 'integer', ['limit' => 4])
            ->addColumn('cod_hotmart', 'string')
            ->addTimestamps()
            ->create();

        //ARTES
        $tab = $this->table('arts');
        $tab->addColumn('name', 'string', ['limit' => 60])
            ->addColumn('slug', 'string')
            ->addColumn('description', 'string', ['null' => true])
            ->addColumn('id_pack', 'integer', ['null' => true])
            ->addColumn('id_categories', 'integer', ['null' => true])
            ->addColumn('link_template', 'string', ['null' => true])
            ->addColumn('thumb', 'string')
            ->addTimestamps()
            ->addForeignKey('id_pack', 'packs', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->addForeignKey('id_categories', 'categories', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->create();


        //TABELA USUÁRIOS
        $tab = $this->table('users');
        $tab->addColumn('first_name', 'string', ['limit' => 20, 'null' => false])
            ->addColumn('last_name', 'string', ['limit' => 40, 'null' => true])
            ->addColumn('email', 'string', ['limit' => 50])
            ->addColumn('password', 'string', ['limit' => 255])
            ->addColumn('level', 'integer', ['default' => '1'])
            ->addColumn('document_number', 'string', ['limit' => 18, 'null' => true])
            ->addColumn('phone', 'string', ['limit' => 16, 'null' => true])
            ->addColumn('address', 'string', ['null' => true])
            ->addColumn('address_number', 'string', ['null' => true])
            ->addColumn('address_complement', 'string', ['null' => true])
            ->addColumn('neighborhood', 'string', ['null' => true])
            ->addColumn('state', 'string', ['limit' => 2, 'null' => true])
            ->addColumn('city', 'string', ['limit' => 100, 'null' => true])
            ->addColumn('cep', 'string', ['limit' => 9, 'null' => true])
            ->addColumn('status', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'null' => true, 'default' => 1])
            ->addColumn('id_plan', 'integer', ['null' => true])
            ->addForeignKey('id_plan', 'plans', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->addTimestamps()
            ->create();

    }
}
