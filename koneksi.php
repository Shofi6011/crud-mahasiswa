<?php
declare(strict_types=1);

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'db_mahasiswa';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $koneksi = new mysqli($host, $username, $password, $database);
    $koneksi->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    error_log('Koneksi database gagal: ' . $e->getMessage());
    http_response_code(500);
    exit('Koneksi database gagal. Periksa konfigurasi pada koneksi.php dan pastikan MySQL aktif.');
}

function e(?string $value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
