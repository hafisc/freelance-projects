<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'db.php';

$phone_number = $_POST['phone_number'] ?? '';

if (empty($phone_number)) {

    $fonnte = json_decode($response, true);

echo json_encode([
    "success" => $fonnte['status'] ?? false,
    "otp_code" => $otp_code,
    "fonnte_response" => $fonnte
]);

    exit;
}

$otp_code = rand(100000, 999999);

$expired_at = date(
    'Y-m-d H:i:s',
    strtotime('+5 minutes')
);

/*
|--------------------------------------------------------------------------
| HAPUS OTP LAMA
|--------------------------------------------------------------------------
*/

mysqli_query(
    $conn,
    "DELETE FROM otp_requests
     WHERE phone_number='$phone_number'"
);

/*
|--------------------------------------------------------------------------
| SIMPAN OTP BARU
|--------------------------------------------------------------------------
*/

mysqli_query(
    $conn,
    "INSERT INTO otp_requests
    (
        phone_number,
        otp_code,
        expired_at
    )
    VALUES
    (
        '$phone_number',
        '$otp_code',
        '$expired_at'
    )"
);

/*
|--------------------------------------------------------------------------
| KIRIM WHATSAPP FONNTE
|--------------------------------------------------------------------------
*/

$token = "xwKD6fizpDBaQrY8jyUk";

$message =
"Kode OTP WhatsApp Business Clone

OTP: $otp_code

Berlaku 5 menit.

Jangan bagikan kode ini kepada siapa pun.";

$data = [
    "target" => $phone_number,
    "message" => $message
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
    "otp_code" => $otp_code,
    "expired_at" => $expired_at,
    "fonnte_response" => json_decode($response, true)
]);
?>