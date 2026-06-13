<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

$phone_number   = $data['phone_number'] ?? '';
$otp_code       = $data['otp_code'] ?? '';
$business_name  = $data['business_name'] ?? '';
$category       = $data['category'] ?? '';
$business_hours = $data['business_hours'] ?? '';
$schedule       = $data['schedule'] ?? '';
$profile_photo  = $data['profile_photo'] ?? '';
$address        = $data['address'] ?? '';
$website        = $data['website'] ?? '';
$description    = $data['description'] ?? '';

if (
    empty($phone_number) ||
    empty($business_name)
) {
    echo json_encode([
        "success" => false,
        "message" => "Data wajib belum lengkap"
    ]);
    exit;
}

function generateLoginCode($length = 8)
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $loginCode = '';

    for ($i = 0; $i < $length; $i++) {
        $loginCode .= $characters[random_int(0, strlen($characters) - 1)];
    }

    return $loginCode;
}

$check_sql = "SELECT id_user
              FROM user_231006
              WHERE phone_number = ?";

$check_stmt = mysqli_prepare($conn, $check_sql);

mysqli_stmt_bind_param(
    $check_stmt,
    "s",
    $phone_number
);

mysqli_stmt_execute($check_stmt);

$check_result = mysqli_stmt_get_result($check_stmt);

if (mysqli_num_rows($check_result) > 0) {

    echo json_encode([
        "success" => false,
        "message" => "Nomor sudah terdaftar"
    ]);

    exit;
}

do {

    $login_code = generateLoginCode();

    $code_sql = "SELECT id_user
                 FROM user_231006
                 WHERE login_code = ?";

    $code_stmt = mysqli_prepare($conn, $code_sql);

    mysqli_stmt_bind_param(
        $code_stmt,
        "s",
        $login_code
    );

    mysqli_stmt_execute($code_stmt);

    $code_result = mysqli_stmt_get_result($code_stmt);

} while (mysqli_num_rows($code_result) > 0);

$sql = "INSERT INTO user_231006 (
    phone_number,
    otp_code,
    login_code,
    business_name,
    category,
    business_hours,
    schedule,
    profile_photo,
    address,
    website,
    description
) VALUES (
    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
)";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "sssssssssss",
    $phone_number,
    $otp_code,
    $login_code,
    $business_name,
    $category,
    $business_hours,
    $schedule,
    $profile_photo,
    $address,
    $website,
    $description
);

if (mysqli_stmt_execute($stmt)) {

    $id_user = mysqli_insert_id($conn);

    echo json_encode([
        "success" => true,
        "message" => "Registrasi berhasil",
        "id_user" => $id_user,
        "login_code" => $login_code,
        "phone_number" => $phone_number,
        "business_name" => $business_name
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => mysqli_error($conn)
    ]);

}
?>