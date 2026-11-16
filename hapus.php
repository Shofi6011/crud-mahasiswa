<?php
require_once __DIR__ . '/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$nim = trim($_POST['nim'] ?? '');
if ($nim === '') {
    header('Location: index.php?pesan=gagal');
    exit;
}

try {
    $stmt = $koneksi->prepare('DELETE FROM mahasiswa WHERE nim = ?');
    $stmt->bind_param('s', $nim);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header('Location: index.php?pesan=hapus');
    } else {
        header('Location: index.php?pesan=gagal');
    }
    exit;
} catch (mysqli_sql_exception $e) {
    error_log('Hapus mahasiswa gagal: ' . $e->getMessage());
    header('Location: index.php?pesan=gagal');
    exit;
}
