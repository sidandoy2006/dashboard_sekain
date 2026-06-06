<?php

session_start();
include '../config/koneksi.php';

$id = $_POST['produk_id'];
$jumlah = $_POST['jumlah'];

$cek = mysqli_query(
$conn,
"SELECT * FROM produk
WHERE id='$id'"
);

$produk = mysqli_fetch_assoc($cek);

if($produk['stok'] < $jumlah){

    echo "Stok tidak cukup";
    exit;
}

mysqli_query(
$conn,
"
UPDATE produk
SET stok = stok - $jumlah
WHERE id='$id'
"
);

mysqli_query(
$conn,
"
INSERT INTO stok_keluar
(
produk_id,
jumlah,
tanggal
)
VALUES
(
'$id',
'$jumlah',
NOW()
)
"
);

header("Location: keluar.php");