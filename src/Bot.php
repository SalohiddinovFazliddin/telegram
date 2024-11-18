<?php


class Bot {

    const API_URL = 'https://api.telegram.org/bot';

    private $token = "7638459284:AAE_9q_rqPFun5xt04Fbk0tmAO_mDVzKlnI";

    public function makeRequest($method, $data = []) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::API_URL . $this->token . '/' .  $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        curl_close($ch);
        var_dump($response);
    }
}
//$bot = new Bot();

