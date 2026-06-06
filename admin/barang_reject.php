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

<title>Barang Reject</title>

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

<h2>Data Barang Reject</h2>

<table class="table table-bordered">

<tr>

<th>Tanggal</th>
<th>Kode</th>
<th>Produk</th>
<th>Jumlah</th>
<th>Alasan</th>
<th>Keterangan</th>

</tr>

<?php

$data = mysqli_query(
$conn,
"
SELECT
br.*,
p.kode_barang,
p.nama_barang

FROM barang_reject br

JOIN produk p
ON p.id = br.produk_id

ORDER BY br.id DESC
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

<td>

<?= $d['alasan']; ?>

</td>

<td>

<?= $d['keterangan']; ?>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>