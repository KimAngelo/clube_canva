<?php

namespace Source\Support;

use League\Flysystem\Filesystem;
use League\Glide\ServerFactory;

/**
 *
 */
class Glide
{
    /**
     * @var \League\Glide\Server
     */
    private $server;

    /**
     *
     */
    public function __construct()
    {
        /* $this->server = ServerFactory::create([
             'source' => __DIR__ . '/../../storage/',
             'cache' => __DIR__ . '/../../storage/images/cache',
         ]);*/
        $s3 = new AwsS3();
        $this->server = ServerFactory::create([
            'source' => new Filesystem($s3->adapter()),
            'cache' => env('ENVIROMENT', 'PROD') == "DEV" ? __DIR__ . '/../../storage/images/cache' : new Filesystem($s3->adapter()),
            'cache_path_prefix' => 'cache_images',
        ]);
    }


    /**
     * @param string $name_img
     * @param string $path
     * @param array $config
     */
    public function make(string $name_img, string $path, array $config)
    {
        return $this->server->outputImage($path . '/' . $name_img, $config);
    }

    public function deleteCache(string $name_img, string $path)
    {
        $this->server->deleteCache($path . '/' . $name_img);
    }
}