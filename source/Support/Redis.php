<?php


namespace Source\Support;


use Predis\Client;

class Redis
{
    private $client;

    public function __construct()
    {
        $this->client = new Client('tcp://redis');
        /*$this->client->set('teste', '1234');
        $teste = $this->client->get('teste');
        var_dump($teste);
        exit();*/
    }

    public function set($key, $value)
    {
        $this->client->set($key, $value);
    }

    public function get($key)
    {
        return $this->client->get($key);
    }

    public function del($key)
    {
        $this->client->del($key);
    }
}