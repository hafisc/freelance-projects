<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "project_231006";

$conn = mysqli_connect(
    $host,
    $user,
    $password,
    $database
);

if (!$conn) {
    die(
        json_encode([
            "success" => false,
            "message" => "Koneksi database gagal"
        ])
    );
}

?>