<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require 'src/Bot.php';

$bot_token = '7638459284:AAE_9q_rqPFun5xt04Fbk0tmAO_mDVzKlnI';
$bot = new Bot($bot_token);

$update = json_decode(file_get_contents('php://input'), TRUE);

$text = isset($update['message']['text']) ? $update['message']['text'] : '';

$from_id = isset($update['message']['from']['id']) ? $update['message']['from']['id'] : '';

function sendMessage($chat_id, $message) {
    global $bot_token;
    $url = "https://api.telegram.org/bot$bot_token/sendMessage";
    $data = [
        'chat_id' => $chat_id,
        'text' => $message,
        'parse_mode' => 'HTML'
    ];
    file_get_contents($url . '?' . http_build_query($data)); // So'rov yuborish
}

if ($text == "/start") {
    $response = "Salom! Men sizga valyuta kurslarini yubora olishim mumkin. Faqat /currency komandasini yuboring.";
    sendMessage($from_id, $response);
}

if ($text == "/currency") {
    $api_url = "https://api.exchangerate-api.com/v4/latest/USD";

    $response = file_get_contents($api_url);
    $data = json_decode($response, true);

    if (isset($data['rates'])) {
        $rates = $data['rates'];

        $currency_list = "Valyuta kurslari (USD asosida):\n";
        foreach ($rates as $currency => $rate) {
            $currency_list .= $currency . ": " . $rate . "\n";
        }
        sendMessage($from_id, $currency_list);
    } else {
        sendMessage($from_id, "Xatolik yuz berdi! Valyuta kurslarini olishda muammo yuz berdi.");
    }
}

?>
