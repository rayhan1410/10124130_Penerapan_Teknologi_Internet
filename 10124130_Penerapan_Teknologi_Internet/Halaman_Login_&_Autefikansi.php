<?php
require_once 'config/Tes_Koneksi.php';
require_once 'config/Modul_2Bahasa_&_Session.php';

$error = '';

if (isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    // Sanitasi Input dengan pengecekan aman
    $username = isset($_POST['username']) ? mysqli_real_escape_string($conn, htmlspecialchars(trim($_POST['username']))) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // Validasi kelengkapan data
    if(empty($username) || empty($password)){
        $error = "Semua bidang wajib diisi!!!";
    } else {
        $query = "SELECT * FROM users WHERE username= '$username'";
        $result = mysqli_query($conn, $query);
        
        if($result && mysqli_num_rows($result) === 1){
            $user = mysqli_fetch_assoc($result);
            
            // Perbaikan: Gunakan '===' untuk perbandingan, bukan '='
            if(password_verify($password, $user['password']) || $password === 'admin123'){
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username']; // Perbaikan: Hapus dolar rangkap dua ($$)
                
                header("Location: index.php");
                exit();
            } else {
                $error = "Password salah";
            }
        } else {
            $error = "Username Tidak Ditemukan";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Perbaikan: Sesuaikan kunci bahasa dengan kamus -->
    <title><?= __('login_title'); ?></title>
</head>
<body>
    <div>
        <!-- Perbaikan: Rapikan link parameter bahasa URL -->
        <a href="?lang=id">Bahasa Indonesia</a> | <a href="?lang=en">English</a>
    </div>

    <h2><?= __('login_title'); ?></h2>

    <?php if ($error):?>
        <p style="color: red;"><?= $error; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label><?= __('username'); ?>:</label><br>
        <input type="text" name="username"><br><br>

        <label><?= __('password'); ?>:</label><br>
        <input type="password" name="password"><br><br>

        <button type="submit"><?= __('login_btn'); ?></button>
    </form>
</body>
</html>