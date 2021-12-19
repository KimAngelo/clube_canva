<?php


namespace Source\Controller;


use Source\Support\Glide;

class Image
{
    public function img(array $data)
    {
        $get = filter_var_array($_GET, FILTER_SANITIZE_STRIPPED);
        $post = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        unset($get['path']);
        unset($get['route']);
        return (new Glide())->make($post['name_img'], $_GET['path'], $get);
    }
}