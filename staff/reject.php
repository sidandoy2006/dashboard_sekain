<?php

session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location: ../index.php");
}

$produk = null;

if(isset($_POST['cari'])){

    $kode = $_POST['kode_barang'];

    $query = mysqli_query(
        $conn,
        "SELECT * FROM produk
        WHERE kode_barang='$kode'"
    );

    $produk = mysqli_fetch_assoc($query);
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

<h2>❌ Barang Reject</h2>

<form method="POST">

<input
type="text"
name="kode_barang"
class="form-control mb-2"
placeholder="Scan Barcode">

<button
name="cari"
class="btn btn-danger">

Cari

</button>

</form>

<?php if($produk){ ?>

<hr>

<div class="card">

<div class="card-body">

<h4><?= $produk['nama_barang']; ?></h4>

<form
action="proses_reject.php"
method="POST">

<input
type="hidden"
name="produk_id"
value="<?= $produk['id']; ?>">

<input
type="number"
name="jumlah"
value="1"
class="form-control mb-2">

<select
name="alasan"
class="form-control mb-2">

<option>Noda</option>
<option>Bolong</option>
<option>Jahitan Lepas</option>
<option>Sablon Rusak</option>

</select>

<textarea
name="keterangan"
class="form-control mb-2"></textarea>

<button
class="btn btn-danger">

Simpan Reject

</button>

</form>

</div>

</div>

<?php } ?>

</div>

</body>
</html>