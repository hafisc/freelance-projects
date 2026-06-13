<?php

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'db.php';

// Hilangkan output yang tidak sengaja
ob_clean();

$phone_number = $_POST['phone_number'] ?? '';
$login_code   = strtoupper(trim($_POST['login_code'] ?? ''));

if (empty($phone_number) || empty($login_code)) {
    echo json_encode([
        "success" => false,
        "message" => "Data tidak lengkap"
    ]);
    exit;
}

$sql = "
SELECT *
FROM user_231006
WHERE phone_number = ?
AND login_code = ?
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
    "ss",
    $phone_number,
    $login_code
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
        "message" => "Kode login salah"
    ]);
    exit;
}

$user = mysqli_fetch_assoc($result);

echo json_encode([
    "success" => true,
    "message" => "Login berhasil",
    "user" => [
        "id_user" => (int)$user['id_user'],
        "phone_number" => $user['phone_number']
    ]
]);

exit;