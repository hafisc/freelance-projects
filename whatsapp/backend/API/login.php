<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

$phone_number = $data['phone_number'] ?? '';
$login_code = $data['login_code'] ?? '';

if (
    empty($phone_number) ||
    empty($login_code)
) {
    echo json_encode([
        "success" => false,
        "message" => "Nomor telepon dan login code wajib diisi"
    ]);
    exit;
}

$sql = "SELECT *
        FROM user_231006
        WHERE phone_number = ?
        AND login_code = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "ss",
    $phone_number,
    $login_code
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {

    $user = mysqli_fetch_assoc($result);

    echo json_encode([
        "success" => true,
        "message" => "Login berhasil",
        "user" => $user
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Nomor telepon atau login code salah"
    ]);

}
?>