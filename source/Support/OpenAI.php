<?php


namespace Source\Support;


class OpenAI
{
    private $endpoint;
    private $apiUrl;
    private $key;
    private $build;
    private $callback;

    public function __construct()
    {
        $this->apiUrl = env('OPENAI_ENDPOINT');
        $this->key = env('OPENAI_KEY');
    }

    public function davinci0001($prompt, $temperature, $max_tokens, $frequency_penalty, $presence_penalty, $n)
    {
        $this->endpoint = '/v1/engines/text-davinci-001/completions';
        $this->build = [
            'prompt' => $prompt,
            'temperature' => $temperature,
            'max_tokens' => $max_tokens,
            'frequency_penalty' => $frequency_penalty,
            'presence_penalty' => $presence_penalty,
            'n' => $n
        ];
        $this->post();
        return $this;
    }

    public function post()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiUrl . $this->endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($this->build),
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer " . $this->key,
                "Content-Type: application/json"
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