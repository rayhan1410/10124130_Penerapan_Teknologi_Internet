<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

//Cek jika pengguna mengganti bahasa VIA Url (?lang=id atau ?lang=en)
if(isset($_GET['lang'])){
    $lang=$_GET['lang'];
    if (in_array($lang,['id','en'])){
        $_SESSION['lang'] = $lang;
    }
}

//DEFAULT BAHASA INDONESIA
$current_lang = $_SESSION['lang'] ?? 'id';

//kamus bahasa
$translations = [
    'id' => [
        'title'         => 'Sistem Manajemen Inventaris Game',
        'login_title'   => 'Halaman Login',
        'username'      => 'Nama Pengguna',
        'password'      => 'Kata Sandi',
        'login_btn'     => 'Masuk',
        'logout'        => 'Keluar',
        'add_new'       => 'Tambah Game Baru',
        'table_title'   => 'Daftar Katalog Game',
        'col_title'     => 'Judul Game',
        'col_category'  => 'Kategori',
        'col_price'     => 'Harga Sewa / Hari',
        'col_stock'     => 'Stok',
        'col_action'    => 'Aksi',
        'edit'          => 'Ubah',
        'delete'        => 'Hapus',
        'save'          => 'Simpan',
        'back'          => 'Kembali',
        'confirm_del'   => 'Apakah Anda yakin ingin menghapus data ini?',
        'switch_lang'   => 'Ganti Bahasa'
    ],
    'en' => [
        'title'         => 'Game Inventory Management System',
        'login_title'   => 'Login Page',
        'username'      => 'Username',
        'password'      => 'Password',
        'login_btn'     => 'Login',
        'logout'        => 'Logout',
        'add_new'       => 'Add New Game',
        'table_title'   => 'Game Catalog List',
        'col_title'     => 'Game Title',
        'col_category'  => 'Category',
        'col_price'     => 'Rental Price / Day',
        'col_stock'     => 'Stock',
        'col_action'    => 'Action',
        'edit'          => 'Edit',
        'delete'        => 'Delete',
        'save'          => 'Save',
        'back'          => 'Back',
        'confirm_del'   => 'Are you sure you want to delete this data?',
        'switch_lang'   => 'Switch Language'
    ]
];

function __($key){
    global $translations, $current_lang;
    return $translations[$current_lang][$key] ?? $key;
}


?>
