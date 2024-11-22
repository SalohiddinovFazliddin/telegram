<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require 'src/Bot.php';

$bot_token = '7638459284:AAE_9q_rqPFun5xt04Fbk0tmAO_mDVzKlnI'; // Tokeningizni kiriting
$bot = new Bot($bot_token);

$update = json_decode(file_get_contents('php://input'), TRUE);

$text = isset($update['message']['text']) ? $update['message']['text'] : '';
$from_id = isset($update['message']['from']['id']) ? $update['message']['from']['id'] : '';
$username = isset($update['message']['from']['username']) ? $update['message']['from']['username'] : '';

function sendMessage($chat_id, $message) {
    global $bot_token;
    $url = "https://api.telegram.org/bot$bot_token/sendMessage";
    $data = [
        'chat_id' => $chat_id,
        'text' => $message,
        'parse_mode' => 'HTML'
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_exec($ch);
    curl_close($ch);
}

if ($text == "/start") {
    // Foydalanuvchini saqlash
    if ($bot->saveUser($from_id, $username)) {
        $response = "Salom! Men sizga valyuta kurslarini yubora olishim mumkin. Faqat /currency komandasini yuboring.";
        sendMessage($from_id, $response);
    } else {
        $response = "Siz allaqachon ro'yxatdan o'tgansiz!";
        sendMessage($from_id, $response);
    }
}

if ($text == "/currency") {
    $api_url = "https://api.exchangerate-api.com/v4/latest/USD";

    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

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

if (strpos($text, "/weather") === 0) {
    $city = trim(substr($text, 8));
    if (empty($city)) {
        $response = "Iltimos, shahar nomini kiriting. Masalan: /weather Toshkent";
        sendMessage($from_id, $response);
    } else {
        $api_key = 'your_openweather_api_key'; // O'zingizning API kalitingizni kiriting
        $api_url = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$api_key&units=metric&lang=uz";

        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);

        if (isset($data['main'])) {
            $temp = $data['main']['temp'];
            $weather_description = $data['weather'][0]['description'];
            $humidity = $data['main']['humidity'];
            $wind_speed = $data['wind']['speed'];

            $weather_info = "Ob-havo ma'lumotlari ($city):\n";
            $weather_info .= "Harorat: $temp °C\n";
            $weather_info .= "Ob-havo: $weather_description\n";
            $weather_info .= "Namlik: $humidity%\n";
            $weather_info .= "Shamol tezligi: $wind_speed m/s\n";

            sendMessage($from_id, $weather_info);
        } else {
            sendMessage($from_id, "Xatolik yuz berdi! $city shahri uchun ob-havo ma'lumotlarini olishda muammo yuz berdi.");
        }
    }
}
?>
