<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class SupportDynamicFields extends AbstractMigration
{

    public function change(): void
    {
        $table = $this->table('dynamic_fields_support');
        $table->addColumn('title_of_call', 'string', ['null' => true])
            ->addColumn('video_html', 'text', ['null' => true])
            ->addColumn('notice_title', 'string', ['null' => true])
            ->addTimestamps()
            ->create();
    }
}
