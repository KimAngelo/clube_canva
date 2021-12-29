<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;
use Source\Support\Redis;

/**
 * Class Packs
 * @package Source\Models
 */
class Pack extends DataLayer
{
    /**
     * Packs constructor.
     */
    public function __construct()
    {
        parent::__construct('packs', ['name', 'slug']);
    }

    public function artsCount()
    {
        return (new Art())->find('id_pack = :id', "id={$this->id}")->count();
    }

    public function all()
    {
        $redis = new Redis();
        if ($redis->get('all_packs')) {
            return json_decode($redis->get('all_packs'));
        }
        $all = (new Pack())->find()->order('name')->fetch(true);
        $array = [];
        if ($all) {
            foreach ($all as $item) {
                $array[] = $item->data();
            }
        }
        $redis->set('all_packs', json_encode($array));
        return $all;
    }
}