<?php

class Weather {
    private $api_key = '1f2c4527291b18aaab758440a1f8e071';  // OpenWeather API kaliti
    private $base_url = 'https://api.openweathermap.org/data/2.5/weather'; // API URL

    public $weather_data = [];

    // Funksiya ob-havo ma'lumotlarini olish
    public function __construct($city) {
        // Viloyat nomi bo'yicha URLni yaratamiz
        $url = $this->base_url . '?q=' . urlencode($city) . '&appid=' . $this->api_key . '&units=metric&lang=uz';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);

        $this->weather_data = json_decode($response, true);  // Ma'lumotni array sifatida saqlash
    }

    // Funksiya ob-havo ma'lumotlarini olish
    public function getWeather() {
        return $this->weather_data;
    }
}

?>
