<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once 'db.php';

$query = "
SELECT
    s.id_status,
    s.id_user,
    s.media,
    s.caption,
    s.created_at,
    u.business_name
FROM status_231006 s
INNER JOIN user_231006 u
ON s.id_user = u.id_user
ORDER BY s.created_at DESC
";

$result = mysqli_query($conn, $query);

$grouped = [];

while ($row = mysqli_fetch_assoc($result)) {

    $id_user = $row['id_user'];

    if (!isset($grouped[$id_user])) {

        $grouped[$id_user] = [
            "id_user" => $row["id_user"],
            "business_name" => $row["business_name"],
            "latest_media" => $row["media"],
            "latest_caption" => $row["caption"],
            "latest_time" => $row["created_at"],
            "statuses" => []
        ];
    }

    $grouped[$id_user]["statuses"][] = [
        "id_status" => $row["id_status"],
        "media" => $row["media"],
        "caption" => $row["caption"],
        "created_at" => $row["created_at"]
    ];
}

echo json_encode([
    "success" => true,
    "data" => array_values($grouped)
]);

mysqli_close($conn);

?>
