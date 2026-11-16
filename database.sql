CREATE DATABASE IF NOT EXISTS db_mahasiswa
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_mahasiswa;

CREATE TABLE IF NOT EXISTS mahasiswa (
    nim VARCHAR(15) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    program_studi VARCHAR(100) NOT NULL,
    alamat TEXT NOT NULL,
    PRIMARY KEY (nim)
) ENGINE=InnoDB;

-- Contoh data awal (opsional). Hapus tanda komentar untuk menggunakannya.
-- INSERT INTO mahasiswa (nim, nama, program_studi, alamat) VALUES
-- ('24781001', 'Andi Saputra', 'Manajemen Informatika', 'Bandar Lampung'),
-- ('24781002', 'Siti Rahma', 'Teknologi Rekayasa Perangkat Lunak', 'Metro');
