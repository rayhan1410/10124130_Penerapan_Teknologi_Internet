<?php
// Panggil koneksi dan modul bahasa/session
require_once 'config/Tes_Koneksi.php';
require_once 'config/Modul_2Bahasa_&_Session.php';

// Proteksi: Jika belum login, lempar balik ke halaman login
if (!isset($_SESSION['user_id'])) {
    header("Location: Halaman_Login_&_Autefikasi.php"); // Sesuaikan nama file login kamu
    exit();
}

$error = '';

// Proses saat tombol submit/simpan diklik
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitasi data input (htmlspecialchars & filter_var)
    $judul_game = htmlspecialchars(trim($_POST['judul_game']));
    $kategori   = htmlspecialchars(trim($_POST['kategori']));
    $harga_sewa = filter_var($_POST['harga_sewa'], FILTER_VALIDATE_INT);
    $stok       = filter_var($_POST['stok'], FILTER_VALIDATE_INT);

    // Validasi Percabangan (if-else) untuk kelengkapan data
    if (empty($judul_game) || empty($kategori) || $harga_sewa === false || $stok === false) {
        $error = "Semua bidang harus diisi dengan format data yang benar!";
    } else {
        // Amankan string untuk query database
        $judul_clean = mysqli_real_escape_string($conn, $judul_game);
        $kategori_clean = mysqli_real_escape_string($conn, $kategori);

        // Query Create (Insert data ke database)
        $query = "INSERT INTO games (judul_game, kategori, harga_sewa, stok) VALUES ('$judul_clean', '$kategori_clean', $harga_sewa, $stok)";
        
        if (mysqli_query($conn, $query)) {
            // Jika berhasil, alihkan kembali ke halaman utama (index.php)
            header("Location: index.php");
            exit();
        } else {
            $error = "Gagal menyimpan data: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><– Tambah Data Game –></title>
</head>
<body>
    <h2>Tambah Data Game Baru</h2>

    <!-- Tampilkan pesan error jika validasi gagal -->
    <?php if ($error): ?>
        <p style="color: red;"><?= $error; ?></p>
    <?php endif; ?>

    <!-- Form Input menggunakan metode POST -->
    <form method="POST" action="">
        <label>Judul Game:</label><br>
        <input type="text" name="judul_game"><br><br>

        <label>Kategori:</label><br>
        <input type="text" name="kategori"><br><br>

        <label>Harga Sewa / Hari:</label><br>
        <input type="number" name="harga_sewa"><br><br>

        <label>Stok:</label><br>
        <input type="number" name="stok"><br><br>

        <button type="submit">Simpan</button>
        <a href="index.php">Kembali</a>
    </form>
</body>
</html>