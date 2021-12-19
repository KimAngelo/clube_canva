<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UpdateCategoriesArt extends AbstractMigration
{

    public function change(): void
    {
        $table = $this->table('arts');
        $table->dropForeignKey('id_categories')->update();

        $table = $this->table('arts');
        $table->removeColumn('id_categories')
            ->addColumn('categories', 'string', ['null' => true, 'after' => 'id_pack'])
            ->update();
    }
}
