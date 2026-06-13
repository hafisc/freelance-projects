<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'db.php';

$phone_number = $_POST['phone_number'] ?? '';

if (empty($phone_number)) {
    echo json_encode([
        "success" => false,
        "message" => "Nomor telepon wajib diisi"
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| CEK USER TERDAFTAR
|--------------------------------------------------------------------------
*/

$check = mysqli_query(
    $conn,
    "SELECT * FROM user_231006
     WHERE phone_number='$phone_number'"
);

if (mysqli_num_rows($check) == 0) {
    echo json_encode([
        "success" => false,
        "message" => "Nomor telepon belum terdaftar"
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| GENERATE LOGIN CODE 8 KARAKTER
|--------------------------------------------------------------------------
*/

$login_code = strtoupper(
    substr(
        str_shuffle(
            'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'
        ),
        0,
        8
    )
);

/*
|--------------------------------------------------------------------------
| SIMPAN LOGIN CODE KE DATABASE
|--------------------------------------------------------------------------
*/

mysqli_query(
    $conn,
    "UPDATE user_231006
     SET login_code='$login_code'
     WHERE phone_number='$phone_number'"
);

/*
|--------------------------------------------------------------------------
| KIRIM KE WHATSAPP FONNTE
|--------------------------------------------------------------------------
*/

$token = "xwKD6fizpDBaQrY8jyUk";

$message =
"Kode Login WhatsApp Business Clone

Kode Login:
$login_code

Masukkan kode ini pada halaman login.

Jangan bagikan kode ini kepada siapa pun.";

$data = [
    "target" => $phone_number,
    "message" => $message,
];

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.fonnte.com/send",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query($data),
    CURLOPT_HTTPHEADER => [
        "Authorization: $token"
    ]
]);

$response = curl_exec($curl);

curl_close($curl);

echo json_encode([
    "success" => true,
    "message" => "Kode login berhasil dikirim",
    "login_code" => $login_code,
    "fonnte_response" => json_decode(
        $response,
        true
    )
]);

?>