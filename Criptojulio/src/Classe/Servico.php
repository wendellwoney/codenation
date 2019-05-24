<?php
/**
 * Created by PhpStorm.
 * User: wende
 * Date: 24/05/2019
 * Time: 09:29
 */

namespace Cripto\Classe;

class Servico
{
    const TOKEN = "";
    protected $url;
    protected $data;

    public function __construct($url = null)
    {
        $this->url = "https://api.codenation.dev/v1/challenge/dev-ps/" . $url;
    }

    public function send()
    {
        try {
            return file_get_contents($this->url);
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public function sendArquivo()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL, $this->url);
        $postData = array(
            'answer' => new \CURLFile('C:\xampp2\htdocs\Criptojulio\src\answer.json')
        );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        $response = curl_exec($ch);
        return $response;
    }
}