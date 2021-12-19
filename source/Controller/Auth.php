<?php


namespace Source\Controller;


use Source\Core\Controller;
use Source\Core\Session;
use Source\Core\View;
use Source\Models\User;
use Source\Support\Email;

/**
 * Class Auth
 * @package Source\Controller
 */
class Auth extends Controller
{
    /**
     * Auth constructor.
     * @param $router
     */
    public function __construct($router)
    {
        parent::__construct($router, __DIR__ . "/../../themes/" . CONF_VIEW_APP . "/");
    }

    /**
     * @param array|null $data
     * Controlador de Login
     */
    public function login(?array $data): void
    {
        if ((new Session())->has('authUser')) {
            $this->router->redirect('app.home');
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
            $user = (new User())->find('email = :e AND status = :s', "e={$data['email']}&s=1")->fetch();
            if (!$user || !passwd_verify($data['password'], $user->password)) {
                $json['message'] = $this->message->warning('E-mail e/ou senha incorreto, tente novamente')->render();
                echo json_encode($json);
                return;
            }

            (new Session())->set('authUser', $user->id);
            if ($user->first_access == 0) {
                $json['redirect'] = $this->router->route('auth.update_password');
            } else {
                $json['redirect'] = $this->router->route('app.home');
            }
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            "Entrar | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("auth.login"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            true
        );

        echo $this->view->render("auth/login", [
            "head" => $head,
        ]);
    }

    /**
     * @param array|null $data
     * Atualizar senha no primeiro acesso
     */
    public function updatePassword(?array $data): void
    {
        $session = new Session();
        if (!$session->has('authUser')) {
            $this->router->redirect('auth.login');
        }
        $user = (new User())->findById($session->authUser);

        if ($user->first_access == 1) {
            $this->router->redirect('app.home');
        }

        if (isset($data['csrf'])) {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            if (!csrf_verify($data)) {
                $json['message'] = $this->message->error("Ooops! Tente novamente mais tarde!")->render();
                echo json_encode($json);
                return;
            }

            if (!is_passwd($data['password'])) {
                $json['message'] = $this->message->warning("Sua senha deve ter no mínimo " . CONF_PASSWD_MIN_LEN . " caracteres")->render();
                echo json_encode($json);
                return;
            }
            if ($data['password'] !== $data['password_re']) {
                $json['message'] = $this->message->warning("As senhas não conferem, digite novamente")->render();
                echo json_encode($json);
                return;
            }

            $user->first_access = 1;
            $user->password = passwd($data['password']);
            $user->save();

            $json['redirect'] = $this->router->route('app.home');
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            "Alterar senha do primeiro acesso | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("auth.forget"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("auth/updatePassword", [
            "head" => $head,
        ]);
    }

    public function logout()
    {
        (new Session())->destroy();
        $this->router->redirect('auth.login');
    }

    /**
     * @param array|null $data
     * Controlador esqueci minha senha
     */
    public function forget(?array $data): void
    {
        if ((new Session())->has('authUser')) {
            $this->router->redirect('app.home');
        }

        if (isset($data['csrf'])) {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            if (!csrf_verify($data)) {
                $json['message'] = $this->message->error("Ooops! Tente novamente mais tarde!")->render();
                echo json_encode($json);
                return;
            }
            if (request_reapeat("authforget", $data['email'])) {
                $json['message'] = $this->message->error("Ooops! Você já tentou este e-mail antes")->render();
                echo json_encode($json);
                return;
            }
            if (empty($data["email"])) {
                $json['message'] = $this->message->warning("Informe seu e-mail para continuar")->render();
                echo json_encode($json);
                return;
            }

            if (!is_email($data['email'])) {
                $json['message'] = $this->message->warning(" Forneça um e-mail válido")->render();
                echo json_encode($json);
                return;
            }

            $user = (new User())->find("email = :email AND status = :s", "email={$data['email']}&s=1")->fetch();
            if (!$user) {
                $json['message'] = $this->message->warning(" O e-mail informado não está cadastrado.")->render();
                echo json_encode($json);
                return;
            }

            $user->forget = md5(uniqid(rand(), true));
            $user->save();

            $view = new View($this->router, __DIR__ . "/../../shared/views/email");
            $message = $view->render("forget", [
                "first_name" => $user->first_name,
                "forget_link" => $this->router->route('auth.recover', ['code' => "{$user->email}|{$user->forget}"])
            ]);

            $mail = (new Email())->bootstrap(
                "Recupere o seu acesso | " . CONF_SITE_NAME,
                $message,
                $user->email,
                "{$user->first_name} {$user->last_name}"
            );
            if (!$mail->send()) {
                $json['message'] = $mail->message()->render();
                echo json_encode($json);
                return;
            }
            $json['message'] = $this->message->success("Acesse seu e-mail para recuperar a senha")->render();

            echo json_encode($json);
            return;

        }

        $head = $this->seo->render(
            "Recuperar senha | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("auth.forget"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("auth/forget", [
            "head" => $head,
        ]);
    }

    /**
     * @param array|null $data
     * Controlador para recuperar senha
     */
    public function recover(?array $data): void
    {
        if ((new Session())->has('authUser')) {
            $this->router->redirect('app.home');
        }

        if (isset($data['csrf'])) {
            if (!csrf_verify($data)) {
                $json["message"] = $this->message->error("Ooops! Tente novamente mais tarde!")->render();
                echo json_encode($json);
                return;
            }

            if (empty($data["password"]) || empty($data["password_re"])) {
                $json["message"] = $this->message->info("Informe e repita a senha para continuar")->render();
                echo json_encode($json);
                return;
            }

            list($email, $code) = explode("|", $data["code"]);
            $user = (new User())->find("email = :email", "email={$email}")->fetch();


            if (!$user) {
                $json["message"] = $this->message->error("A conta para recuperação não foi encontrada.")->render();
                echo json_encode($json);
                return;
            }

            if ($user->forget != $code) {
                $json["message"] = $this->message->error("Desculpe, mas o código de verificação não é válido.")->render();
                echo json_encode($json);
                return;
            }

            if (!is_passwd($data['password'])) {
                $min = CONF_PASSWD_MIN_LEN;
                $max = CONF_PASSWD_MAX_LEN;
                $json["message"] = $this->message->info("Sua senha deve ter entre {$min} e {$max} caracteres.")->render();
                echo json_encode($json);
                return;
            }

            if ($data['password'] != $data['password_re']) {
                $json["message"] = $this->message->warning("Você informou duas senhas diferentes.")->render();
                echo json_encode($json);
                return;
            }

            $user->password = passwd($data['password']);
            $user->forget = null;
            $user->save();

            (new Session())->unset('authforget');

            $this->message->success("Senha alterada com sucesso! Acesse com a sua nova senha")->flash();
            echo json_encode(["redirect" => $this->router->route('auth.login')]);
            return;
        }

        $head = $this->seo->render(
            "Restaurar senha | " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            $this->router->route("auth.recover"),
            image(CONF_SITE_SHARE, 1200, 630, CONF_UPLOAD_IMAGE_DIR_SITE),
            false
        );

        echo $this->view->render("auth/recover", [
            "head" => $head,
            "code" => $data["code"]
        ]);
    }
}