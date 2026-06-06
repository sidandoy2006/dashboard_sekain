<?php

session_start();
include '../config/koneksi.php';

$id = $_POST['produk_id'];
$jumlah = $_POST['jumlah'];

$alasan = $_POST['alasan'];
$keterangan = $_POST['keterangan'];

mysqli_query(
$conn,
"
INSERT INTO barang_reject
(
produk_id,
jumlah,
alasan,
keterangan,
tanggal
)
VALUES
(
'$id',
'$jumlah',
'$alasan',
'$keterangan',
NOW()
)
"
);

mysqli_query(
$conn,
"
UPDATE produk
SET stok = stok - $jumlah
WHERE id='$id'
"
);

header("Location: reject.php");