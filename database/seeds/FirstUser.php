<?php


use Phinx\Seed\AbstractSeed;

class FirstUser extends AbstractSeed
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
            'first_name' => "Kim",
            'last_name' => "Angelo dos Santos",
            'email' => "kim@kimangelo.me",
            'password' => password_hash('12345678', PASSWORD_DEFAULT),
            'level' => 5,
            'id_plan' => 1
        ];

        $users = $this->table('users');
        $users->insert($data)->save();
    }
}
