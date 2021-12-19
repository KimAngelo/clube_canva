<?php

namespace Source\Controller\Admin;

use Source\Core\Controller;
use Source\Core\Session;
use Source\Models\User;

/**
 * Class Auth
 * @package Source\Controller\Admin
 */
class Auth extends Controller
{
    /**
     * Auth constructor.
     * @param $router
     */
    public function __construct($router)
    {
        $data = ['router' => $router];
        parent::__construct($data, __DIR__ . "/../../../themes/" . CONF_VIEW_ADMIN . "/");
    }

    /**
     * @param array|null $data
     */
    public function login(?array $data): void
    {
        if ((new Session())->has('adminUser')) {
            $this->router->redirect('admin.dash');
        }

        if (isset($data['csrf']) && !empty($data['csrf'])) {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            if (!csrf_verify($data)) {
                $json['message'] = $this->message->error('Ooops! Ocorreu um erro, entre em contato com o suporte')->render();
                echo json_encode($json);
                return;
            }
            if (in_array("", $data)) {
                $json['message'] = $this->message->warning('Informe seu e-mail e senha para continuar')->render();
                echo json_encode($json);
                return;
            }
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $json['message'] = $this->message->warning('Informe seu e-mail correto para continuar')->render();
                echo json_encode($json);
                return;
            }
            if (!is_passwd(trim($data['password']))) {
                $json['message'] = $this->message->warning('Senha incorreta, tente outra vez')->render();
                echo json_encode($json);
                return;
            }
            $user = (new User())->find('email = :e AND status = :s AND level = :l', "e={$data['email']}&s=1&l=5")->fetch();
            if (!$user || !passwd_verify($data['password'], $user->password)) {
                $json['message'] = $this->message->warning('E-mail e/ou senha incorreto, tente novamente')->render();
                echo json_encode($json);
                return;
            }

            (new Session())->set('adminUser', $user->id);
            $json['redirect'] = $this->router->route('admin.dash');
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            "Admin | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("admin.auth_login"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("login", [
            "head" => $head,
        ]);
    }


    /**
     * @param array|null $data
     */
    public function error(?array $data): void
    {
        $head = $this->seo->render(
            "Página não encontrada | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("admin.error"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("error", [
            "head" => $head,
            "error" => $data['errcode']
        ]);
    }

}