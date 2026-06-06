<?php

session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location: ../index.php");
}

$data = mysqli_query(
$conn,
"SELECT * FROM produk
ORDER BY nama_barang ASC"
);

?>

<!DOCTYPE html>
<html>
<head>

<title>Cetak Barcode</title>

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

<h2>Cetak Barcode Produk</h2>

<table class="table table-bordered">

<tr>

<th>Kode</th>
<th>Produk</th>
<th>Barcode</th>

</tr>

<?php while($d=mysqli_fetch_assoc($data)){ ?>

<tr>

<td>

<?= $d['kode_barang']; ?>

</td>

<td>

<?= $d['nama_barang']; ?>

</td>

<td>

<a
href="print_barcode.php?id=<?= $d['id']; ?>"
target="_blank"
class="btn btn-success btn-sm">

Cetak Barcode

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>