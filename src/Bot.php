<?php

// DB.php faylini faqat bir marta chaqirish
require_once 'src/DB.php'; // Buni faqat bir marta chaqirish

class Bot {

    const API_URL = 'https://api.telegram.org/bot';

    private $token;

    public function __construct($token) {
        $this->token = $token;
    }

    // Telegram API bilan so'rov yuborish
    public function makeRequest($method, $data = []) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::API_URL . $this->token . '/' .  $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        curl_close($ch);
        var_dump($response); // Javobni tekshirish
    }

    // Foydalanuvchini saqlash
    public function saveUser($user_id, $username): bool {
        // Foydalanuvchi mavjudligini tekshirish
        if ($this->getUser($user_id)) {
            return false; // Agar foydalanuvchi mavjud bo'lsa, saqlanmaydi
        }

        $query = "INSERT INTO users (user_id, username) VALUES (:user_id, :username)"; // Yangi foydalanuvchini qo'shish
        $db = new DB(); // DB ulanishini yaratish
        $stmt = $db->conn->prepare($query); // Tayyorlangan so'rov
        return $stmt->execute([
            ':user_id' => $user_id,
            ':username' => $username
        ]);
    }

    // Foydalanuvchini olish
    public function getUser($user_id): bool|array {
        $query = "SELECT * FROM users WHERE user_id = :user_id"; // Tayyorlangan so'rov
        $db = new DB(); // DB ulanishini yaratish
        $stmt = $db->conn->prepare($query);
        $stmt->execute([
            ':user_id' => $user_id
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Barcha natijalarni olish
    }
}
?>
