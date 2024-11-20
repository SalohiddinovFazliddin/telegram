<?php
// URLni tahlil qilish
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/');  // Oxirgi '/' ni olib tashlash

// URLga qarab kerakli faylni chaqirish
if ($uri == '/weather') {
    require "resources/weather.php";
} elseif ($uri == '/currency') {
    require "resources/currency-converter.php";
} elseif ($uri == '/telegram') {
    require "app/bot.php";
} else {
    // 404 xatolik sahifasi
    header("HTTP/1.1 404 Not Found");
    echo "404 - Sahifa topilmadi";
}
