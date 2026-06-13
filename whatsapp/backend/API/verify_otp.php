<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'db.php';

/*
|--------------------------------------------------------------------------
| AMBIL DATA
|--------------------------------------------------------------------------
*/

$phone_number = trim($_POST['phone_number'] ?? '');
$otp_code     = trim($_POST['otp_code'] ?? '');

if (
    empty($phone_number) ||
    empty($otp_code)
) {
    echo json_encode([
        "success" => false,
        "message" => "Data tidak lengkap"
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| CEK OTP
|--------------------------------------------------------------------------
*/

$sql = "
SELECT *
FROM otp_requests
WHERE phone_number = ?
AND otp_code = ?
LIMIT 1
";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "ss",
    $phone_number,
    $otp_code
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {

    echo json_encode([
        "success" => false,
        "message" => "OTP salah"
    ]);

    exit;
}

$otpRow = mysqli_fetch_assoc($result);

/*
|--------------------------------------------------------------------------
| CEK EXPIRED
|--------------------------------------------------------------------------
*/

$current_time = date('Y-m-d H:i:s');

if ($current_time > $otpRow['expired_at']) {

    echo json_encode([
        "success" => false,
        "message" => "OTP sudah kadaluarsa"
    ]);

    exit;
}

/*
|--------------------------------------------------------------------------
| HAPUS OTP SETELAH BERHASIL DIPAKAI
|--------------------------------------------------------------------------
*/

$deleteOtp = mysqli_prepare(
    $conn,
    "DELETE FROM otp_requests WHERE id = ?"
);

mysqli_stmt_bind_param(
    $deleteOtp,
    "i",
    $otpRow['id']
);

mysqli_stmt_execute($deleteOtp);

/*
|--------------------------------------------------------------------------
| CEK USER
|--------------------------------------------------------------------------
*/

$userQuery = mysqli_prepare(
    $conn,
    "
    SELECT *
    FROM user_231006
    WHERE phone_number = ?
    LIMIT 1
    "
);

mysqli_stmt_bind_param(
    $userQuery,
    "s",
    $phone_number
);

mysqli_stmt_execute($userQuery);

$userResult = mysqli_stmt_get_result($userQuery);

$user = mysqli_fetch_assoc($userResult);

/*
|--------------------------------------------------------------------------
| JIKA USER BELUM ADA -> AUTO REGISTER
|--------------------------------------------------------------------------
*/

if (!$user) {

    $insertUser = mysqli_prepare(
        $conn,
        "
        INSERT INTO user_231006 (
            phone_number
        )
        VALUES (
            ?
        )
        "
    );

    mysqli_stmt_bind_param(
        $insertUser,
        "s",
        $phone_number
    );

    if (!mysqli_stmt_execute($insertUser)) {

        echo json_encode([
            "success" => false,
            "message" => "Gagal membuat akun"
        ]);

        exit;
    }

    $newUserId = mysqli_insert_id($conn);

    /*
    |--------------------------------------------------------------------------
    | AMBIL USER BARU
    |--------------------------------------------------------------------------
    */

    $newUserQuery = mysqli_prepare(
        $conn,
        "
        SELECT *
        FROM user_231006
        WHERE id_user = ?
        LIMIT 1
        "
    );

    mysqli_stmt_bind_param(
        $newUserQuery,
        "i",
        $newUserId
    );

    mysqli_stmt_execute($newUserQuery);

    $newUserResult = mysqli_stmt_get_result(
        $newUserQuery
    );

    $user = mysqli_fetch_assoc(
        $newUserResult
    );
}

/*
|--------------------------------------------------------------------------
| RESPONSE BERHASIL
|--------------------------------------------------------------------------
*/

echo json_encode([
    "success" => true,
    "message" => "OTP valid",
    "user" => [
        "id_user"        => $user["id_user"],
        "phone_number"   => $user["phone_number"] ?? "",
        "business_name"  => $user["business_name"] ?? "",
        "category"       => $user["category"] ?? "",
        "business_hours" => $user["business_hours"] ?? "",
        "schedule"       => $user["schedule"] ?? "",
        "profile_photo"  => $user["profile_photo"] ?? "",
        "address"        => $user["address"] ?? "",
        "website"        => $user["website"] ?? "",
        "description"    => $user["description"] ?? ""
    ]
]);

mysqli_close($conn);

?>