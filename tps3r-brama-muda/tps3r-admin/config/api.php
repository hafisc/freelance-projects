<?php

define('API_BASE_URL', 'http://127.0.0.1:8000/api');

/**
 * Fungsi utama untuk menembak API backend Laravel
 *
 * @param string $method       Method HTTP (GET, POST, PUT, DELETE)
 * @param string $endpoint     Endpoint API (contoh: '/auth/login', '/reports')
 * @param array|false $data    Data array untuk dikirim (body/payload)
 * @param boolean $is_multipart Set true jika mengirim file/gambar (menggunakan form-data)
 * @return array               Response JSON dari API yang sudah di-decode ke bentuk Array
 */
function callAPI($method, $endpoint, $data = false, $is_multipart = false) {
    $curl = curl_init();
    $url = API_BASE_URL . $endpoint;

    // Header default (kita selalu mengharapkan balasan berupa JSON)
    $headers = [
        'Accept: application/json'
    ];

    // Jika admin sudah login (session token ada), sisipkan Authorization Bearer Token
    if (isset($_SESSION['auth_token'])) {
        $headers[] = 'Authorization: Bearer ' . $_SESSION['auth_token'];
    }

    // Setup parameter cURL berdasarkan tipe Method
    switch (strtoupper($method)) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data) {
                if ($is_multipart) {
                    // Jika kirim gambar (multipart/form-data), JANGAN di-encode ke JSON. Biarkan bentuk array.
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                } else {
                    // Jika data biasa, ubah ke format JSON dan tambahkan header Content-Type
                    $headers[] = 'Content-Type: application/json';
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                }
            }
            break;
            
        case "PUT":
            // Standar pengiriman data PUT biasa (JSON)
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            if ($data) {
                $headers[] = 'Content-Type: application/json';
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            }
            break;
            
        case "DELETE":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
            break;
            
        default: // GET
            // Jika ada data/parameter pencarian untuk GET, gabungkan ke dalam URL
            if ($data) {
                $url = sprintf("%s?%s", $url, http_build_query($data));
            }
    }

    // Konfigurasi eksekusi cURL
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // Agar hasil kembalian disimpan di variabel, bukan langsung di-print
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // Matikan verifikasi SSL sementara (berguna untuk localhost/ngrok)
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // Batas waktu tunggu maksimal 30 detik

    // Eksekusi cURL dan ambil informasinya
    $result = curl_exec($curl);
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $err = curl_error($curl);

    // Tutup koneksi cURL
    curl_close($curl);

    // Penanganan jika server mati atau request gagal terkirim (Timeout/Error Koneksi)
    if ($err) {
        return [
            'success' => false,
            'message' => 'Koneksi ke Server Gagal: ' . $err
        ];
    }

    // Ubah hasil balasan JSON dari API (string) menjadi Array Assosiatif PHP
    $response = json_decode($result, true);

    // Penanganan khusus jika API menolak akses karena Token Expired / Invalid (Status 401)
    if ($http_status == 401) {
        // Hapus session secara paksa karena token sudah tidak berlaku di backend
        unset($_SESSION['auth_token']);
        unset($_SESSION['user_data']);
        
        return [
            'success' => false,
            'message' => 'Sesi Anda telah berakhir. Silakan login kembali.',
            'force_logout' => true // Penanda khusus agar di UI admin nanti bisa otomatis di-redirect ke login
        ];
    }

    // Jika response tidak bisa dibaca (misal API error mengembalikan format HTML Laravel error 500)
    if ($response === null) {
         return [
            'success' => false,
            'message' => 'Terjadi kesalahan sistem di server API (Format tidak valid).'
        ];
    }

    return $response;
}
?>