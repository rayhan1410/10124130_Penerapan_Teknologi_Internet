<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "sewa_games";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn){
    die("Koneksi Gagal: " . mysqli_connect_error());
}
?>