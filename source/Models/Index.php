<?php


namespace Source\Models;


use League\Csv\Reader;
use Source\Support\AwsS3;
use Source\Support\Message;

class Index
{
    /**
     * @var Message
     */
    protected $message;

    public function __construct()
    {
        $this->message = new Message();
    }

    public function listCSV()
    {
        $path = __DIR__ . '/../../storage/csv';
        if (!is_dir($path)) {
            mkdir($path);
        }
        $dir = dir($path);
        $file = [];
        while ($files = $dir->read()) {
            $info = pathinfo($files);
            if ($info['extension'] === "csv") {
                $csv = Reader::createFromPath($path . '/' . $info['basename'], 'r');
                $csv->setDelimiter(';');
                $csv->setHeaderOffset(0);
                $file[] = [
                    "name" => $info['filename'],
                    "name_file" => $info['basename'],
                    "total" => count($csv)
                ];
            }
        }
        $dir->close();
        return $file;
    }

    public function index(string $file_name)
    {
        set_time_limit(0);

        $path = __DIR__ . "/../../storage/csv";
        $file = $path . '/' . $file_name;
        if (!file_exists($file)) {
            $json['message'] = $this->message->error("O arquivo {$file_name} não foi encontrado")->render();
            echo json_encode($json);
            return;
        }

        $csv = Reader::createFromPath($file, 'r');
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);
        $data = $csv->getRecords();

        //Validação de dados
        foreach ($data as $item) {
            if (empty(trim($item['Nome']))) {
                $json['message'] = $this->message->warning("Preencha o nome do template")->render();
                echo json_encode($json);
                return;
            }
            if (empty(trim($item['Link do template'])) || !filter_var($item['Link do template'], FILTER_VALIDATE_URL)) {
                $json['message'] = $this->message->warning("Preencha o link do template {$item['Nome']}")->render();
                echo json_encode($json);
                return;
            }
            if (!isset($item['Pack']) || empty(trim($item['Pack'])) || !filter_var($item['Pack'], FILTER_VALIDATE_INT)) {
                $json['message'] = $this->message->warning("Preencha o pack do template {$item['Nome']} somente com números")->render();
                echo json_encode($json);
                return;
            }
            if (!isset($item['Categorias']) || empty(trim($item['Categorias']))) {
                $json['message'] = $this->message->warning("Preencha as categorias do template {$item['Nome']} separados com ponto e vírgula")->render();
                echo json_encode($json);
                return;
            }
            if (!isset($item['Imagem']) || empty(trim($item['Imagem']))) {
                $json['message'] = $this->message->warning("Preencha o campo imagem do template {$item['Nome']}")->render();
                echo json_encode($json);
                return;
            }
            if (!file_exists($path . '/' . $item['Imagem'])) {
                $json['message'] = $this->message->warning("A imagem do template {$item['Nome']} não foi encontrada.")->render();
                echo json_encode($json);
                return;
            }
            if (!(new Pack())->findById($item['Pack'])) {
                $json['message'] = $this->message->warning("O Pack do template {$item['Nome']} não existe.")->render();
                echo json_encode($json);
                return;
            }
            $categories = explode(';', $item['Categorias']);
            foreach ($categories as $category) {
                if (!(new Category())->findById($category)) {
                    $json['message'] = $this->message->warning("A categoria {$category} do template {$item['Nome']} não existe.")->render();
                    echo json_encode($json);
                    return;
                }
            }

        }

        //Registra os templates
        foreach ($data as $item) {
            $art = new Art();

            //Faz o envio da thumb
            $thumb_info = pathinfo($path . '/' . $item['Imagem']);
            $ext = $thumb_info['extension'] == 'png' ? '.png' : '.jpg';
            $file_name = md5(microtime() . $thumb_info['filename']) . $ext;
            $aws = new AwsS3();
            $aws->write(CONF_UPLOAD_IMAGE_DIR_ARTES . "/" . $file_name, file_get_contents($path . '/' . $item['Imagem']));
            $art->thumb = $file_name;

            $art->name = $item['Nome'];
            $art->slug = str_slug($item['Nome']);
            $art->description = $item['Descrição'];
            $art->id_pack = $item['Pack'];
            $art->categories = $item['Categorias'];
            $art->link_template = $item['Link do template'];

            if ($art->save()) {
                $id = $art->id;
                $categories = explode(';', $item['Categorias']);
                foreach ($categories as $category) {
                    $art_category = new ArtCategory();
                    $art_category->art = $id;
                    $art_category->category = $category;
                    $art_category->save();
                }
                unlink($path . '/' . $item['Imagem']);
            }
            if ($art->fail()) {
                $json['message'] = $this->message->error("Erro ao adicionar arte {$item['Nome']}, entre em contato com o suporte")->render();
                echo json_encode($json);
                return;
            }
        }

        unlink($file);
        $this->message->success("Templates adicionados com sucesso!")->flash();
        echo json_encode(['refresh' => true]);
        return;
    }
}