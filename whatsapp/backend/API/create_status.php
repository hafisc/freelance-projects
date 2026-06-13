<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

$id_user = $data['id_user'] ?? '';
$media = $data['media'] ?? '';
$caption = $data['caption'] ?? '';

if (empty($id_user)) {
    echo json_encode([
        "success" => false,
        "message" => "ID User wajib dikirim"
    ]);
    exit;
}

$query = "
INSERT INTO status_231006
(
    id_user,
    media,
    caption
)
VALUES
(
    ?, ?, ?
)
";

$stmt = mysqli_prepare($conn, $query);

if (!$stmt) {
    echo json_encode([
        "success" => false,
        "message" => mysqli_error($conn)
    ]);
    exit;
}

mysqli_stmt_bind_param(
    $stmt,
    "iss",
    $id_user,
    $media,
    $caption
);

if (mysqli_stmt_execute($stmt)) {

    echo json_encode([
        "success" => true,
        "message" => "Status berhasil dibagikan",
        "id_status" => mysqli_insert_id($conn)
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => mysqli_stmt_error($stmt)
    ]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

?>
