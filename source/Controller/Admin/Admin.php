<?php


namespace Source\Controller\Admin;


use Source\Core\Controller;
use Source\Core\Session;
use Source\Models\Art;
use Source\Models\ArtCategory;
use Source\Models\Blog\Post;
use Source\Models\Category;
use Source\Models\DynamicFields;
use Source\Models\Faq;
use Source\Models\History;
use Source\Models\Index;
use Source\Models\Pack;
use Source\Models\Plan;
use Source\Models\Report\Access;
use Source\Models\Report\Online;
use Source\Models\Upload;
use Source\Models\User;
use Source\Support\AwsS3;
use Source\Support\Glide;
use Source\Support\Pager;
use Source\Support\Thumb;

/**
 * Class Admin
 * @package Source\Controller\Admin
 */
class Admin extends Controller
{
    /**
     * @var Session
     */
    private $session;

    /**
     * Admin constructor.
     * @param $router
     */
    public function __construct($router)
    {
        $this->session = new Session();
        if (!$this->session->has('adminUser')) {
            $this->router->redirect('admin.auth_login');
        }
        $data = ['router' => $router];
        parent::__construct($data, __DIR__ . "/../../../themes/" . CONF_VIEW_ADMIN . "/");
    }


    /**
     * @param array|null $data
     */
    public function dash(?array $data): void
    {

        //Real Time Access
        if (!empty($data['refresh'])) {

            $list = null;
            $items = (new Online())->findByActive();
            if ($items) {
                /** @var  $item Online */
                foreach ($items as $item) {
                    $list[] = [
                        "dates" => date_fmt($item->created_at, "H\hi") . " - " . date_fmt($item->updated_at, "H\hi"),
                        "user" => !empty($item->user) ? $item->user()->first_name : "Guest",
                        "pages" => $item->pages,
                        "url" => $item->url
                    ];
                }
            }

            echo json_encode([
                "count" => (new Online())->findByActive(true),
                "list" => $list
            ]);

            return;
        }

        $views = (new Access())->find("DATE(created_at) = DATE(now())")->fetch();

        $head = $this->seo->render(
            "Admin | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("admin.auth_login"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("dash", [
            "head" => $head,
            "arts_count" => (new Art())->find()->count(),
            "users_count" => (new User())->find()->count(),
            "downloads_today" => (new History())->find('DATE(created_at) =  DATE(now())')->count(),
            "online" => (new Online())->findByActive(),
            "onlineCount" => (new Online())->findByActive(true),
        ]);
    }

    public function index(?array $data): void
    {
        $index = new Index();

        if (isset($data['action']) && $data['action'] == 'index') {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $index->index($data['name_file']);
            exit();
        }

        $head = $this->seo->render(
            "Artes em lote | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("admin.index"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("index", [
            "head" => $head,
            "index" => $index->listCSV()
        ]);
    }

    /**
     * @param array|null $data
     */
    public function tutorials(?array $data): void
    {
        $post = new Post();

        //Delete
        if (isset($data['action']) && $data['action'] == "delete") {
            $post = $post->findById($data['id']);
            if (!empty($post->cover)) {
                $path = __DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/" . CONF_UPLOAD_IMAGE_DIR_BLOG . "/";
                $thumb = (new Thumb())->flush(CONF_UPLOAD_IMAGE_DIR_BLOG . "/" . $post->cover);
                if (file_exists($path . $post->cover)) {
                    unlink($path . $post->cover);
                }
            }
            if ($post->destroy()) {
                $this->message->success("Tutorial apagado com sucesso")->flash();
                echo json_encode(['refresh' => true]);
                return;
            }
            $this->message->error($post->fail()->getMessage())->flash();
            echo json_encode(['refresh' => true]);
            return;
        }

        $head = $this->seo->render(
            "Tutoriais | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("admin.auth_login"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("tutorials", [
            "head" => $head,
            "tutorials" => $post->find("type = :t", "t=tutorial")->order("id DESC")->fetch(true)
        ]);
    }

    /**
     * @param array|null $data
     * Criar tutorial
     */
    public function createTutorial(?array $data): void
    {
        $tutorial = new Post();

        //CREATE
        if (isset($data['csrf'])) {
            $title = filter_var($data['title'], FILTER_SANITIZE_STRIPPED);
            $description = filter_var($data['description'], FILTER_SANITIZE_STRIPPED);
            $status = filter_var($data['status'], FILTER_SANITIZE_STRIPPED);
            $content = $data['content'];

            $post_verify = $tutorial->find("title = :t AND type = :type", "t={$title}&type=tutorial")->count();
            if ($post_verify) {
                $json['message_warning'] = "Já existe um tutorial com este título, digite outro para continuar";
                echo json_encode($json);
                return;
            }

            if (!csrf_verify($data)) {
                $json['message_error'] = "Ooops! Tente novamente mais tarde!";
                echo json_encode($json);
                return;
            }
            if (empty(trim($title)) || strlen(trim($title)) < 2) {
                $json['message_warning'] = "Digite um título válido para continuar";
                echo json_encode($json);
                return;
            }
            if ($status != "post" && $status != "draft") {
                $json['message_warning'] = "Status inválido";
                echo json_encode($json);
                return;
            }

            if (empty(trim($content))) {
                $json['message_warning'] = "Escreva algum conteúdo para continuar";
                echo json_encode($json);
                return;
            }

            if (isset($_FILES['cover']) && !empty($_FILES['cover']['tmp_name'][0])) {
                $upload = new Upload();

                $ext = ($_FILES['cover']['type'][0] == 'image/jpeg' ? '.jpg' : '.png');
                $file_name = md5(microtime() . $_FILES['cover']['name'][0]) . $ext;
                $path = __DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/" . CONF_UPLOAD_IMAGE_DIR_BLOG . "/";
                if ($upload->send($_FILES['cover'], $file_name, $path)) {
                    $tutorial->cover = $file_name;
                } else {
                    $json['message_warning'] = "Erro ao enviar imagem de destaque";
                    echo json_encode($json);
                    return;
                }
            }
            $tutorial->author = $this->session->adminUser;
            $tutorial->title = $title;
            $tutorial->slug = str_slug($title);
            $tutorial->description = $description;
            $tutorial->content = $content;
            $tutorial->status = $status;
            $tutorial->type = "tutorial";

            if ($tutorial->save()) {
                $this->message->success("Tutorial adicionado com sucesso!")->flash();
                echo json_encode(['refresh' => true]);
                return;
            }
            $json['message_error'] = "Erro ao criar o tutorial";
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            "Criar tutorial | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("admin.createTutorial"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("createTutorial", [
            "head" => $head,
        ]);
    }

    /**
     * @param array|null $data
     */
    public function updateTutorial(?array $data): void
    {
        if (!$tutorial = (new Post())->find("id = :id AND type = :t", "id={$data['id']}&t=tutorial")->fetch()) {
            $this->message->info("Tutorial não encontrado")->flash();
            $this->router->redirect('admin.tutorials');
            return;
        }

        //UPDATE
        if (isset($data['csrf'])) {
            $title = filter_var($data['title'], FILTER_SANITIZE_STRIPPED);
            $description = filter_var($data['description'], FILTER_SANITIZE_STRIPPED);
            $status = filter_var($data['status'], FILTER_SANITIZE_STRIPPED);
            $content = $data['content'];


            if ((new Post())->find("title = :t AND type = :type AND id != :id", "t={$title}&type=tutorial&id={$data['id']}")->count()) {
                $json['message_warning'] = "Já existe um tutorial com este título, digite outro para continuar";
                echo json_encode($json);
                return;
            }

            if (!csrf_verify($data)) {
                $json['message_error'] = "Ooops! Tente novamente mais tarde!";
                echo json_encode($json);
                return;
            }
            if (empty(trim($title)) || strlen(trim($title)) < 2) {
                $json['message_warning'] = "Digite um título válido para continuar";
                echo json_encode($json);
                return;
            }
            if ($status != "post" && $status != "draft") {
                $json['message_warning'] = "Status inválido";
                echo json_encode($json);
                return;
            }

            if (empty(trim($content))) {
                $json['message_warning'] = "Escreva algum conteúdo para continuar";
                echo json_encode($json);
                return;
            }

            if (isset($_FILES['cover']) && !empty($_FILES['cover']['tmp_name'][0])) {
                $upload = new Upload();

                $ext = ($_FILES['cover']['type'][0] == 'image/jpeg' ? '.jpg' : '.png');
                $file_name = md5(microtime() . $_FILES['cover']['name'][0]) . $ext;
                $path = __DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/" . CONF_UPLOAD_IMAGE_DIR_BLOG . "/";
                if ($upload->send($_FILES['cover'], $file_name, $path)) {
                    $thumb = (new Thumb())->flush(CONF_UPLOAD_IMAGE_DIR_BLOG . "/" . $tutorial->cover);
                    if (file_exists($path . $tutorial->cover)) {
                        unlink($path . $tutorial->cover);
                    }
                    $tutorial->cover = $file_name;

                } else {
                    $json['message_warning'] = "Erro ao enviar imagem de destaque";
                    echo json_encode($json);
                    return;
                }
            }
            /*$post->author = $this->user->id;*/
            $tutorial->title = $title;
            $tutorial->slug = str_slug($title);
            $tutorial->description = $description;
            $tutorial->content = $content;
            $tutorial->status = $status;

            if ($tutorial->save()) {
                $this->message->success("Tutorial atualizado com sucesso!")->flash();
                echo json_encode(['refresh' => true]);
                return;
            }
            $json['message_error'] = "Erro ao atualizar o tutorial, entre em contato com o suporte";
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            "Editar tutorial | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("admin.updateTutorial"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("updateTutorial", [
            "head" => $head,
            "tutorial" => $tutorial
        ]);
    }

    /**
     * @param array|null $data
     */
    public function plans(?array $data): void
    {
        $plans = new Plan();
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        //VALIDATION
        if (isset($data['action']) && ($data['action'] == "create" || $data['action'] == "update")) {
            if (empty(trim($data['name']))) {
                $json['message_warning'] = "Preencha o campo nome do plano";
                echo json_encode($json);
                return;
            }
            if (empty(trim($data['limit_day'])) || !filter_var($data['limit_day'], FILTER_VALIDATE_INT)) {
                $json['message_warning'] = "Preencha o limite de downloads diário";
                echo json_encode($json);
                return;
            }
            if (empty(trim($data['cod_hotmart']))) {
                $json['message_warning'] = "Preencha o código da hotmart";
                echo json_encode($json);
                return;
            }
        }

        //CREATE
        if (isset($data['action']) && $data['action'] == "create") {
            $plans->name = $data['name'];
            $plans->limit_day = $data['limit_day'];
            $plans->cod_hotmart = $data['cod_hotmart'];

            if ($plans->save()) {
                $this->message->success("Plano criado com sucesso!")->flash();
                echo json_encode(['refresh' => true]);
                return;
            }
            if ($plans->fail()) {
                $json['message_error'] = "Erro ao criar o plano, entre em contato com o suporte!";
                echo json_encode($json);
                return;
            }
        }

        //UPDATE
        if (isset($data['action']) && $data['action'] == "update") {
            if (!$plan = $plans->findById($data['id'])) {
                $json['message_error'] = "Não encontramos o plano";
                echo json_encode($json);
                return;
            }
            $plan->name = $data['name'];
            $plan->limit_day = $data['limit_day'];
            $plan->cod_hotmart = $data['cod_hotmart'];

            if ($plan->save()) {
                $this->message->success("Plano atualizado com sucesso!")->flash();
                echo json_encode(['refresh' => true]);
                return;
            }
            if ($plan->fail()) {
                $json['message_error'] = "Erro ao atualizar o plano, entre em contato com o suporte!";
                echo json_encode($json);
                return;
            }
        }

        //DELETE
        if (isset($data['action']) && $data['action'] == "delete") {
            if (!$plan = $plans->findById($data['id'])) {
                $json['message_error'] = "Não encontramos o plano";
                echo json_encode($json);
                return;
            }
            if ($plan->userCount() > 0) {
                $json['message_error'] = "Não é possível excluir o plano pois possui usuários registrados no plano";
                echo json_encode($json);
                return;
            }
            if ($plan->destroy()) {
                $this->message->success("Plano apagado com sucesso!")->flash();
                echo json_encode(['refresh' => true]);
                return;
            }
            if ($plan->fail()) {
                $json['message_error'] = "Erro ao apagar o plano, entre em contato com o suporte!";
                echo json_encode($json);
                return;
            }
        }

        $head = $this->seo->render(
            "Planos | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("admin.plans"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("plans", [
            "head" => $head,
            "plans" => $plans->find()->order('name')->fetch(true)
        ]);
    }

    /**
     * @param array|null $data
     */
    public function categories(?array $data): void
    {
        $categories = new Category();
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $request_axios = file_get_contents('php://input');
        $request_axios = json_decode($request_axios, true);

        //CREATE
        if (isset($data['action']) && $data['action'] == "create") {
            if (empty(trim($_FILES['cover']['tmp_name']))) {
                $json['message_warning'] = "Selecione uma imagem de destaque da categoria";
                echo json_encode($json);
                return;
            }
            if (empty(trim($data['name']))) {
                $json['message_warning'] = "Preencha o nome da categoria para continuar";
                echo json_encode($json);
                return;
            }
            if ($count = $categories->find('name = :n', "n={$data['name']}")->count()) {
                $json['message_warning'] = "Já existe uma categoria com este nome";
                echo json_encode($json);
                return;
            }

            //Faz o envio da miniatura
            $upload = new Upload();
            $ext = ($_FILES['cover']['type'] == 'image/jpeg' ? '.jpg' : '.png');
            $file_name = md5(microtime() . $_FILES['cover']['name']) . $ext;
            $path = __DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/" . CONF_UPLOAD_IMAGE_DIR_CATEGORY . "/";
            if ($upload->sends($_FILES['cover'], $file_name, $path)) {
                //Envia para AWS
                $aws = new AwsS3();
                $aws->write(CONF_UPLOAD_IMAGE_DIR_CATEGORY . "/" . $file_name, file_get_contents($path . $file_name));
                $categories->thumb = $file_name;
            } else {
                $json['message'] = $upload->message()->before("Oops! ")->render();
                echo json_encode($json);
                return;
            }
            $categories->name = $data['name'];
            $categories->slug = str_slug($data['name']);
            if ($categories->save()) {
                $this->message->success("Categoria criada com sucesso!")->flash();
                echo json_encode(['refresh' => true]);
                return;
            }
            if ($categories->fail()) {
                $json['message_error'] = "Oops! Não foi possivel cadastrar a categoria, entre em contato com o suporte";
                echo json_encode($json);
                return;
            }
        }

        //UPDATE
        if (isset($data['action']) && $data['action'] == "update") {
            $category = $categories->findById($data['id']);
            if (!$category) {
                $json['message_error'] = "Não encontramos a categoria selecionada";
                echo json_encode($json);
                return;
            }
            if (empty(trim($data['name']))) {
                $json['message_warning'] = "Preencha o nome da categoria para continuar";
                echo json_encode($json);
                return;
            }
            if ($count = $categories->find('name = :n AND id != :id', "n={$data['name']}&id={$data['id']}")->count()) {
                $json['message_warning'] = "Já existe uma categoria com este nome";
                echo json_encode($json);
                return;
            }

            if (!empty(trim($_FILES['cover']['tmp_name']))) {
                $upload = new Upload();
                $aws = new AwsS3();
                //Remove a miniatura anterior
                if ($category->thumb) {
                    (new Thumb())->flush(CONF_UPLOAD_IMAGE_DIR_CATEGORY . "/" . $category->thumb);
                    $upload->remove($category->thumb, __DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/" . CONF_UPLOAD_IMAGE_DIR_CATEGORY . "/");
                    $aws->delete(CONF_UPLOAD_IMAGE_DIR_CATEGORY . "/" . $category->thumb);
                }

                //Faz o envio da nova miniatura
                $ext = ($_FILES['cover']['type'] == 'image/jpeg' ? '.jpg' : '.png');
                $file_name = md5(microtime() . $_FILES['cover']['name']) . $ext;
                $path = __DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/" . CONF_UPLOAD_IMAGE_DIR_CATEGORY . "/";
                if ($upload->sends($_FILES['cover'], $file_name, $path)) {
                    $aws->write(CONF_UPLOAD_IMAGE_DIR_CATEGORY . "/" . $file_name, file_get_contents($path . $file_name));
                    $category->thumb = $file_name;
                } else {
                    $json['message'] = $upload->message()->before("Oops! ")->render();
                    echo json_encode($json);
                    return;
                }
            }

            $category->name = $data['name'];
            $category->slug = str_slug($data['name']);

            if ($category->save()) {
                $json['message_success'] = "Categoria  atualizada com sucesso";
                echo json_encode($json);
                return;
            }
            if ($category->fail()) {
                $json['message_error'] = "Oops! Não foi possivel atualizar a categoria, entre em contato com o suporte";
                echo json_encode($json);
                return;
            }
        }

        //DELETE
        if (isset($data['action']) && $data['action'] == "delete") {
            $category = $categories->findById($data['id']);
            if (!$category) {
                $json['message_error'] = "Não encontramos a categoria selecionada";
                echo json_encode($json);
                return;
            }

            //Remove a miniatura
            $upload = new Upload();
            if ($category->thumb) {
                (new Thumb())->flush(CONF_UPLOAD_IMAGE_DIR_CATEGORY . "/" . $category->thumb);
                $upload->remove($category->thumb, __DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/" . CONF_UPLOAD_IMAGE_DIR_CATEGORY . "/");
                $aws = new AwsS3();
                $aws->delete(CONF_UPLOAD_IMAGE_DIR_CATEGORY . "/" . $category->thumb);
            }
            if ($category->destroy()) {
                $this->message->success("Categoria apagada com sucesso")->flash();
                echo json_encode(['refresh' => true]);
                return;
            }
            if ($category->fail()) {
                $json['message_error'] = "Oops! Não foi possivel apagar a categoria, entre em contato com o suporte";
                echo json_encode($json);
                return;
            }
        }

        //ORDER
        if (isset($request_axios['action']) && $request_axios['action'] == "order") {
            $data = $request_axios;
            foreach ($data['array_key'] as $key => $id) {
                $category = (new Category())->find('id = :id', "id={$id}")->fetch();
                $category->order_key = $key;
                $category->save();
            }
            return;
        }

        //FEATURED (destaque)
        if (isset($request_axios['action']) && $request_axios['action'] == "featured") {
            $data = $request_axios;
            $category = (new Category())->findById($data['id']);
            $category->featured = $category->featured == 1 ? 0 : 1;
            $category->save();
            return;
        }

        $head = $this->seo->render(
            "Categorias | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("admin.categories"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("categories", [
            "head" => $head,
            "categories" => $categories->find()->order('order_key')->fetch(true)
        ]);
    }

    /**
     * @param array|null $data
     */
    public function packs(?array $data): void
    {
        $packs = new Pack();
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        //CREATE
        if (isset($data['action']) && $data['action'] == "create") {
            if (empty(trim($data['name']))) {
                $json['message_warning'] = "Preencha o campo nome do pack";
                echo json_encode($json);
                return;
            }
            if ($count = $packs->find('name = :n', "n={$data['name']}")->count()) {
                $json['message_warning'] = "Já existe um pack com este nome";
                echo json_encode($json);
                return;
            }
            $packs->name = $data['name'];
            $packs->slug = str_slug($data['name']);
            if ($packs->save()) {
                $this->message->success("Pack criado com sucesso!")->flash();
                echo json_encode(['refresh' => true]);
                return;
            }
            if ($packs->fail()) {
                $json['message_error'] = "Erro ao criar o pack, entre em contato com o suporte!";
                echo json_encode($json);
                return;
            }
        }

        //UPDATE
        if (isset($data['action']) && $data['action'] == "update") {
            if (!$pack = $packs->findById($data['id'])) {
                $json['message_error'] = "Não encontramos o pack";
                echo json_encode($json);
                return;
            }
            if (empty(trim($data['name']))) {
                $json['message_warning'] = "Preencha o campo nome do pack";
                echo json_encode($json);
                return;
            }
            if ($count = $packs->find('name = :n AND id != :id', "n={$data['name']}&id={$data['id']}")->count()) {
                $json['message_warning'] = "Já existe um pack com este nome";
                echo json_encode($json);
                return;
            }
            $pack->name = $data['name'];
            $pack->slug = str_slug($data['name']);
            if ($pack->save()) {
                $json['message_success'] = "Pack atualizado com sucesso!";
                echo json_encode($json);
                return;
            }
            if ($pack->fail()) {
                $json['message_error'] = "Erro ao atualizar o pack, entre em contato com o suporte!";
                echo json_encode($json);
                return;
            }
        }

        //DELETE
        if (isset($data['action']) && $data['action'] == "delete") {
            if (!$pack = $packs->findById($data['id'])) {
                $json['message_error'] = "Não encontramos o pack";
                echo json_encode($json);
                return;
            }
            if ($pack->destroy()) {
                $this->message->success("Pack apagado com sucesso!")->flash();
                echo json_encode(['refresh' => true]);
                return;
            }
            if ($pack->fail()) {
                $json['message_error'] = "Erro ao apagar o pack, entre em contato com o suporte!";
                echo json_encode($json);
                return;
            }
        }

        $head = $this->seo->render(
            "Packs | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("admin.packs"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("packs", [
            "head" => $head,
            "packs" => $packs->find()->order('name')->fetch(true)
        ]);
    }

    /**
     * @param array|null $data
     */
    public function arts(?array $data): void
    {
        $arts = new Art();

        //VALIDATION
        if (isset($data['action']) && ($data['action'] == "create" || $data['action'] == "update")) {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            if (empty(trim($data['name']))) {
                $json['message_warning'] = "Preencha o nome da arte";
                echo json_encode($json);
                return;
            }
            if (empty(trim($data['link_template'])) || !filter_var($data['link_template'], FILTER_VALIDATE_URL)) {
                $json['message_warning'] = "Preencha o link do template";
                echo json_encode($json);
                return;
            }
            if (!isset($data['id_pack']) || empty(trim($data['id_pack'])) || !filter_var($data['id_pack'], FILTER_VALIDATE_INT)) {
                $json['message_warning'] = "Selecione o pack da arte";
                echo json_encode($json);
                return;
            }
            if (!isset($data['categories'])) {
                $json['message_warning'] = "Selecione as categorias da arte";
                echo json_encode($json);
                return;
            }

        }

        //CREATE
        if (isset($data['action']) && $data['action'] == "create") {
            if (empty($_FILES['thumb']['tmp_name'])) {
                $json['message_warning'] = "Selecione uma imagem de destaque da arte";
                echo json_encode($json);
                return;
            }

            //Faz o envio da thumb
            $ext = ($_FILES['thumb']['type'] == 'image/jpeg' ? '.jpg' : '.png');
            $file_name = md5(microtime() . $_FILES['thumb']['name']) . $ext;
            (new AwsS3())->write(CONF_UPLOAD_IMAGE_DIR_ARTES . "/" . $file_name, file_get_contents($_FILES['thumb']['tmp_name']));

            $arts->thumb = $file_name;
            $arts->name = $data['name'];
            $arts->slug = str_slug($data['name']);
            $arts->description = $data['description'];
            $arts->id_pack = $data['id_pack'];
            $arts->categories = implode(';', $data['categories']);
            $arts->link_template = $data['link_template'];

            if ($arts->save()) {
                $id = $arts->id;
                foreach ($data['categories'] as $category) {
                    $art_category = new ArtCategory();
                    $art_category->art = $id;
                    $art_category->category = $category;
                    $art_category->save();
                }
                $this->message->success("Arte adicionada com sucesso!")->flash();
                echo json_encode(['refresh' => true]);
                return;
            }
            if ($arts->fail()) {
                $json['message_error'] = "Erro ao adicionar arte, entre em contato com o suporte";
                echo json_encode($json);
                return;
            }
        }

        //UPDATE
        if (isset($data['action']) && $data['action'] == "update") {
            if (!$art = $arts->findById($data['id'])) {
                $json['message_error'] = "A arte que está editando não existe";
                echo json_encode($json);
                return;
            }

            if (!empty(trim($_FILES['thumb']['tmp_name']))) {
                $aws = new AwsS3();

                //Remove a miniatura anterior
                if ($art->thumb) {
                    $aws->delete(CONF_UPLOAD_IMAGE_DIR_ARTES . "/" . $art->thumb);
                    (new Glide())->deleteCache($art->thumb, CONF_UPLOAD_IMAGE_DIR_ARTES);
                }

                //Faz o envio da nova miniatura
                $ext = ($_FILES['thumb']['type'] == 'image/jpeg' ? '.jpg' : '.png');
                $file_name = md5(microtime() . $_FILES['thumb']['name']) . $ext;

                $aws->write(CONF_UPLOAD_IMAGE_DIR_ARTES . "/" . $file_name, file_get_contents($_FILES['thumb']['tmp_name']));
                $art->thumb = $file_name;

            }

            $art->name = $data['name'];
            $art->slug = str_slug($data['name']);
            $art->description = $data['description'];
            $art->id_pack = $data['id_pack'];
            $art->categories = implode(';', $data['categories']);
            $art->link_template = $data['link_template'];
            $art->id_pack = $data['id_pack'];
            if ($art->save()) {
                $art_category = (new ArtCategory())->find("art = :id", "id={$data['id']}")->fetch(true);
                if ($art_category) {
                    foreach ($art_category as $item) {
                        $destroy = (new ArtCategory())->findById($item->id);
                        $destroy->destroy();
                    }
                }
                foreach (explode(';', $art->categories) as $item) {
                    $art_category = new ArtCategory();
                    $art_category->art = $data['id'];
                    $art_category->category = $item;
                    $art_category->save();
                }
                $this->message->success("Arte atualizada com sucesso!")->flash();
                echo json_encode(['refresh' => true]);
                return;
            }
            if ($art->fail()) {
                $json['message_error'] = "Erro ao atualizar a arte, tente novamente!";
                echo json_encode($json);
                return;
            }
        }

        //DELETE
        if (isset($data['action']) && $data['action'] == "delete") {
            if (!$art = $arts->findById($data['id'])) {
                $json['message_error'] = "Não encontramos a arte que deseja excluir";
                echo json_encode($json);
                return;
            }
            //Remove a thumb
            if ($art->thumb) {
                (new AwsS3())->delete(CONF_UPLOAD_IMAGE_DIR_ARTES . "/" . $art->thumb);
                (new Glide())->deleteCache($art->thumb, CONF_UPLOAD_IMAGE_DIR_ARTES);
            }
            if ($art->destroy()) {
                $this->message->success("Arte apagada com sucesso!")->flash();
                echo json_encode(['refresh' => true]);
                return;
            }
            if ($art->fail()) {
                $json['message_error'] = "Erro ao excluir a arte, tente novamente";
                echo json_encode($json);
                return;
            }
        }

        $page = isset($_GET['page']) ? filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT) : 1;

        if (isset($_GET['filter']) && $_GET['filter'] == 's') {
            $arts_categories = new ArtCategory();

            $text = filter_input(INPUT_GET, 'text', FILTER_SANITIZE_STRIPPED);
            $pack = filter_input(INPUT_GET, 'pack', FILTER_VALIDATE_INT);
            $category = filter_input(INPUT_GET, 'category', FILTER_VALIDATE_INT);

            $count = $arts_categories->filterAdminCount($text, $pack, $category);

            $pager = new Pager($this->router->route('admin.arts', [
                'filter' => 's',
                'text' => $text,
                'pack' => $pack,
                'category' => $category,
                'page' => ""
            ]), "Página", ["Primeira Página", "«"], ["Última Página", "»"]);
            $pager->pager($count->total, 20, $page);

            $art = $arts_categories->filterAdmin($text, $pack, $category, $pager->limit(), $pager->offset());

        } else {
            $art = $arts->find();

            $pager = new Pager($this->router->route('admin.arts',
                ['page' => ""]), "Página", ["Primeira Página", "«"], ["Última Página", "»"]);
            $pager->pager($art->count(), 20, $page);
            $art = $arts->offset($pager->offset())->limit($pager->limit())->order('id DESC')->fetch(true);
        }


        $head = $this->seo->render(
            "Artes | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("admin.arts"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("arts", [
            "head" => $head,
            "render" => $pager->render(),
            "arts" => $art,
            "packs" => (new Pack())->find()->fetch(true),
            "categories" => (new Category())->find()->fetch(true)
        ]);
    }

    /**
     * @param array|null $data
     */
    public function createArt(?array $data): void
    {
        $head = $this->seo->render(
            "Nova arte | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("admin.createArt"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("createArt", [
            "head" => $head,
            "packs" => (new Pack())->find()->fetch(true),
            "categories" => (new Category())->find()->order('name')->fetch(true)
        ]);
    }

    /**
     * @param array|null $data
     */
    public function updateArt(?array $data): void
    {
        if (!isset($data['id']) || !filter_var($data['id'], FILTER_VALIDATE_INT) || !$art = (new Art())->findById($data['id'])) {
            $this->message->info("Essa arte não existe!")->flash();
            $this->router->redirect('admin.arts');
        }

        $head = $this->seo->render(
            "Editar arte | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("admin.updateArt"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("updateArt", [
            "head" => $head,
            "packs" => (new Pack())->find()->fetch(true),
            "categories" => (new Category())->find()->order('name')->fetch(true),
            "art" => $art,
            "categories_art" => explode(";", $art->categories)
        ]);
    }

    /**
     * @param array|null $data
     */
    public function users(?array $data): void
    {
        $user = new User();
        //VALIDATION
        if (isset($data['action']) && ($data['action'] == "create" || $data['action'] == "update")) {
            if (empty(trim($data['first_name'])) || empty(trim($data['last_name']))) {
                $json['message_warning'] = "Preencha o nome e sobrenome do usuário";
                echo json_encode($json);
                return;
            }
            if (empty(trim($data['email'])) || !is_email($data['email'])) {
                $json['message_warning'] = "O email do usuário é inválido";
                echo json_encode($json);
                return;
            }
            if (!empty(trim($data['document_number'])) && strlen($data['document_number']) > 18) {
                $json['message_warning'] = "Número de documento inválido";
                echo json_encode($json);
                return;
            }
            if (!empty(trim($data['phone'])) && !phone_validation($data['phone'])) {
                $json['message_warning'] = "Número de telefone inválido";
                echo json_encode($json);
                return;
            }
            if (!empty(trim($data['state'])) && strlen($data['status']) > 2) {
                $json['message_warning'] = "O estado deve ter 2 caracteres";
                echo json_encode($json);
                return;
            }
            if (!empty(trim($data['cep'])) && !cep_validation($data['cep'])) {
                $json['message_warning'] = "CEP inválido";
                echo json_encode($json);
                return;
            }
            if (!filter_var($data['status'], FILTER_VALIDATE_INT)) {
                $json['message_warning'] = "Selecione o status do usuário";
                echo json_encode($json);
                return;
            }
            if (!filter_var($data['plan'], FILTER_VALIDATE_INT)) {
                $json['message_warning'] = "Selecione o plano do usuário";
                echo json_encode($json);
                return;
            }
            if (!filter_var($data['level'], FILTER_VALIDATE_INT)) {
                $json['message_warning'] = "Nível de acesso inválido";
                echo json_encode($json);
                return;
            }
        }

        //CREATE
        if (isset($data['action']) && $data['action'] == "create") {
            if ($email = $user->find('email = :e', "e={$data['email']}")->count()) {
                $json['message_warning'] = "Já existe um usuário registrado com este e-mail";
                echo json_encode($json);
                return;
            }
            if (!is_passwd($data['password']) || !is_passwd($data['password_re'])) {
                $json['message_warning'] = "Digite e repita a senha com no mínimo " . CONF_PASSWD_MIN_LEN . " caracteres";
                echo json_encode($json);
                return;
            }
            if ($data['password'] !== $data['password_re']) {
                $json['message_warning'] = "As senhas não conferem";
                echo json_encode($json);
                return;
            }
            $user->first_name = $data['first_name'];
            $user->last_name = $data['last_name'];
            $user->email = $data['email'];
            $user->document_number = $data['document_number'];
            $user->phone = $data['phone'];
            $user->address = $data['address'];
            $user->address_number = $data['address_number'];
            $user->neighborhood = $data['neighborhood'];
            $user->state = $data['state'];
            $user->city = $data['city'];
            $user->cep = $data['cep'];
            $user->status = $data['status'];
            $user->id_plan = $data['plan'];
            $user->password = passwd($data['password']);
            $user->level = $data['level'];
            if ($user->save()) {
                $this->message->success("Usuário registrado com sucesso")->flash();
                echo json_encode(['redirect' => $this->router->route('admin.users')]);
                return;
            }
            if ($user->fail()) {
                $json['message_error'] = "Erro ao registrar o usuário";
                echo json_encode($json);
                return;
            }
        }

        //UPDATE
        if (isset($data['action']) && $data['action'] == "update") {
            if (!$user = $user->findById($data['id'])) {
                $json['message_error'] = "O usuário não existe";
                echo json_encode($json);
                return;
            }
            if ($email = $user->find('email = :e AND id != :id', "e={$data['email']}&id={$data['id']}")->count()) {
                $json['message_warning'] = "Já existe um usuário registrado com este e-mail";
                echo json_encode($json);
                return;
            }
            if (!empty(trim($data['password']))) {
                if (!is_passwd($data['password']) || !is_passwd($data['password_re'])) {
                    $json['message_warning'] = "Digite e repita a senha com no mínimo " . CONF_PASSWD_MIN_LEN . " caracteres";
                    echo json_encode($json);
                    return;
                }
                if ($data['password'] !== $data['password_re']) {
                    $json['message_warning'] = "As senhas não conferem";
                    echo json_encode($json);
                    return;
                }
                $user->password = passwd($data['password']);
            }
            $user->first_name = $data['first_name'];
            $user->last_name = $data['last_name'];
            $user->email = $data['email'];
            $user->document_number = $data['document_number'];
            $user->phone = $data['phone'];
            $user->address = $data['address'];
            $user->address_number = $data['address_number'];
            $user->neighborhood = $data['neighborhood'];
            $user->state = $data['state'];
            $user->city = $data['city'];
            $user->cep = $data['cep'];
            $user->status = $data['status'];
            $user->id_plan = $data['plan'];
            $user->level = $data['level'];
            if ($user->save()) {
                $this->message->success("Usuário atualizado com sucesso")->flash();
                echo json_encode(['redirect' => $this->router->route('admin.users')]);
                return;
            }
            if ($user->fail()) {
                $json['message_error'] = "Erro ao atualizar o usuário";
                echo json_encode($json);
                return;
            }
            var_dump($user);
            return;
        }

        //DELETE
        if (isset($data['action']) && $data['action'] == "delete") {

        }

        $head = $this->seo->render(
            "Usuários | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("admin.users"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("users", [
            "head" => $head,
            "users" => $user->find()->order('id DESC')->fetch(true)
        ]);
    }

    /**
     * @param array|null $user
     */
    public function createUser(?array $user): void
    {
        $head = $this->seo->render(
            "Criar usuário | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("admin.createUser"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("createUser", [
            "head" => $head,
            "plans" => (new Plan())->find()->fetch(true)
        ]);
    }

    /**
     * @param array|null $data
     */
    public function updateUser(?array $data): void
    {
        if (!isset($data['id']) || !$user = (new User())->findById($data['id'])) {
            $this->message->error("Usuário não existe")->flash();
            $this->router->redirect('admin.users');
        }

        $head = $this->seo->render(
            "Editar usuário | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("admin.updateUser"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("updateUser", [
            "head" => $head,
            "plans" => (new Plan())->find()->fetch(true),
            "user" => $user,
            "history" => (new History())->find('id_user = :id', "id={$data['id']}")->order('created_at DESC')->fetch(true)
        ]);
    }

    /**
     * @param array|null $data
     */
    public function password(?array $data): void
    {
        $head = $this->seo->render(
            "Senha do administrador | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("admin.password"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("password", [
            "head" => $head,
        ]);
    }

    public function faq(?array $data)
    {
        $faqs = new Faq();

        if (isset($data['action']) && ($data['action'] == "create" || $data['action'] == "update")) {
            if (empty(trim($data['title']))) {
                $json['message_warning'] = "Preencha o campo '<b>Pergunta</b>' para continuar";
                echo json_encode($json);
                return;
            }
        }
        if (isset($data['action']) && $data['action'] == "create") {
            $faqs->title = $data['title'];
            $faqs->description = $data['description'];
            if ($faqs->save()) {
                $this->message->success("Faq adicionado com sucesso")->flash();
                echo json_encode(['refresh' => true]);
                return;
            }
            if ($faqs->fail()) {
                $json['message_error'] = "Erro ao adicionar FAQ, entre em contato com o suporte";
                echo json_encode($json);
                return;
            }
        }

        if (isset($data['action']) && $data['action'] == "update") {
            $faq = $faqs->findById($data['id']);
            $faq->title = $data['title'];
            $faq->description = $data['description'];
            if ($faq->save()) {
                $json['message_success'] = "FAQ atualizada com sucesso";
                echo json_encode($json);
                return;
            }
            if ($faq->fail()) {
                $json['message_error'] = "Erro ao atualizar FAQ, entre em contato com o suporte";
                echo json_encode($json);
                return;
            }
        }

        if (isset($data['action']) && $data['action'] == "delete") {
            $faq = $faqs->findById($data['id']);
            if ($faq->destroy()) {
                $this->message->success("Faq apagada com sucesso")->flash();
                echo json_encode(['refresh' => true]);
                return;
            }
            if ($faq->fail()) {
                $json['message_error'] = "Erro ao apagar FAQ, entre em contato com o suporte";
                echo json_encode($json);
                return;
            }
        }

        $head = $this->seo->render(
            "Perguntas frequentes | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("admin.faq"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("faq", [
            "head" => $head,
            "faqs" => $faqs->find()->fetch(true)
        ]);
    }

    public function dynamicFields(?array $data)
    {
        $dynamic_fields = (new DynamicFields())->find()->fetch();

        if (isset($data['action']) && $data['action'] == "update") {
            $dynamic_fields->title_of_call = $data['title_of_call'];
            $dynamic_fields->video_html = $data['video_html'];
            $dynamic_fields->notice_title = $data['notice_title'];
            if ($dynamic_fields->save()) {
                $json['message_success'] = "Atualizado com sucesso!";
                echo json_encode($json);
                return;
            }
            if ($dynamic_fields->fail()) {
                $json['message_error'] = "Erro ao salvar campos, entre em contato com o suporte";
                echo json_encode($json);
                return;
            }
            var_dump($data);
            return;
        }

        $head = $this->seo->render(
            "Campos dinâmicos | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("admin.dynamic.fields"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("dynamicFields", [
            "head" => $head,
            "dynamic_fields" => $dynamic_fields
        ]);
    }
}