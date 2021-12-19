<?php


use Phinx\Seed\AbstractSeed;

class CreatePlan extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $data = [
            'name' => "Plano de teste",
            'limit_day' => 15,
            'cod_hotmart' => '12345678'
        ];

        $plans = $this->table('plans');
        $plans->insert($data)->save();
    }
}
