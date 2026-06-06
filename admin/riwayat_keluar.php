<?php

session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location: ../index.php");
}

?>

<!DOCTYPE html>
<html>
<head>

<title>Riwayat Keluar</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body>

<div class="container mt-4">

<a
href="dashboard.php"
class="btn btn-secondary mb-3">

← Dashboard

</a>

<h2>Riwayat Barang Keluar</h2>

<table class="table table-bordered">

<tr>

<th>Tanggal</th>
<th>Kode Barang</th>
<th>Nama Barang</th>
<th>Jumlah</th>

</tr>

<?php

$data = mysqli_query(
$conn,
"
SELECT
sk.*,
p.kode_barang,
p.nama_barang

FROM stok_keluar sk

JOIN produk p
ON sk.produk_id = p.id

ORDER BY sk.id DESC
"
);

while($d=mysqli_fetch_assoc($data)){

?>

<tr>

<td>

<?= date(
'd-m-Y H:i',
strtotime($d['tanggal'])
); ?>

</td>

<td>

<?= $d['kode_barang']; ?>

</td>

<td>

<?= $d['nama_barang']; ?>

</td>

<td>

<?= $d['jumlah']; ?>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>