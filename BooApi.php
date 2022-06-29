<?php

class BooApi
{
    protected $baseApiUrl;
    protected $apiKey;

    public function __construct($apiKey, $baseApiUrl)
    {
        $this->apiKey     = $apiKey;
        $this->baseApiUrl = $baseApiUrl;
    }

    protected function makeRequest($options)
    {
        $options[CURLOPT_SSL_VERIFYHOST] = 0;
        $options[CURLOPT_SSL_VERIFYPEER] = 0;
        $curl = curl_init();
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        if ($response === false) {
            throw new Exception(curl_error($curl), curl_errno($curl));
        }
        curl_close($curl);
        return json_decode($response, true);
    }

    public function createTask(array $data)
    {
        $options = [
            CURLOPT_URL            => "$this->baseApiUrl/task/?key=$this->apiKey",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => json_encode($data),
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
        ];
        return $this->makeRequest($options);
    }

    public function getTaskStatus($taskId)
    {
        $options = [
            CURLOPT_URL            => "$this->baseApiUrl/task/status/$taskId?key=$this->apiKey",
            CURLOPT_RETURNTRANSFER => true,
        ];
        return $this->makeRequest($options);
    }

    public function getTaskResults($taskId, $limit = 100, $offset = 0)
    {
        $options = [
            CURLOPT_URL            => "$this->baseApiUrl/task/results/$taskId?key=$this->apiKey&limit=$limit&offset=$offset",
            CURLOPT_RETURNTRANSFER => true,
        ];
        return $this->makeRequest($options);
    }
}
