<?php

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'db.php';

$phone_number = $_POST['phone_number'] ?? '';

if (empty($phone_number)) {
    echo json_encode([
        "success" => false,
        "message" => "Phone number kosong"
    ]);
    exit;
}

$sql = "
SELECT login_code
FROM user_231006
WHERE phone_number = ?
LIMIT 1
";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    echo json_encode([
        "success" => false,
        "message" => "Prepare query gagal"
    ]);
    exit;
}

mysqli_stmt_bind_param(
    $stmt,
    "s",
    $phone_number
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    echo json_encode([
        "success" => false,
        "message" => "Query gagal"
    ]);
    exit;
}

if (mysqli_num_rows($result) == 0) {
    echo json_encode([
        "success" => false,
        "message" => "Nomor tidak ditemukan",
        "phone_received" => $phone_number
    ]);
    exit;
}

$user = mysqli_fetch_assoc($result);

echo json_encode([
    "success" => true,
    "phone_received" => $phone_number,
    "login_code" => $user['login_code']
]);

exit;