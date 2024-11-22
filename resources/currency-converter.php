<?php

$api_url = "https://api.exchangerate-api.com/v4/latest/USD"; // USD asosida kurslarni olish

$response = file_get_contents($api_url);
$data = json_decode($response, true);

$currencies = isset($data['rates']) ? $data['rates'] : [];

?>

<!doctype html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Valyuta Konvertori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .currency-card {
            max-width: 600px;
            margin: 0 auto;
            padding: 30px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .currency-section {
            padding: 60px 0;
        }

        .info-section {
            padding: 60px 0;
            text-align: center;
        }

        .btn-primary-custom {
            background-color: #d32f2f;
            border: none;
        }
    </style>
</head>
<body>
<div class="currency-section text-center pt-5 bg-primary-subtle">
    <h1>Valyuta Konvertori</h1>
    <p>Jahon bo'ylab biznes to'lovlaringizni oson va arzon amalga oshirish uchun valyuta kurslarini tekshirib chiqing.</p>
    <div class="currency-card">
        <h3>Tez va arzon xalqaro biznes to'lovlarini amalga oshiring</h3>
        <p>XX valyutalarda xavfsiz va arzon xalqaro to'lovlarni amalga oshiring, yashirin to'lovlar yo'q.</p>
        <form method="GET">
            <div class="row g-3 align-items-center">
                <div class="col-md-5">
                    <label for="amount" class="form-label visually-hidden">Miqdor</label>
                    <input type="number" id="amount" class="form-control" placeholder="Miqdor" value="10000" name="amount">
                </div>
                <div class="col-md-3 text-center">
                    <select class="form-select" name="from">
                        <?php
                        // Valyutalar ro'yxatini yaratish
                        foreach ($currencies as $key => $rate){
                            echo '<option value="' . $key . '">' . $key . '</option>';
                        }
                        ?>
                        <option value="UZS">UZS</option>
                    </select>
                </div>
                <div class="col-md-1 text-center">
                    <span>⇆</span>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="to">
                        <option value="UZS">UZS</option>
                        <?php
                        // Valyutalar ro'yxatini yaratish
                        foreach ($currencies as $key => $rate) {
                            echo '<option value="' . $key . '">' . $key . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <p class="rate-info mt-2">
                <?php
                // Valyuta konversiyasini hisoblash
                if (isset($_GET['amount']) && isset($_GET['from']) && isset($_GET['to'])) {
                    $amount = $_GET['amount'];
                    $from = $_GET['from'];
                    $to = $_GET['to'];

                    // Agar ikkala valyutadan bittasi "UZS" bo'lmasa xatolik chiqarish
                    if ($from != "UZS" && $to != "UZS") {
                        echo "Xatolik: Ikkalasidan bittasi UZS bo'lishi kerak.";
                    } else {
                        if ($from == "UZS") {
                            echo $amount / $currencies[$to];
                        } elseif ($to == "UZS") {
                            echo $amount * $currencies[$from];
                        } else {
                            $converted = ($amount * $currencies[$from]) / $currencies[$to];
                            echo $converted;
                        }
                    }
                }
                ?>
                <i class="bi bi-info-circle"></i></p>
            <button type="submit" class="btn btn-primary btn-primary-custom mt-3">Konvertatsiya qilish</button>
        </form>
    </div>
</div>
<div class="info-section bg-light">
    <h4 class="fw-bold">Vaqtingizni tejashga yordam beraylik</h4>
    <p class="text-muted">Agar maqsadli valyuta kursini bilsangiz, lekin bozor harakatlarini kuzatishga vaqtingiz bo'lmasa, qat'iy buyurtma to'g'ri variant bo'lishi mumkin. Siz tanlagan kursga erishilganda, biz darhol harakat qilamiz, shunda siz biznesingizga diqqat qaratishingiz mumkin.</p>
    <a href="/weather" class="btn btn-outline-danger">Ob-havo ma'lumotlari</a>
</div>
</body>
</html>
