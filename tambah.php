
<?php
require_once __DIR__ . '/koneksi.php';

$nim = $nama = $program_studi = $alamat = '';
$jenis_kelamin = '';
$angkatan = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = trim($_POST['nim'] ?? '');
    $nama = trim($_POST['nama'] ?? '');
    $program_studi = trim($_POST['program_studi'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');
    $jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
    $angkatan = trim($_POST['angkatan'] ?? '');

    if (
        $nim === '' || $nama === '' ||
        $program_studi === '' || $alamat === '' ||
        $jenis_kelamin === '' || $angkatan === ''
    ) {
        $error = 'Semua kolom wajib diisi.';
    } elseif (
        strlen($nim) > 15 ||
        strlen($nama) > 100 ||
        strlen($program_studi) > 100
    ) {
        $error = 'Panjang NIM, nama, atau program studi melebihi batas.';
    } elseif (!in_array($jenis_kelamin, ['Laki-laki', 'Perempuan'], true)) {
        $error = 'Jenis kelamin tidak valid.';
    } elseif (
        !preg_match('/^\d{4}$/', $angkatan) ||
        (int)$angkatan < 1901 ||
        (int)$angkatan > 2155
    ) {
        $error = 'Angkatan harus berupa tahun yang valid.';
    } else {
        try {
            $stmt = $koneksi->prepare(
                'INSERT INTO mahasiswa
                (nim, nama, program_studi, alamat, jenis_kelamin, angkatan)
                VALUES (?, ?, ?, ?, ?, ?)'
            );

            $stmt->bind_param(
                'ssssss',
                $nim,
                $nama,
                $program_studi,
                $alamat,
                $jenis_kelamin,
                $angkatan
            );

            $stmt->execute();

            header('Location: index.php?pesan=tambah');
            exit;

        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() === 1062) {
                $error = 'NIM tersebut sudah terdaftar. Gunakan NIM yang berbeda.';
            } else {
                error_log('Tambah mahasiswa gagal: ' . $e->getMessage());
                $error = 'Data gagal disimpan. Silakan coba kembali.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<header class="topbar">
    <div class="container topbar-inner">
        <div class="brand-mark">SM</div>
        <div>
            <h1>Sistem Informasi Data Mahasiswa</h1>
            <p>Pengelolaan data mahasiswa secara sederhana</p>
        </div>
    </div>
</header>

<main class="container form-page">

    <a class="back-link" href="index.php">
        ← Kembali ke daftar mahasiswa
    </a>

    <section class="form-card">
        <span class="eyebrow">FORMULIR DATA</span>
        <h2>Tambah Mahasiswa</h2>

        <p class="form-description">
            Lengkapi informasi berikut untuk menambahkan data mahasiswa.
        </p>

        <?php if ($error !== ''): ?>
            <div class="alert error" role="alert">
                <?= e($error) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="tambah.php">

            <div class="form-group">
                <label for="nim">NIM</label>
                <input
                    type="text"
                    id="nim"
                    name="nim"
                    maxlength="15"
                    value="<?= e($nim) ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="nama">Nama Mahasiswa</label>
                <input
                    type="text"
                    id="nama"
                    name="nama"
                    maxlength="100"
                    value="<?= e($nama) ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="program_studi">Program Studi</label>
                <input
                    type="text"
                    id="program_studi"
                    name="program_studi"
                    maxlength="100"
                    value="<?= e($program_studi) ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea
                    id="alamat"
                    name="alamat"
                    rows="4"
                    required
                ><?= e($alamat) ?></textarea>
            </div>

            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="Laki-laki"
                        <?= $jenis_kelamin === 'Laki-laki' ? 'selected' : '' ?>>
                        Laki-laki
                    </option>
                    <option value="Perempuan"
                        <?= $jenis_kelamin === 'Perempuan' ? 'selected' : '' ?>>
                        Perempuan
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label for="angkatan">Angkatan</label>
                <input
                    type="number"
                    id="angkatan"
                    name="angkatan"
                    min="1901"
                    max="2155"
                    placeholder="Contoh: 2024"
                    value="<?= e($angkatan) ?>"
                    required
                >
            </div>

            <div class="form-actions">
                <a class="button secondary" href="index.php">
                    Kembali
                </a>

                <button class="button primary" type="submit">
                    Simpan Data
                </button>
            </div>

        </form>
    </section>
</main>

<footer class="footer">
    Sistem Informasi Data Mahasiswa
</footer>

</body>
</html>
