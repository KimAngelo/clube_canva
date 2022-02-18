<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;
use Source\Core\Session;

/**
 * Class User
 * @package Source\Models
 */
class User extends DataLayer
{
    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct('users', ['first_name', 'email', 'password', 'level', 'id_plan']);
    }

    /**
     * @return DataLayer|null
     */
    public static function user(): ?DataLayer
    {
        $session = new Session();
        if (!$session->has("authUser")) {
            return null;
        }
        return (new User())->findById($session->authUser);
    }

    /**
     * @return DataLayer|null
     */
    public static function userAdmin(): ?DataLayer
    {
        $session = new Session();
        if (!$session->has("adminUser")) {
            return null;
        }
        return (new User())->findById($session->adminUser);
    }

    /**
     *
     */
    public static function logout(): void
    {
        $session = new Session();
        $session->unset("authUser");
        $session->unset("adminUser");
    }


    /**
     * @return int|string|null
     */
    public function artBalance()
    {
        $date = date_fmt('now', CONF_DATE_APP);
        $limit = $this->plan()->limit_day;
        $history = (new History())->find('id_user = :id_user AND DATE(created_at) = DATE(:date)', "id_user={$this->id}&date={$date}")->count();
        return $limit - $history;
    }

    /**
     * @return DataLayer|null
     */
    public function plan()
    {
        return (new Plan())->findById($this->id_plan);
    }

    public function findByEmail($email)
    {
        return $this->find('email = :e', "e={$email}")->fetch();
    }

    public function countDown()
    {
        return (new History())->find('id_user = :id_user', "id_user={$this->id}")->count();
    }
}