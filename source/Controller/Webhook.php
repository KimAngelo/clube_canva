<?php


namespace Source\Controller;


use Source\Core\View;
use Source\Models\Plan;
use Source\Models\User;
use Source\Support\Email;

class Webhook
{
    public function approvedPurchase(array $data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        file_put_contents('webhook.txt', print_r($_POST, true));

        if (!$data['transaction'] || $data['status'] != "approved" || !$data['prod'] || $data['hottok'] !== TOKEN_NOTIFICATION_HOTMART) {
            echo "Impossível cadastrar";
            exit();
        }

        $transaction = $data['transaction'];
        $status = $data['status'];
        $email = $data['email'];
        $first_name = $data['first_name'];
        $last_name = $data['last_name'];
        $address = $data['address'] ?? "";
        $address_number = $data['address_number'] ?? "";
        $address_complement = $data['address_comp'] ?? "";
        $neighborhood = $data['address_district'] ?? "";
        $city = $data['address_city'] ?? "";
        $state = $data['address_state'] ?? "";
        $cep = $data['address_zip_code'] ?? "";
        $transaction = $data['transaction'];
        $prod = $data['prod'];
        $name_plan = $data['name_subscription_plan'];

        $plan = (new Plan())->find("cod_hotmart = :cod AND name = :n", "cod={$prod}&n={$name_plan}")->fetch();
        if (!$plan) {
            file_put_contents('nao_encontrado.txt', print_r($_POST, true));
            exit();
        }

        $user = new User();

        /** @var  $find_user User */
        $find_user = $user->find("email = :e", "e={$email}")->fetch();
        //Se já existir o usuário cadastrado
        if ($find_user) {
            $find_user->status = 1;
            $find_user->id_plan = $plan->id;
            $find_user->save();
            echo "Pronto";
            exit();
        }
        $password_generate = generate_password(8, true, true, true, false);
        //Caso contrário, cadastra o usuário
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->email = $email;
        $user->password = passwd($password_generate);
        $user->level = 1;
        $user->address = $address;
        $user->address_number = $address_number;
        $user->address_complement = $address_complement;
        $user->neighborhood = $neighborhood;
        $user->state = $state;
        $user->city = $city;
        $user->cep = $cep;
        $user->status = 1;
        $user->id_plan = $plan->id;
        if ($user->save()) {
            //Envia o e-mail para o usuário com os dados de acesso
            $view = new View("", __DIR__ . "/../../shared/views/email");
            $message = $view->render("send_data_access", [
                "first_name" => $user->first_name,
                "email" => $user->email,
                "password" => $password_generate,
                "link" => url()
            ]);

            (new Email())->bootstrap(
                "Dados de acesso | " . CONF_SITE_NAME,
                $message,
                $user->email,
                "{$user->first_name} {$user->last_name}"
            )->send();

        }
    }

    public function refundedPurchase(array $data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        file_put_contents('webhook_refunded_purchase.txt', print_r($_POST, true));

        if (!$data['transaction'] || $data['status'] != "refunded" || !$data['prod'] || $data['hottok'] !== TOKEN_NOTIFICATION_HOTMART) {
            echo "Impossível cadastrar";
            exit();
        }
        /** @var  $user User */
        $user = (new User())->find('email = :e', "e={$data['email']}")->fetch();
        $user->status = 2;
        $user->save();
    }

    public function subscriptionCanceled(array $data)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($data['hottok'] !== TOKEN_NOTIFICATION_HOTMART) {
            exit();
        }
        $email = $data['userEmail'];
        $user = (new User())->find('email = :e', "e={$email}")->fetch();
        $user->status = 3;
        $user->save();
    }

    public function changePlan(array $data)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if ($data['hottok'] !== TOKEN_NOTIFICATION_HOTMART) {
            exit();
        }

        $email = $data['subscription']['subscriber']['user']['email'];
        $prod = $data['newSubscriptionPlan']['id'];
        $name_plan = $data['newSubscriptionPlan']['name'];

        $plan = (new Plan())->find('name = :n AND cod_hotmart = :cod', "n={$name_plan}&cod={$prod}")->fetch();
        if (!$plan) {
            echo "Não encontramos o plano";
            exit();
        }
        $user = (new User())->find('email = :e', "e={$email}")->fetch();
        if (!$user) {
            echo "Não encontramos o usuário";
            exit();
        }
        $user->status = 1;
        $user->id_plan = $plan->id;
        $user->save();
    }
}