<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>

<div class="container text-center">
    <h1 class="my-4">Viloyatning Ob-havo Ma'lumotlari</h1>

    <!-- Viloyat nomini kiritish uchun forma -->
    <form method="POST">
        <div class="mb-3">
            <label for="city" class="form-label">Viloyat nomini kiriting:</label>
            <input type="text" class="form-control" id="city" name="city" required>
        </div>
        <button type="submit" class="btn btn-primary">Ob-havo ma'lumotlarini olish</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require "src/Weather.php";

        // Foydalanuvchi kiritgan viloyat nomi
        $city = $_POST['city'];

        // OpenWeather API'dan ob-havo ma'lumotlarini olish
        $weather = new Weather($city);
        $data = $weather->getWeather();

        if (isset($data['weather'][0])) {
            // Agar ma'lumotlar to'g'ri qaytsa, ob-havo ma'lumotlarini ko'rsatish
            echo '<div class="weather-card text-center mt-4">';
            echo '<h2>' . $city . ' uchun ob-havo:</h2>';
            echo '<div class="mb-3">';
            echo '<img src="https://openweathermap.org/img/wn/' . $data['weather'][0]['icon'] . '@2x.png" alt="Weather Icon" class="weather-icon">';
            echo '</div>';
            echo '<h3>' . $data['main']['temp'] . '°C</h3>';
            echo '<p>' . $data['weather'][0]['description'] . '</p>';
            echo '<div class="d-flex justify-content-around">';
            echo '<div><h5>Namlik</h5><p>' . $data['main']['humidity'] . '%</p></div>';
            echo '<div><h5>Bosim</h5><p>' . $data['main']['pressure'] . ' hPa</p></div>';
            echo '<div><h5>Shamol</h5><p>' . $data['wind']['speed'] . ' m/s</p></div>';
            echo '</div>';
            echo '</div>';
        } else {
            // Agar viloyat topilmasa, xatolikni ko'rsatish
            echo '<div class="alert alert-danger mt-4">Viloyat topilmadi yoki noto\'g\'ri nom kiritildi.</div>';
        }
    }
    ?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
