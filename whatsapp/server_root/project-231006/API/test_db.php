<?php
include 'db.php';

if ($conn) {
    echo json_encode([
        "success" => true,
        "message" => "Database connected"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Database failed"
    ]);
}