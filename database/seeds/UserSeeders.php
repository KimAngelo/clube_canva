<?php


use Phinx\Seed\AbstractSeed;

class UserSeeders extends AbstractSeed
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
        $faker = Faker\Factory::create();
        $data = [];
        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->email,
                'password' => password_hash('12345678', PASSWORD_DEFAULT),
                'level' => 1,
                'id_plan' => 1
            ];
        }

        $users = $this->table('users');
        $users->insert($data)->save();
    }
}
