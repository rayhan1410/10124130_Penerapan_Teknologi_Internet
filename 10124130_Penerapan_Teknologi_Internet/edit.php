<?php
// Panggil koneksi dan modul bahasa/session
require_once 'config/Tes_Koneksi.php';
require_once 'config/Modul_2Bahasa_&_Session.php';

// Proteksi: Jika belum login, lempar balik ke halaman login
if (!isset($_SESSION['user_id'])) {
    header("Location: Halaman_Login_&_Autefikasi.php"); // Sesuaikan nama file login kamu
    exit();
}

// Ambil ID dari URL, pastikan ada dan berupa angka (identitas unik)
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data lama berdasarkan ID untuk ditampilkan di form
$query_get = "SELECT * FROM games WHERE id = $id";
$res = mysqli_query($conn, $query_get);
$data = mysqli_fetch_assoc($res);

// Jika data tidak ditemukan di database, kembalikan ke index.php
if (!$data) {
    header("Location: index.php");
    exit();
}

$error = '';

// Proses saat tombol submit/simpan diklik
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitasi data input
    $judul_game = htmlspecialchars(trim($_POST['judul_game']));
    $kategori   = htmlspecialchars(trim($_POST['kategori']));
    $harga_sewa = filter_var($_POST['harga_sewa'], FILTER_VALIDATE_INT);
    $stok       = filter_var($_POST['stok'], FILTER_VALIDATE_INT);

    // Validasi Percabangan (if-else)
    if (empty($judul_game) || empty($kategori) || $harga_sewa === false || $stok === false) {
        $error = "Semua bidang wajib diisi dengan format data yang benar!";
    } else {
        // Amankan string untuk query database
        $judul_clean = mysqli_real_escape_string($conn, $judul_game);
        $kategori_clean = mysqli_real_escape_string($conn, $kategori);

        // Query Update (Mengubah data berdasarkan identitas unik ID)
        $query_update = "UPDATE games SET judul_game = '$judul_clean', kategori = '$kategori_clean', harga_sewa = $harga_sewa, stok = $stok WHERE id = $id";
        
        if (mysqli_query($conn, $query_update)) {
            // Jika berhasil, alihkan kembali ke halaman utama
            header("Location: index.php");
            exit();
        } else {
            $error = "Gagal memperbarui data: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ubah Data Game</title>
</head>
<body>
    <h2>Ubah Data Game</h2>

    <!-- Tampilkan pesan error jika validasi gagal -->
    <?php if ($error): ?>
        <p style="color: red;"><?= $error; ?></p>
    <?php endif; ?>

    <!-- Form Edit dengan nilai default data yang sudah ada di database -->
    <form method="POST" action="">
        <label>Judul Game:</label><br>
        <input type="text" name="judul_game" value="<?= htmlspecialchars($data['judul_game']); ?>"><br><br>

        <label>Kategori:</label><br>
        <input type="text" name="kategori" value="<?= htmlspecialchars($data['kategori']); ?>"><br><br>

        <label>Harga Sewa / Hari:</label><br>
        <input type="number" name="harga_sewa" value="<?= $data['harga_sewa']; ?>"><br><br>

        <label>Stok:</label><br>
        <input type="number" name="stok" value="<?= $data['stok']; ?>"><br><br>

        <button type="submit">Simpan Perubahan</button>
        <a href="index.php">Kembali</a>
    </form>
</body>
</html>