<?php
require_once __DIR__ . '/koneksi.php';

$result = $koneksi->query(
    'SELECT nim, nama, program_studi, alamat, jenis_kelamin, angkatan
     FROM mahasiswa ORDER BY nama ASC'
);

if (!$result) {
    die('Gagal mengambil data mahasiswa.');
}

$jumlah = $result->num_rows;

$pesan = $_GET['pesan'] ?? '';
$notifikasi = [
    'tambah' => 'Data mahasiswa berhasil ditambahkan.',
    'ubah' => 'Data mahasiswa berhasil diperbarui.',
    'hapus' => 'Data mahasiswa berhasil dihapus.',
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Data Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="topbar">
    <div class="container topbar-inner">
        <div class="brand-mark">SM</div>
        <div>
            <h1>Sistem Informasi Data Mahasiswa</h1>
            <p>Pengelolaan data mahasiswa</p>
        </div>
    </div>
</header>

<main class="container main-content">

    <?php if (isset($notifikasi[$pesan])): ?>
        <div class="alert success" role="status">
            <?= e($notifikasi[$pesan]) ?>
        </div>
    <?php elseif ($pesan === 'gagal'): ?>
        <div class="alert error" role="alert">
            Proses tidak dapat dilakukan. Silakan periksa kembali data.
        </div>
    <?php endif; ?>

    <section class="intro-row">
        <div>
            <span class="eyebrow">DASHBOARD</span>
            <h2>Data Mahasiswa</h2>
        </div>
        <a class="button primary" href="tambah.php">
            ＋ Tambah Mahasiswa
        </a>
    </section>

    <section class="stat-card">
        <div class="stat-icon">▤</div>
        <div>
            <p class="stat-label">Total Mahasiswa</p>
            <p class="stat-number"><?= (int) $jumlah ?></p>
        </div>
    </section>

    <section class="panel">
        <div class="panel-heading">
            <div>
                <h3>Daftar Mahasiswa</h3>
            </div>
            <span class="count-pill"><?= (int) $jumlah ?> data</span>
        </div>

        <?php if ($jumlah > 0): ?>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Program Studi</th>
                        <th>Alamat</th>
                        <th>Jenis Kelamin</th>
                        <th>Angkatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td class="nim"><?= e($row['nim']) ?></td>
                        <td><?= e($row['nama']) ?></td>
                        <td><?= e($row['program_studi']) ?></td>
                        <td><?= nl2br(e($row['alamat'])) ?></td>
                        <td><?= e($row['jenis_kelamin'] ?? '-') ?></td>
                        <td><?= e($row['angkatan'] ?? '-') ?></td>
                        <td>
                            <div class="actions">
                                <a class="button small edit"
                                   href="edit.php?nim=<?= rawurlencode($row['nim']) ?>">
                                    Edit
                                </a>

                                <form action="hapus.php" method="post"
                                    onsubmit="return confirm('Yakin ingin menghapus data mahasiswa ini?');">
                                    <input type="hidden" name="nim"
                                           value="<?= e($row['nim']) ?>">
                                    <button class="button small delete" type="submit">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon">▤</div>
                <h4>Belum ada data mahasiswa</h4>
                <p>Tambahkan data mahasiswa pertama untuk mulai menggunakan aplikasi.</p>
                <a class="button primary" href="tambah.php">
                    Tambah Mahasiswa
                </a>
            </div>
        <?php endif; ?>
    </section>
</main>

<footer class="footer">
    Sistem Informasi Data Mahasiswa
</footer>

</body>
</html>
