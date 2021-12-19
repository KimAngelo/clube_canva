<?php


use Phinx\Seed\AbstractSeed;

class DynamicFields extends AbstractSeed
{

    public function run()
    {
        $data = [
            'title_of_call' => "Título de chamada",
            'video_html' => "Vídeo embed",
            'notice_title' => "Título de ação"
        ];

        $users = $this->table('dynamic_fields_support');
        $users->insert($data)->save();
    }
}
