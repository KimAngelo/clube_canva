<?php


namespace Source\Support;


/**
 * Class MercadoPago
 * @package Source\Support
 */
class MercadoPago
{
    private $endpoint;
    private $apiUrl;
    private $access_token;
    private $build;
    private $callback;

    public function __construct()
    {
        $this->apiUrl = env('MERCADOPAGO_URL_BASE');
        $this->access_token = env('MERCADOPAGO_ACCESS_TOKEN');
    }

    public function getPayment($id)
    {
        $this->endpoint = "/v1/payments/{$id}";
        $this->get();
        return $this;
    }

    private function get()
    {
        $url = $this->apiUrl . $this->endpoint;
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer {$this->access_token}"
            ],
        ]);

        $this->callback = json_decode(curl_exec($curl));
        curl_close($curl);
    }

    public function callback()
    {
        return $this->callback;
    }
}