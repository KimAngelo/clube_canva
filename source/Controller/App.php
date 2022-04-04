<?php


namespace Source\Controller;


use Source\Core\Controller;
use Source\Core\Session;
use Source\Core\View;
use Source\Models\Art;
use Source\Models\ArtCategory;
use Source\Models\Blog\Post;
use Source\Models\Caption;
use Source\Models\Category;
use Source\Models\DynamicFields;
use Source\Models\Faq;
use Source\Models\FavoriteCategory;
use Source\Models\History;
use Source\Models\Pack;
use Source\Models\User;
use Source\Support\Email;
use Source\Support\OpenAI;
use Source\Support\Pager;

/**
 * Class App
 * @package Source\Controller
 */
class App extends Controller
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @var \CoffeeCode\DataLayer\DataLayer|null
     */
    private $user;

    /**
     * App constructor.
     * @param $router
     */
    public function __construct($router)
    {
        $this->session = new Session();
        /*$this->session->destroy();*/
        if (!$this->user = User::user()) {
            $router->redirect('auth.login');
        }

        /*(new Access())->report();
        (new Online())->report();*/
        $data = [
            'router' => $router,
            'packs' => (new Pack())->all(),
            "categories_pop_up" => (new Category())->popup()
        ];
        parent::__construct($data, __DIR__ . "/../../themes/" . CONF_VIEW_APP . "/");
    }

    /**
     * Controlador da página inicial
     */
    public function home()
    {

        if (empty($this->user->favorite_categories)) {
            $this->message->info("Selecione suas categorias favoritas, isso nos ajuda a melhorar a plataforma pra você 😊")->flash();
            $this->router->redirect('app.favorite.categories');
        }

        $head = $this->seo->render(
            CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("app.home"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("home", [
            "head" => $head,
            "featured_categories" => (new Category())->featured_categories(),
            "arts" => (new Art())->find('', '', 'id, name, thumb')->order('id DESC')->limit(24)->fetch(true)
        ]);
    }

    /**
     * @param array|null $data
     * Controlador de pesquisa
     */
    public function search(?array $data): void
    {
        if (!isset($_GET['s']) || empty(trim($_GET['s']))) {
            $this->router->redirect('app.home');
        }

        $s = filter_input(INPUT_GET, 's', FILTER_SANITIZE_STRIPPED);

        $page = isset($_GET['page']) ? filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT) : 1;
        $art = new Art();

        $arts = $art->find('MATCH (name, description) AGAINST (:s)', "s={$s}", "id, name, thumb");
        $pager = new Pager(
            $this->router->route('app.search', ['s' => $s, 'page' => '']),
            "Página", ["Primeira Página", "«"], ["Última Página", "»"]);
        $pager->pager($arts->count(), 24, $page, 2);

        $arts = $arts->offset($pager->offset())->limit($pager->limit())->order('id DESC')->fetch(true);

        $head = $this->seo->render(
            "{$s} | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("app.search"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("search", [
            "head" => $head,
            "arts" => $arts,
            "render" => $pager->render(),
            "s" => $s
        ]);
    }

    /**
     * @param array|null $data
     */
    public function category(?array $data): void
    {
        $slug = filter_var($data['slug'], FILTER_SANITIZE_STRIPPED);
        if (!$category = (new Category())->find('slug = :s', "s={$slug}")->fetch()) {
            $this->router->redirect('app.home');
        }

        $page = isset($_GET['page']) ? filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT) : 1;


        $arts_categories = new ArtCategory();
        $count = $arts_categories->count_arts($category->id);

        $pager = new Pager(
            $this->router->route('app.category', ['slug' => $slug, 'page' => '']),
            "Página", ["Primeira Página", "«"], ["Última Página", "»"]);
        $pager->pager($count->total, 24, $page, 2);

        $arts = $arts_categories->arts_categories($category->id, $pager->limit(), $pager->offset());

        $head = $this->seo->render(
            "{$category->name} | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("app.category"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("category", [
            "head" => $head,
            "arts" => $arts,
            "render" => $pager->render(),
            "name_category" => $category->name
        ]);
    }

    /**
     * @param array|null $data
     */
    public function pack(?array $data): void
    {
        $slug = filter_var($data['slug'], FILTER_SANITIZE_STRIPPED);
        if (!$pack = (new Pack())->find('slug = :s', "s={$slug}")->fetch()) {
            $this->router->redirect('app.home');
        }

        $page = isset($_GET['page']) ? filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT) : 1;
        $art = new Art();
        $arts = $art->find('id_pack = :id', "id={$pack->id}", "id, name, thumb");

        $pager = new Pager(
            $this->router->route('app.pack', ['slug' => $slug, 'page' => '']),
            "Página", ["Primeira Página", "«"], ["Última Página", "»"]);
        $pager->pager($arts->count(), 24, $page, 2);

        $arts = $arts->offset($pager->offset())->limit($pager->limit())->order('id DESC')->fetch(true);

        $head = $this->seo->render(
            "{$pack->name} | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("app.pack"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("pack", [
            "head" => $head,
            "arts" => $arts,
            "render" => $pager->render(),
            "name_pack" => $pack->name
        ]);
    }

    /**
     * @param array|null $data
     * Lista de tutoriais
     */
    public function tutorials(?array $data): void
    {
        $page = isset($_GET['page']) ? filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT) : 1;
        $tutorials = new Post();
        $tutorial = $tutorials->find("status = :s AND type = :t", "s=post&t=tutorial", "id, title, slug, description, cover");

        $pager = new Pager(
            $this->router->route('app.tutorials', ['page' => '']),
            "Página", ["Primeira Página", "«"], ["Última Página", "»"]);
        $pager->pager($tutorial->count(), 12, $page, 2);

        $tutorials = $tutorial->offset($pager->offset())->limit($pager->limit())->order('id DESC')->fetch(true);

        $head = $this->seo->render(
            "Tutoriais | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("app.tutorials"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("tutorials", [
            "head" => $head,
            "tutorials" => $tutorials,
            "render" => $pager->render()
        ]);
    }

    /**
     * @param array|null $data
     * Página do tutorial
     */
    public function tutorial(?array $data): void
    {
        if (!$tutorial = (new Post())->find("slug = :s AND status = :status AND type = :t", "s={$data['slug']}&status=post&t=tutorial")->fetch()) {
            $this->router->redirect('app.tutorials');
        }
        $tutorial->views += 1;
        $tutorial->save();

        $head = $this->seo->render(
            "{$tutorial->title} | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("app.tutorial"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("tutorial", [
            "head" => $head,
            "tutorial" => $tutorial
        ]);
    }

    /**
     * @param array|null $data
     */
    public function profile(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        if (isset($data['action']) && $data['action'] == "update") {
            if (empty(trim($data['first_name'])) || empty(trim($data['last_name']))) {
                $json['message_warning'] = "Preencha os campos nome e sobrenome";
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
                $this->user->password = passwd($data['password']);
            }
            $this->user->first_name = $data['first_name'];
            $this->user->last_name = $data['last_name'];
            $this->user->document_number = $data['document_number'];
            $this->user->phone = $data['phone'];
            $this->user->address = $data['address'];
            $this->user->address_number = $data['address_number'];
            $this->user->neighborhood = $data['neighborhood'];
            $this->user->state = $data['state'];
            $this->user->city = $data['city'];
            $this->user->cep = $data['cep'];
            if ($this->user->save()) {
                $this->message->success("Seus dados pessoais foram atualizados com sucesso {$this->user->first_name} :)")->flash();
                echo json_encode(['refresh' => true]);
                return;
            }
            if ($this->user->fail()) {
                $json['message_error'] = "Erro ao atualizar os dados, favor entrar em contato com o suporte";
                echo json_encode($json);
                return;
            }
        }
        $head = $this->seo->render(
            "Perfil | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("app.profile"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("profile", [
            "head" => $head,
            "user" => $this->user
        ]);
    }

    /**
     * @param array|null $data
     */
    public function today(?array $data): void
    {
        $history = new History();
        $array = [];
        $date = date_fmt('now', CONF_DATE_APP);
        $history = $history->find('id_user = :id_user AND DATE(created_at) = DATE(:date)', "id_user={$this->user->id}&date={$date}")->fetch(true);
        if ($history) {
            foreach ($history as $item) {
                $array[] = (new Art())->find('id = :id', "id={$item->id_art}")->fetch();
            }
        }

        $head = $this->seo->render(
            "Seus Downloads de hoje | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("app.today"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("today", [
            "head" => $head,
            "arts" => $array
        ]);
    }


    /**
     * @param array $data
     */
    public function openArt(array $data): void
    {
        $id = filter_var($data['id'], FILTER_VALIDATE_INT);
        $arts = new Art();
        $history = new History();
        if (!$id || !$art = $arts->findById($data['id'])) {
            $this->message->error("Essa arte não existe")->flash();
            $this->router->redirect('app.home');
        }
        $date = date_fmt('now', CONF_DATE_APP);
        if ($count = $history->find('id_user = :id_user AND DATE(created_at) = DATE(:date) AND id_art = :id_art', "id_user={$this->user->id}&date={$date}&id_art={$id}")->count()) {
            redirect($art->link_template);
        }

        if ($this->user->artBalance() <= 0) {
            $this->message->warning("Seu limite diário de artes esgotou, faça um upgrade para continuar")->flash();
            $this->router->redirect('app.home');
        }
        $history->id_user = $this->user->id;
        $history->id_art = $id;
        $history->name = $art->name;
        $history->link_download = $art->link_template;
        $history->save();
        redirect($art->link_template);
    }

    /**
     * @param array|null $data
     */
    public function support(?array $data): void
    {
        if (isset($data['message'])) {
            $message = filter_var($data['message'], FILTER_SANITIZE_STRIPPED);
            if (empty(trim($message))) {
                $json['message_warning'] = "Digite uma mensagem para continuar";
                echo json_encode($json);
                return;
            }
            $view = new View($this->router, __DIR__ . "/../../shared/views/email");
            $message = $view->render("support", [
                "first_name" => $this->user->first_name,
                "email" => $this->user->email,
                "cod" => $this->user->id,
                "message" => $message
            ]);

            $mail = (new Email())->bootstrap(
                "Suporte | " . CONF_SITE_NAME,
                $message,
                CONF_MAIL_SUPPORT,
                CONF_MAIL_SENDER["name"]
            );
            if (!$mail->send()) {
                $json['message_error'] = "Erro ao enviar o e-mail, tente novamente mais tarde";
                echo json_encode($json);
                return;
            }
            $this->message->success("Sua mensagem foi enviado para o suporte {$this->user->first_name}, em breve você será respondido(a)")->flash();
            echo json_encode(["refresh" => true]);
            return;


        }

        $head = $this->seo->render(
            "Suporte | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("app.support"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("support", [
            "head" => $head,
            "dynamic_fields" => (new DynamicFields())->find()->fetch(),
            "faqs" => (new Faq())->find()->fetch(true)
        ]);
    }

    public function favoriteCategories(?array $data)
    {
        $categories = new Category();

        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['action']) && $data['action'] == "add_favorite") {
            $array_user = explode(';', $this->user->favorite_categories);

            /** @var  $favorite_category FavoriteCategory */
            $favorite_category = (new FavoriteCategory())->find("id_user = :id_user AND id_category = :id_category",
                "id_user={$this->user->id}&id_category={$data['id_category']}")->fetch();

            //Remove dos favoritos
            if ($favorite_category) {
                //Procura o id da categoria dentro do array
                if (($key = array_search($data['id_category'], $array_user)) !== false) {
                    unset($array_user[$key]);
                }
                $this->user->favorite_categories = !in_array('', $array_user) ? implode(';', $array_user) : "";
                $this->user->save();
                $favorite_category->destroy();
                return;
            }

            //Adiciona a categoria aos favoritos
            $favorite_category = new FavoriteCategory();
            $favorite_category->id_user = $this->user->id;
            $favorite_category->id_category = $data['id_category'];
            $favorite_category->save();

            $this->user->favorite_categories = in_array('', $array_user) ? $data['id_category'] : implode(';', array_merge([$data['id_category']], $array_user));
            $this->user->save();
            return;
        }

        $head = $this->seo->render(
            "Categorias Favoritas | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("app.favorite.categories"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("favoriteCategories", [
            "head" => $head,
            "favorite_categories" => explode(';', $this->user->favorite_categories)
        ]);
    }

    public function newCaption(?array $data)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['action']) && $data['action'] == 'generate') {
            if (empty(trim($data['description'])) || strlen(trim($data['description'])) < 20) {
                echo json_encode(['message_warning' => 'Me passe mais detalhes sobre o seu produto ou serviço para gerar uma legenda com mais qualidade']);
                return;
            }
            $array_language = ['1', '2'];
            if (!isset($data['language']) || !in_array($data['language'], $array_language)) {
                echo json_encode(['message_warning' => 'Selecione a linguagem para gerar sua legenda']);
                return;
            }
            $language = $data['language'] == 1 ? "formal" : "informal";
            $credit_caption = env('CREDIT_CAPTION');
            if ($this->user->credit_caption < $credit_caption) {
                $this->message->info("{$this->user->first_name}, você não possui saldo suficiente em créditos para gerar uma nova legenda, entre em contato com o suporte para adquirir mais créditos")->flash();
                echo json_encode(['refresh' => true]);
                return;
            }
            if (isset($data['emoji'])) {
                if ($data['emoji'] == 'true') {
                    $emoji = ' com emojis';
                } else {
                    $emoji = '';
                }
            }
            $prompt_caption = "Escreva um texto para facebook com linguagem {$language}{$emoji} sobre: {$data['description']}";

            $openai_caption = (new OpenAI())->davinci0001(
                $prompt_caption,
                0,
                400,
                0,
                0,
                1
            )->callback();
            if (isset($openai_caption->choices)) {
                $caption_return = trim($openai_caption->choices[0]->text);
                //Gerar Hashtag
                $hashtag_caption = "Escreva hashtags para instagram sobre: {$data['description']}";
                $openai_hashtag = (new OpenAI())->davinci0001(
                    $hashtag_caption,
                    0,
                    100,
                    0,
                    0,
                    1
                )->callback();

                if (isset($openai_hashtag->choices)) {
                    $caption_return .= "\n\n" . trim($openai_hashtag->choices[0]->text);
                }

                $caption = new Caption();
                $caption->description = $data['description'];
                $caption->language = $data['language'];
                $caption->credit = $credit_caption;
                $caption->caption = $caption_return;
                $caption->id_user = $this->user->id;
                $caption->id_openai = $openai_caption->id;
                $caption->model_openai = $openai_caption->model;
                $caption->save();
                if ($caption->fail()) {
                    echo $caption->fail()->getMessage();
                    return;
                }

                $this->user->credit_caption -= $credit_caption;
                $this->user->save();

                echo json_encode(['success' => true, 'caption' => $caption_return, 'balance' => $this->user->credit_caption]);
                return;
            }
            echo json_encode(['message_error' => "{$this->user->first_name}, não consegui gerar sua legenda, entre em contato com o suporte para te ajudar ok :)"]);
            return;
        }
        $head = $this->seo->render(
            "Gerar legenda para rede social | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("app.new.caption"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("newCaption", [
            "head" => $head
        ]);
    }

    public function myCaptions()
    {
        $captions = (new Caption())->find("id_user = :id_user", "id_user={$this->user->id}")->order("created_at DESC")->fetch(true);
        if (empty($captions)) {
            $this->router->redirect('app.new.caption');
        }
        $head = $this->seo->render(
            "Minhas legendas | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("app.my.captions"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("myCaptions", [
            "head" => $head,
            "captions" => $captions
        ]);
    }

    public function error($data)
    {
        var_dump($data);
    }
}