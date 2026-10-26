<?php
require_once 'config/Tes_Koneksi.php';
require_once 'config/Modul_2Bahasa_&_Session.php';

//Proteksi Session Otentifikasi
if (!isset($_SESSION['user_id'])){
    header('Location: Halaman_Login_&_Autefikansi.php');
    exit();
}

//Fitur Delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset ($_GET['id'])){
    $id = (int)$_GET['id'];
    $delete_query = 'DELETE FROM games WHERE id =$id';
    mysqli_query($conn, $delete_query);
    header('location: index.php');
    exit();
}

//Fitur Read Data
$query = 'SELECT * FROM games ORDER BY id desc';
$result = mysqli_query($conn, $query);
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= __('tittle'); ?> </title>
</head>
<body>
    <div>
        <span><?= __('switch_lang'); ?> </span>
        <a href= '?lang=id'>Bahasa Indonesia</a> | <a href='?lang= en'>English</a>
        <span style='float: right;'>Halo, <b><?= htmlspecialchars($_SESSION['username']); ?></b> | <a href= 'logout.php'><?= __('logout'); ?></a></spam>
</div>

<h2><?= __('switch_lang'); ?></h2>
<a href='tambah.php'> + <?= __('add_new'); ?></a><br><br>

<table border="1" cellpadding='8' cellpadding='0'>
    <thead>
        <tr>
            <th>No</th>
            <th><?= __('col_tittle'); ?></th>
            <th><?= __('col_category'); ?></th>
            <th><?= __('col_price'); ?></th>
            <th><?= __('col_stock'); ?></th>
            <th><?= __('col_action'); ?></th>
</tr>
</thead>
<tbody>
    <?php $no =1; while ($row =mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($row['judul_game']) ?></td>
            <td><?= htmlspecialchars($row['kategori']) ?></td>
            <td>Rp <?=number_format($row['harga_sewa'], 0, ',', ','); ?></td>
            <td><?= htmlspecialchars($row['stok']); ?></td>
            <td>
                <a href = 'edit.php?id=<?= $row ['id']; ?>'><?= __('edit'); ?></a> |
                <a href = 'index.php?action=delete&id=<?= $row ['id']; ?>'onclick="return confirm('<?= __('confirm_del'); ?>')"><?= __('delete'); ?></a>
    </td>
    </tr>
    <?php endwhile;?>
    </tbody>
    </table>
</body>
</html>