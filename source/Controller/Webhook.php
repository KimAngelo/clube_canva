<?php


namespace Source\Controller;


use Source\Core\View;
use Source\Models\Plan;
use Source\Models\User;
use Source\Support\Email;
use Source\Support\MercadoPago;

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

    public function Hotmart()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $headers = apache_request_headers();

        //Salva dados em log
        file_put_contents(__DIR__ . '/../../logs/Hotmart.txt', print_r($data, true) . "----------------------------------------------------------", FILE_APPEND);

        if ($headers['x-hotmart-hottok'] !== TOKEN_NOTIFICATION_HOTMART) {
            echo "Impossível cadastrar";
            exit();
        }

        $user = new User();
        $event = $data['event'];

        //COMPRA APROVADA
        if ($event == "PURCHASE_APPROVED") {
            $email = $data['data']['buyer']['email'];
            $first_name = $data['data']['buyer']['first_name'];
            $last_name = $data['data']['buyer']['last_name'];

            $prod = $data['data']['product']['id'];
            $name_plan = $data['data']['subscription']['plan']['name'];

            $plan = (new Plan())->find("cod_reference = :cod AND name = :n", "cod={$prod}&n={$name_plan}")->fetch();
            if (!$plan) {
                file_put_contents(__DIR__ . '/../../logs/nao_encontrado_hotmart.txt', print_r($data, true) . "----------------------------------------------------------", FILE_APPEND);
                exit();
            }

            /** @var  $find_user User */
            $find_user = $user->find("email = :e", "e={$email}")->fetch();
            //Se já existir o usuário, apenas atualizamos
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
                exit();
            }
        }

        //TROCA DE PLANO
        if ($event == "SWITCH_PLAN") {
            $prod = $data['data']['subscription']['product']['id'];
            $name_plan = $data['data']['plans']['0']['name'];
            $email = $data['data']['subscription']['user']['email'];

            $plan = (new Plan())->find("cod_reference = :cod AND name = :n", "cod={$prod}&n={$name_plan}")->fetch();
            if (!$plan) {
                file_put_contents(__DIR__ . '/../../logs/nao_encontrado_hotmart.txt', print_r($data, true) . "----------------------------------------------------------", FILE_APPEND);
                exit();
            }
            $user = $user->findByEmail($email);
            $user->id_plan = $plan->id;
            $user->status = 1;
            $user->save();
            exit();
        }

        $email = $data['data']['buyer']['email'];
        $user = $user->findByEmail($email);

        //ASSINATURA REEMBOLSADA
        if ($event == "PURCHASE_REFUNDED") {
            $user->status = 2;
        }

        //CHARGEBACK
        if ($event == "PURCHASE_CHARGEBACK") {
            $user->status = 6;
        }

        //COMPRA CANCELADA
        if ($event == "PURCHASE_CANCELED") {
            $user->status = 3;
        }
        $user->save();
    }

    public function mercadoPago()
    {
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        $payment = filter_var($_GET['topic'], FILTER_SANITIZE_STRIPPED) == "payment" ? true : false;
        if ($id && $payment) {
            $data = (new MercadoPago())->getPayment($id)->callback();

            //Salva dados em log
            file_put_contents(__DIR__ . '/../../logs/Mercado_Pago.txt', print_r($data, true) . "----------------------------------------------------------", FILE_APPEND);

            $cod_reference_plan = $data->external_reference;
            $email = $data->payer->email;
            $first_name = $data->payer->first_name !== null ? $data->payer->first_name : "Sem nome";
            $last_name = $data->payer->last_name;
            $document_number = $data->payer->identification->number;

            //APROVADO
            if ($data->status == "approved") {
                //Seleciona o Plano
                $plan = (new Plan())->find('cod_reference = :cod_reference AND gateway = :gateway',
                    "cod_reference={$cod_reference_plan}&gateway=mercado_pago")->fetch();

                if (!$plan) {
                    file_put_contents(__DIR__ . '/../../logs/nao_encontrado_mercado_pago.txt', print_r($data, true) . "----------------------------------------------------------", FILE_APPEND);
                    exit();
                }

                $user = new User();

                /** @var  $find_user User */
                $find_user = $user->find("email = :e", "e={$email}")->fetch();
                //Se já existir o usuário cadastrado
                if ($find_user) {
                    $find_user->status = 1;
                    $find_user->id_plan = $plan->id;
                    $find_user->gateway = $plan->gateway;
                    $find_user->last_due = date('Y-m-d');
                    $find_user->next_due = date('Y-m-d', strtotime("{$plan->period}"));
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
                $user->status = 1;
                $user->last_due = date('Y-m-d H:i:s');
                $user->next_due = date('Y-m-d H:i:s', strtotime("{$plan->period}"));
                $user->id_plan = $plan->id;
                $user->document_number = $document_number;

                if ($user->save()) {
                    //Envia o e-mail para o usuário com os dados de acesso
                    $view = new View([], __DIR__ . "/../../shared/views/email");
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
                if ($user->fail()) {
                    var_dump($user->fail()->getMessage());
                }
            }

            $user = (new User())->findByEmail($email);

            //EM DISPUTA
            if ($data->status == "in_mediation") {
                $user->status = 5;
            }

            //CANCELADO
            if ($data->status == "cancelled") {
                $user->status = 3;
            }

            //PAGAMENTO DEVOLVIDO
            if ($data->status == "refunded") {
                $user->status = 2;
            }

            //CHARGEBACK
            if ($data->status == "charged_back") {
                $user->status = 6;
            }
            $user->save();
        }
    }
}